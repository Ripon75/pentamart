<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $paginate      = config('crud.paginate.default');
        $searchKeyword = $request->input('search_keyword', null);

        $banners = new Banner();

        if ($searchKeyword) {
            $banners = $banners->where('position', 'like', "{$searchKeyword}%")->orWhere('title', 'like', "{$searchKeyword}%")
                ->orWhere('status', $searchKeyword);
        }

        $banners = $banners->orderBy('created_at', 'desc')->paginate($paginate);

        return view('adminend.pages.banner.index', [
            'banners' => $banners
        ]);
    }

    public function create(Request $request)
    {
        $positions = new Banner();
        $positions = $positions->positionList;

        return view('adminend.pages.banner.create', [
            'positions' => $positions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'web_file'    => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
            'mobile_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
            'title'       => ['required'],
            'status'      => ['required'],
            'position'    => ['required']
        ]);

        $preTitle      = $request->input('pre_title', null);
        $preTitleLink  = $request->input('pre_title_link', null);
        $title         = $request->input('title', null);
        $titleLink     = $request->input('title_link', null);
        $postTitle     = $request->input('post_title', null);
        $postTitleLink = $request->input('post_title_link', null);
        $boxLink       = $request->input('box_link', null);
        $position      = $request->input('position', null);
        $serial        = $request->input('serial', null);
        $caption       = $request->input('caption', null);
        $status        = $request->input('status', null);
        $bgColor       = $request->input('bg_color', null);

        $bannerObj  = new Banner();

        $bannerObj->pre_title       = $preTitle;
        $bannerObj->pre_title_link  = $preTitleLink;
        $bannerObj->title           = $title;
        $bannerObj->title_link      = $titleLink;
        $bannerObj->post_title      = $postTitle;
        $bannerObj->post_title_link = $postTitleLink;
        $bannerObj->box_link        = $boxLink;
        $bannerObj->position        = $position;
        $bannerObj->serial          = $serial;
        $bannerObj->status          = $status;
        $bannerObj->caption         = $caption;
        $bannerObj->bg_color        = $bgColor;

        // Upload banner for web
        $uploadPath = $bannerObj->_getImageUploadPath();
        if ($request->hasFile('web_file')) {
            $webFile = $request->file('web_file');
            $webPath = Storage::put($uploadPath, $webFile);
            $bannerObj->img_src = $webPath;
        }

        // Upload banner for mobile
        if ($request->hasFile('mobile_file')) {
            $mobileFile = $request->file('mobile_file');
            $mobilePath = Storage::put($uploadPath, $mobileFile);
            $bannerObj->mobile_img_src = $mobilePath;
        }

        $bannerObj->save();

        return redirect()->route('admin.banners')->with('message' , 'Banner create seccessfully');
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $banner = Banner::find($id);
        $positions = new Banner();
        $positions = $positions->positionList;

        return view('adminend.pages.banner.edit', [
            'banner'    => $banner,
            'positions' => $positions
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'web_file'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
            'mobile_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
            'title'       => ['required'],
            'status'      => ['required'],
            'position'    => ['required']
        ]);

        $preTitle      = $request->input('pre_title', null);
        $preTitleLink  = $request->input('pre_title_link', null);
        $title         = $request->input('title', null);
        $titleLink     = $request->input('title_link', null);
        $postTitle     = $request->input('post_title', null);
        $postTitleLink = $request->input('post_title_link', null);
        $boxLink       = $request->input('box_link', null);
        $position      = $request->input('position', null);
        $serial        = $request->input('serial', null);
        $caption       = $request->input('caption', null);
        $status        = $request->input('status', null);
        $bgColor       = $request->input('bg_color', null);

        $bannerObj = Banner::find($id);

        $bannerObj->pre_title       = $preTitle;
        $bannerObj->pre_title_link  = $preTitleLink;
        $bannerObj->title           = $title;
        $bannerObj->title_link      = $titleLink;
        $bannerObj->post_title      = $postTitle;
        $bannerObj->post_title_link = $postTitleLink;
        $bannerObj->box_link        = $boxLink;
        $bannerObj->position        = $position;
        $bannerObj->serial          = $serial;
        $bannerObj->status          = $status;
        $bannerObj->caption         = $caption;
        $bannerObj->bg_color        = $bgColor;

        // Upload banner for web
        $uploadPath = $bannerObj->_getImageUploadPath();
        if($request->hasFile('web_file')) {
            if (Storage::exists($bannerObj->img_src)) {
                $webOldImagePath = $bannerObj->img_src_value;
                // Delete web image
                if ($webOldImagePath) {
                    Storage::delete($webOldImagePath);
                }
            }

            $webFile = $request->file('web_file');
            $webPath = Storage::put($uploadPath, $webFile);
            $bannerObj->img_src = $webPath;
        }

        // Upload banner for mobile
        if($request->hasFile('mobile_file')) {
            if (Storage::exists($bannerObj->mobile_img_src)) {
                $mobileOldImagePath = $bannerObj->mobile_img_src_value;
                // Delete mobile image
                if ($mobileOldImagePath) {
                    Storage::delete($mobileOldImagePath);
                }
            }

            $mobileFile = $request->file('mobile_file');
            $mobilePath = Storage::put($uploadPath, $mobileFile);
            $bannerObj->mobile_img_src = $mobilePath;
        }
        $bannerObj->save();

        return redirect()->route('admin.banners')->with('message' , 'Banner update seccessfully');
    }

    public function destroy($id)
    {
        //
    }
}
