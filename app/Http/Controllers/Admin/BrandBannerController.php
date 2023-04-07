<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\BrandBnner;
use Storage;
use File;

class BrandBannerController extends Controller
{
    public function index(Request $request)
    {
        $paginate = config('crud.paginate.default');

        $banners = BrandBnner::paginate($paginate);

        return view('adminend.pages.brandBanner.index', [
            'banners' => $banners
        ]);
    }

    public function create(Request $request)
    {
        return view('adminend.pages.brandBanner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => ['required'],
            'name'    => ['required'],
            'status'  => ['required'],
            'link'    => ['required'],
            'file'    => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg']
        ]);

        $name   = $request->input('name', null);
        $slug   = $slug = Str::slug($name, '-');
        $title  = $request->input('title', null);
        $status = $request->input('status', null);
        $link   = $request->input('link', null);

        $bannerObj = new BrandBnner();

        $bannerObj->name   = $name;
        $bannerObj->slug   = $slug;
        $bannerObj->title  = $title;
        $bannerObj->status = $status;
        $bannerObj->link   = $link;

        if ($request->hasFile('file')) {

            $file       = $request->file('file');
            $uploadPath = $bannerObj->_getImageUploadPath();
            $path       = Storage::put($uploadPath, $file);

            $bannerObj->img_src = $path;
        }
        $bannerObj->save();

        return redirect()->route('admin.brand.banners')->with('message' , 'Banner create seccessfully');
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $banner = BrandBnner::find($id);

        return view('adminend.pages.brandBanner.edit', [
            'banner' => $banner
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => ['required'],
            'name'    => ['required'],
            'status'  => ['required'],
            'link'    => ['required'],
            'file'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg']
        ]);

        $name   = $request->input('name', null);
        $slug   = $slug = Str::slug($name, '-');
        $title  = $request->input('title', null);
        $status = $request->input('status', null);
        $link   = $request->input('link', null);

        $banner = BrandBnner::find($id);

        $banner->name   = $name;
        $banner->slug   = $slug;
        $banner->title  = $title;
        $banner->status = $status;
        $banner->link   = $link;

        if ($request->hasFile('file')) {
            $oldImagePath = $banner->img_src_value;
            if ($oldImagePath) {
                Storage::delete($oldImagePath);
            }

            $file       = $request->file('file');
            $uploadPath = $banner->_getImageUploadPath();
            $path       = Storage::put($uploadPath, $file);

            $banner->img_src = $path;
        }
        $banner->save();

        return redirect()->route('admin.brand.banners')->with('message' , 'Banner updated seccessfully');
    }

    public function destroy($id)
    {
        //
    }
}
