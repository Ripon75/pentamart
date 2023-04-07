<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductPriceLog;
use App\Http\Controllers\Controller;

class ProductPriceLogController extends Controller
{
    public function index(Request $request)
    {
        $productId = $request->input('product_id', null);

        $paginate = config('crud.paginate.default');

        $productPriceLogs = new ProductPriceLog();

        if ($productId) {
            $productPriceLogs = $productPriceLogs->where('product_id', $productId);
        }

        $data = $productPriceLogs->orderBy('id', 'desc')->paginate($paginate);

        return view('adminend.pages.logs.product-price-logs', [
            'productPriceLogs' => $data
        ]);
    }
}
