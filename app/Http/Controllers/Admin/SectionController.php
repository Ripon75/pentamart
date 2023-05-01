<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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

    public function create(Request $request)
    {
        $products = Product::where('status', 'activated')->get();

        return view('adminend.pages.section.create', [
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => ['required'],
            'title'      => ['required'],
            'productIDs' => ['required']
        ],
        [
            'productIDs.required' => 'The Products field is required'
        ]);

        $name       = $request->input('name', null);
        $slug       = Str::slug($name, '-');
        $title      = $request->input('title', null);
        $link       = $request->input('link', null);
        $status     = $request->input('status', null);
        $productIDs = $request->input('productIDs', []);

        $sectionObj = new Section();

        $sectionObj->name  = $name;
        $sectionObj->slug  = $slug;
        $sectionObj->title = $title;
        $sectionObj->link  = $link;
        $sectionObj->status = $status;
        $res = $sectionObj->save();
        if ($res) {
            $sectionObj->products()->sync($productIDs);
        }

        return redirect()->route('admin.sections.index')->with('message', 'Section created successfully');
    }

    public function edit(Request $request, $id)
    {
        $section            = Section::with(['products'])->find($id);
        $selectedProductIDs = Arr::pluck($section->products, 'id');
        $products           = Product::where('status', 'active')->get();

        return view('adminend.pages.section.edit', [
            'section'            => $section,
            'products'           => $products,
            'selectedProductIDs' => $selectedProductIDs
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => ['required'],
            'title'      => ['required'],
            'productIDs' => ['required']
        ],
        [
            'productIDs.required' => 'The Products field is required'
        ]);

        $name       = $request->input('name', null);
        $slug       = Str::slug($name, '-');
        $title      = $request->input('title', null);
        $link       = $request->input('link', null);
        $status     = $request->input('status', null);
        $productIDs = $request->input('productIDs', []);

        $sectionObj = Section::find($id);

        $sectionObj->name  = $name;
        $sectionObj->slug  = $slug;
        $sectionObj->title = $title;
        $sectionObj->link  = $link;
        $sectionObj->status = $status;
        $res = $sectionObj->save();
        if ($res) {
            $sectionObj->products()->sync($productIDs);
        }

        return redirect()->route('admin.sections.index')->with('message', 'Section updated successfully');
    }
}
