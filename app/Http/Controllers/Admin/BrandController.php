<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $paginate      = config('crud.paginate.default');
        $searchKeyword = $request->input('search_keyword', null);

        $brands = new Brand();

        if ($searchKeyword) {
            $brands = $brands->where('name', 'like', "{$searchKeyword}%")->orWhere('status', $searchKeyword);
        }

        $brands = $brands->orderBy('created_at', 'desc')->paginate($paginate);

        return view('adminend.pages.brand.index', [
            'brands' => $brands
        ]);
    }

    public function create()
    {
        return view('adminend.pages.brand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'unique:brands,name'],
            'img_src' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
        ],
        [
            'img_src.required' => 'Image field is required'
        ]);

        $name   = $request->input('name');
        $status = $request->input('status', 'active');
        $isTop  = $request->input('is_top', null);
        $slug   = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $brand = new Brand();

            $brand->name   = $name;
            $brand->slug   = $slug;
            $brand->status = $status;
            $brand->is_top = $isTop;
            $res = $brand->save();
            if ($res) {
                if ($request->hasFile('img_src')) {
                    $imgSRC = $request->file('img_src');
                    $imgPath = Storage::put('images/brands', $imgSRC);
                    $brand->img_src = $imgPath;
                    $brand->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.brands.index')->with('message', 'Brand created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            abort(404);
        }

        return view('adminend.pages.brand.edit', [
            'brand' => $brand
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', "unique:brands,name,$id"],
        ]);

        $name   = $request->input('name');
        $status = $request->input('status', 'active');
        $isTop  = $request->input('is_top', null);
        $slug   = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $brand = Brand::find($id);

            $brand->name   = $name;
            $brand->slug   = $slug;
            $brand->status = $status;
            $brand->is_top = $isTop;
            $res = $brand->save();
            if ($res) {
                if ($request->hasFile('img_src')) {
                    $imgSRC = $request->file('img_src');
                    $oldPath = $brand->getOldPath($brand->img_src);
                    if ($oldPath) {
                        Storage::delete($oldPath);
                    }
                    $imgPath = Storage::put('images/brands', $imgSRC);
                    $brand->img_src = $imgPath;
                    $brand->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.brands.index')->with('message', 'Brand updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }
}
