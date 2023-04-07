<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductPack;
use App\Models\Product;
use App\Models\UOM;

class ProductPackController extends Controller
{
    protected $_responseFormat = 'view';

    function __construct()
    {
        $this->modelObj = new ProductPack();
    }

    public function create(Request $request)
    {
        $view     = $this->modelObj->_getView('create');
        $products = Product::select('id', 'name')->get();
        $uoms     = UOM::select('id', 'name')->get();

        return view($view, [
            'products' => $products,
            'uoms'     => $uoms
        ]);
    }

    public function edit(Request $request, $id)
    {
        $result  = $this->modelObj->_show($id);
        $products = Product::select('id', 'name')->get();
        $uoms     = UOM::select('id', 'name')->get();
        $view    = $this->modelObj->_getView('edit');

        return view($view, $result, [
            'products' => $products,
            'uoms'     => $uoms
        ]);
    }
}
