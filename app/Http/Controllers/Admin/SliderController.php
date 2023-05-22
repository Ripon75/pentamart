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
                'name'      => ['required'],
                'large_src' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
                'small_src' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
            ],
            [
                'large_src.required' => 'Image field is required',
                'small_src.required' => 'Image field is required'
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
                if ($request->hasFile('large_src') &&  $request->hasFile('small_src')) {
                    $largeSRC         = $request->file('large_src');
                    $smallSRC         = $request->file('small_src');
                    $largePath        = Storage::put('images/sliders', $largeSRC);
                    $smallPath        = Storage::put('images/sliders', $smallSRC);
                    $brand->large_src = $largePath;
                    $brand->small_src = $smallPath;
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

    public function edit(Request $request, $id)
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
                if ($request->hasFile('large_src')) {
                    $largeSRC = $request->file('large_src');
                    $oldPath = $slider->getOldPath($slider->large_src);
                    if ($oldPath) {
                        Storage::delete($oldPath);
                    }
                    $largePath = Storage::put('images/sliders', $largeSRC);
                    $slider->large_src = $largePath;
                    $slider->save();
                }
                if ($request->hasFile('small_src')) {
                    $smallSRC = $request->file('small_src');
                    $oldPath = $slider->getOldPath($slider->small_src);
                    if ($oldPath) {
                        Storage::delete($oldPath);
                    }
                    $smallPath = Storage::put('images/sliders', $smallSRC);
                    $slider->small_src = $smallPath;
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
