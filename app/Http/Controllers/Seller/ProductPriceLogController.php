<?php

namespace App\Http\Controllers\Seller;

use Auth;
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

        $productPriceLogs = $productPriceLogs->where('product_id', $productId)->where('user_id', Auth::id());

        $data = $productPriceLogs->orderBy('id', 'desc')->paginate($paginate);
        

        return view('sellercenter.pages.logs.product-price-logs', [
            'productPriceLogs' => $data
        ]);
    }
}
