<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DosageForm;


class DosageFormController extends Controller
{
    protected $_responseFormat = 'view';

    function __construct()
    {
        $this->modelObj = new DosageForm();
    }

    public function index(Request $request)
    {
        $paginate      = config('crud.paginate.default');
        $searchKeyword = $request->input('search_keyword', null);

        $dosageForms = new DosageForm();

        if ($searchKeyword) {
            $dosageForms = $dosageForms->where('name', 'like', "{$searchKeyword}%")->orWhere('status', $searchKeyword);
        }

        $dosageForms = $dosageForms->paginate($paginate);

        return view('adminend.pages.dosageForm.index', [
            'dosageForms' => $dosageForms
        ]);
    }

    public function create(Request $request)
    {
        $view = $this->modelObj->_getView('create');

        $parents = DosageForm::select('id', 'name')->get();

        return view($view, [
            'parents' => $parents
        ]);
    }

    public function edit(Request $request, $id)
    {
        $result  = $this->modelObj->_show($id);
        $parents = DosageForm::select('id', 'name')->get();
        $view    = $this->modelObj->_getView('edit');

        return view($view, $result, [
            'parents' => $parents
        ]);
    }
}
