<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Events\ProductSearch;
use App\Http\Controllers\Controller;
class SearchController extends Controller
{
    public function productSearch(Request $request)
    {
        $products = [];
        $seachQuery = $request->input('search_query', null);
        $seachLimit = $request->input('search_limit', null);
        $seachLimit = (int) $seachLimit;

        if ($seachQuery) {
            $products = Product::search($seachQuery)
            ->query(fn ($query) => $query->with([
                    'brand:id,slug,name',
                    'category:id,name,slug',
                    'colors:id,name',
                    'sizes:id,name'
                ])->where('status', 'active')
            );
        }

        if ($seachLimit) {
            $seachLimit = $seachLimit > 100 ? 100 : $seachLimit;
            $products = $products->take($seachLimit);
        }

        $products = $products->get();
        $resultCount = count($products);

        ProductSearch::dispatch($seachQuery, $resultCount);

        return $this->sendResponse($products, 'Search result');
    }

    public function userSearch(Request $request)
    {
        $phoneNumber = $request->input('phone_number', null);

        if ($phoneNumber) {
            $user = User::where('phone_number', 'like', "%{$phoneNumber}%")->get();
            return $this->sendResponse($user, 'Search result');
        }
    }

    public function addressSearch(Request $request)
    {
        $userId = $request->input('user_id', null);

        if ($userId) {
            $addresses = Address::where('user_id', $userId)->get();

            return $this->sendResponse($addresses, 'Search result');
        }
    }
}
