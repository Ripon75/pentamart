<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $paginate      = config('crud.paginate.default');
        $searchKeyword = $request->input('search_keyword', null);

        $sections = new Section();

        if ($searchKeyword) {
            $sections = $sections->where('title', 'like', "{$searchKeyword}%")->orWhere('status', $searchKeyword)
                ->orWhere('name', 'like', "{$searchKeyword}%");
        }

        $sections = $sections->paginate($paginate);

        return view('adminend.pages.section.index', [
            'sections' => $sections
        ]);
    }

    public function create()
    {
        $products = Product::where('status', 'active')->get();

        return view('adminend.pages.section.create', [
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => ['required'],
            'productIds' => ['required']
        ],
        [
            'productIds.required' => 'The Products field is required'
        ]);

        $name       = $request->input('name', null);
        $slug       = Str::slug($name, '-');
        $status     = $request->input('status', null);
        $productIds = $request->input('productIds', []);

        try {
            DB::beginTransaction();

            $section = new Section();

            $section->name   = $name;
            $section->slug   = $slug;
            $section->status = $status;
            $res = $section->save();
            if ($res) {
                $section->products()->sync($productIds);
                DB::commit();
            }
            return redirect()->route('admin.sections.index')->with('success', 'Section created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $section = Section::with(['products'])->find($id);
        if (!$section) {
            abort(404);
        }

        $selectedProductIds = Arr::pluck($section->products, 'id');
        $products           = Product::where('status', 'active')->get();

        return view('adminend.pages.section.edit', [
            'section'            => $section,
            'products'           => $products,
            'selectedProductIds' => $selectedProductIds
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => ['required'],
            'productIds' => ['required']
        ],
        [
            'productIds.required' => 'The Products field is required'
        ]);

        $name       = $request->input('name', null);
        $slug       = Str::slug($name, '-');
        $status     = $request->input('status', null);
        $productIds = $request->input('productIds', []);

        try {
            DB::beginTransaction();

            $section = Section::find($id);

            $section->name   = $name;
            $section->slug   = $slug;
            $section->status = $status;
            $res = $section->save();
            if ($res) {
                $section->products()->sync($productIds);
                DB::commit();
            }

            return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }
}
