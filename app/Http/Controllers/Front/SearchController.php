<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

// class SearchController extends Controller
// {
//     protected $_responseFormat = 'view';

//     public function productSearch(Request $request)
//     {
//         $products = [];
//         $seachQuery = $request->input('search_query', null);

        // if ($seachQuery) {
        // }
        // $products = Product::search($seachQuery)->get();
//         $products = Product::getDefaultMetaData()->search($seachQuery)->get();

//         return $this->_response($products, 'Search result', 'testend.searchResult');
//     }
// }
