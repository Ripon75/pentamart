<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    protected $_responseFormat = 'view';

    function __construct()
    {
        $this->modelObj = new Company();
    }

    public function index(Request $request)
    {
        $paginate      = config('crud.paginate.default');
        $searchKeyword = $request->input('search_keyword', null);

        $companies = new Company();

        if ($searchKeyword) {
            $companies = $companies->where('name', 'like', "{$searchKeyword}%");
        }

        $companies = $companies->paginate($paginate);

        return view('adminend.pages.company.index', [
            'companies' => $companies
        ]);
    }

    public function create(Request $request)
    {
        $view = $this->modelObj->_getView('create');

        $parents = Company::select('id', 'name')->get();

        return view($view, [
            'parents' => $parents
        ]);
    }

    public function edit(Request $request, $id)
    {
        $result  = $this->modelObj->_show($id);
        $parents = Company::select('id', 'name')->get();
        $view    = $this->modelObj->_getView('edit');

        return view($view, $result, [
            'parents' => $parents
        ]);
    }
}
