<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $defaultPaginate = config('crud.paginate.default');

        $sliders = Slider::orderBy('created_at', 'desc')->paginate($defaultPaginate);

        return view('adminend.pages.slider.index', [
            'sliders' => $sliders
        ]);
    }

    public function create(Request $request)
    {
        return view('adminend.pages.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name'           => ['required'],
                'web_img_src'    => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
                'mobile_img_src' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
            ],
            [
                'web_img_src.required' => 'Image field is required',
                'mobile_img_src.required' => 'Image field is required',
            ]
        );

        $name   = $request->input('name');
        $status = $request->input('status', 'active');
        $slug   = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $brand = new Slider;

            $brand->name   = $name;
            $brand->slug   = $slug;
            $brand->status = $status;
            $res = $brand->save();
            if ($res) {
                if ($request->hasFile('web_img_src') && $request->hasFile('mobile_img_src') ) {
                    $webImgSrc             = $request->file('web_img_src');
                    $mobileImgSrc          = $request->file('mobile_img_src');
                    $webImgPath            = Storage::put('images/sliders', $webImgSrc);
                    $mobileImgPath         = Storage::put('images/sliders', $mobileImgSrc);
                    $brand->web_img_src    = $webImgPath;
                    $brand->mobile_img_src = $mobileImgPath;
                    $brand->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.sliders.index')->with('message', 'Slider created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            abort(404);
        }

        return view('adminend.pages.slider.edit', [
            'slider' => $slider
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $name   = $request->input('name');
        $status = $request->input('status', 'active');
        $slug   = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $slider = Slider::find($id);

            $slider->name   = $name;
            $slider->slug   = $slug;
            $slider->status = $status;
            $res = $slider->save();
            if ($res) {
                // Update web image
                if ($request->hasFile('web_img_src')) {
                    $webImgSRC = $request->file('web_img_src');
                    $oldImgPath = $slider->getOldPath($slider->web_img_src);
                    if ($oldImgPath) {
                        Storage::delete($oldImgPath);
                    }
                    $webImgPath = Storage::put('images/sliders', $webImgSRC);
                    $slider->web_img_src = $webImgPath;
                    $slider->save();
                }

                // Update mobile image
                if ($request->hasFile('mobile_img_src')) {
                    $mobileImgSRC = $request->file('mobile_img_src');
                    $oldImgPath = $slider->getOldPath($slider->mobile_img_src);
                    if ($oldImgPath) {
                        Storage::delete($oldImgPath);
                    }
                    $mobileImgPath = Storage::put('images/sliders', $mobileImgSRC);
                    $slider->mobile_img_src = $mobileImgPath;
                    $slider->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.sliders.index')->with('message', 'Slider updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }
}
