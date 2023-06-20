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
                'name'    => ['required'],
                'img_src' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
            ],
            [
                'img_src.required' => 'Image field is required',
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
                if ($request->hasFile('img_src') ) {
                    $imgSrc         = $request->file('img_src');
                    $imgPath        = Storage::put('images/sliders', $imgSrc);
                    $brand->img_src = $imgPath;
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
                if ($request->hasFile('img_src')) {
                    $imgSRC = $request->file('img_src');
                    $oldPath = $slider->getOldPath($slider->img_src);
                    if ($oldPath) {
                        Storage::delete($oldPath);
                    }
                    $imgPath = Storage::put('images/sliders', $imgSRC);
                    $slider->img_src = $imgPath;
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
