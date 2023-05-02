<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $paginate  = config('crud.paginate.default');
        $searchKey = $request->input('search_keyword', null);

        $categories = new Category();

        if ($searchKey) {
            $categories = $categories->where('name', 'like', "{$searchKey}%")->orWhere('status', $searchKey);
        }

        $categories = $categories->orderBy('created_at', 'desc')->paginate($paginate);

        return view('adminend.pages.category.index', [
            'categories' => $categories
        ]);
    }

    public function create(Request $request)
    {
        return view('adminend.pages.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'unique:categories,name'],
            'img_src' => ['required']
        ]);

        $name   = $request->input('name');
        $status = $request->input('status', 'active');
        $isTop  = $request->input('is_top', null);
        $slug   = Str::slug($name, '-');

        try {
            DB::beginTransaction();

           $category = new Category;

            $category->name   = $name;
            $category->slug   = $slug;
            $category->status = $status;
            $category->is_top = $isTop;
            $res = $category->save();
            if ($res) {
                if ($request->hasFile('img_src')) {
                    $imgSRC = $request->file('img_src');
                    $imgPath = Storage::put('images/categories', $imgSRC);
                    $category->img_src = $imgPath;
                    $category->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.categories.index')->with('message', 'Category created successfully');
        } catch (\Exception $e) {
            info($e);
            return back()->with('error', 'Something went wrong');
        }
    }

    public function edit(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            abort(404);
        }

        return view('adminend.pages.category.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', "unique:categories,name,$id"],
        ]);

        $name   = $request->input('name');
        $status = $request->input('status', 'active');
        $isTop  = $request->input('is_top', null);
        $slug   = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $category = Category::find($id);

            $category->name   = $name;
            $category->slug   = $slug;
            $category->status = $status;
            $category->is_top = $isTop;
            $res = $category->save();
            if ($res) {
                if ($request->hasFile('img_src')) {
                    $imgSRC = $request->file('img_src');
                    $oldPath = $category->getOldPath($category->img_src);
                    if ($oldPath) {
                        Storage::delete($oldPath);
                    }
                    $imgPath = Storage::put('images/categories', $imgSRC);
                    $category->img_src = $imgPath;
                    $category->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.categories.index')->with('message', 'Category updated successfully');
        } catch (\Exception $e) {
            info($e);
            return back()->with('error', 'Something went wrong');
        }
    }
}
