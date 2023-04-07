<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Generic;

class GenericController extends Controller
{
    protected $_responseFormat = 'view';

    function __construct()
    {
        $this->modelObj = new Generic();
    }

    public function index(Request $request)
    {
        $paginate      = config('crud.paginate.default');
        $searchKeyword = $request->input('search_keyword', null);

        $generics = new Generic();

        if ($searchKeyword) {
            $generics = $generics->where('name', 'like', "{$searchKeyword}%")->orWhere('strength', $searchKeyword);
        }

        $generics = $generics->paginate($paginate);

        return view('adminend.pages.generic.index', [
            'generics' => $generics
        ]);
    }
}
