<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    protected $_responseFormat = 'view';

    function __construct()
    {
        $this->modelObj = new Brand();
    }

    public function index(Request $request)
    {
        $paginate      = config('crud.paginate.default');
        $searchKeyword = $request->input('search_keyword', null);

        $brands = new Brand();

        if ($searchKeyword) {
            $brands = $brands->where('name', 'like', "{$searchKeyword}%")->orWhere('status', $searchKeyword);
        }

        $brands = $brands->paginate($paginate);

        return view('adminend.pages.brand.index', [
            'brands' => $brands
        ]);
    }

    public function create(Request $request)
    {
        $view = $this->modelObj->_getView('create');

        $companies = Company::select('id', 'name')->get();

        return view($view, [
            'companies' => $companies
        ]);
    }

    public function edit(Request $request, $id)
    {
        $result    = $this->modelObj->_show($id);
        $companies = Company::select('id', 'name')->get();
        $view      = $this->modelObj->_getView('edit');

        return view($view, $result, [
            'companies' => $companies
        ]);
    }
}
