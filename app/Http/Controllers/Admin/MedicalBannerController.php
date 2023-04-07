<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalBanner;
use Storage;

class MedicalBannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = MedicalBanner::get();

        return view('adminend.pages.medicalDeviceBanner.index', [
            'banners' => $banners
        ]);
    }

    public function create(Request $request)
    {
        return view('adminend.pages.medicalDeviceBanner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file'   => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
            'title'  => ['required'],
            'status' => ['required'],
            'link'   => ['required']
        ]);

        $bgColor     = $request->input('bg_color', null);
        $preTitle    = $request->input('pre_title', null);
        $title       = $request->input('title', null);
        $postTitle   = $request->input('post_title', null);
        $status      = $request->input('status', null);
        $link        = $request->input('link', null);

        $bannerObj  = new MedicalBanner();

        $bannerObj->bg_color    = $bgColor;
        $bannerObj->pre_title   = $preTitle;
        $bannerObj->title       = $title;
        $bannerObj->post_title  = $postTitle;
        $bannerObj->status      = $status;
        $bannerObj->link        = $link;

        if ($request->hasFile('file')) {

            $file       = $request->file('file');
            $uploadPath = $bannerObj->_getImageUploadPath();
            $path       = Storage::put($uploadPath, $file);

            $bannerObj->img_src = $path;
        }
        $bannerObj->save();

        return redirect()->route('admin.medical.device.banners')->with('message' , 'Banner create seccessfully');
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $banner = MedicalBanner::find($id);

        return view('adminend.pages.medicalDeviceBanner.edit', [
            'banner' => $banner
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
            'title'  => ['required'],
            'status' => ['required'],
            'link'   => ['required']
        ]);

        $bgColor     = $request->input('bg_color', null);
        $preTitle    = $request->input('pre_title', null);
        $title       = $request->input('title', null);
        $postTitle   = $request->input('post_title', null);
        $status      = $request->input('status', null);
        $link        = $request->input('link', null);

        $banner = MedicalBanner::find($id);

        $banner->bg_color    = $bgColor;
        $banner->pre_title   = $preTitle;
        $banner->title       = $title;
        $banner->post_title  = $postTitle;
        $banner->status      = $status;
        $banner->link        = $link;

        if($request->hasFile('file')) {
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

        return redirect()->route('admin.medical.device.banners')->with('message' , 'Banner update seccessfully');
    }

    public function destroy($id)
    {
        //
    }
}
