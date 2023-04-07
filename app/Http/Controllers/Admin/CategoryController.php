<?php

namespace App\Http\Controllers\Admin;

use App\Models\Family;
use App\Models\Company;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    protected $_responseFormat = 'view';
    function __construct()
    {
        $this->modelObj = new Category();
    }

    public function index(Request $request)
    {
        $paginate  = config('crud.paginate.default');
        $searchKey = $request->input('search_keyword', null);

        $categories = new Category();

        if ($searchKey) {
            $categories = $categories->where('name', 'like', "{$searchKey}%")->orWhere('status', $searchKey);
        }

        $categories = $categories->orderBy('name', 'asc')->paginate($paginate);

        return view('adminend.pages.category.index', [
            'categories' => $categories
        ]);
    }

    public function create(Request $request)
    {
        $view = $this->modelObj->_getView('create');

        $attributes = Attribute::get();
        $companies  = Company::get();
        $families   = Family::get();
        $parents    = Category::select('id', 'name')->get();

        return view($view, [
            'parents'    => $parents,
            'families'   => $families,
            'attributes' => $attributes,
            'companies'  => $companies
        ]);
    }

    public function edit(Request $request, $id)
    {
        $result     = $this->modelObj->_show($id);
        $parents    = Category::select('id', 'name')->get();
        $families   = Family::get();
        $attributes = Attribute::get();
        $companies  = Company::get();
        $view       = $this->modelObj->_getView('edit');

        return view($view, $result, [
            'parents'    => $parents,
            'families'   => $families,
            'attributes' => $attributes,
            'companies'  => $companies
        ]);
    }
}
