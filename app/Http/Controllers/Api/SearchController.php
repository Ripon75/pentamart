<?php

namespace App\Http\Controllers\Api;

// Model
use App\Models\User;
use App\Models\Product;
use App\Classes\Utility;
use App\Models\SearchLog;
use App\Models\Address;
// Event
use Illuminate\Http\Request;
use App\Events\ProductSearch;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    protected $_responseFormat = 'json';

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

        return $this->_response($products, 'Search result');
    }

    public function testResult(Request $request)
    {
        $searchKey = $request->input('search_key', null);
        $limit     = $request->input('limit', 10);
        $limit     = $limit ? $limit : 10;
        $products  = Product::select('name as label', 'id as value')->where('name', 'like', "{$searchKey}%")->take($limit)->get();

        return response()->json($products);
    }

    public function userSearch(Request $request)
    {
        $phoneNumber = $request->input('phone_number', null);

        if ($phoneNumber) {
            $user = User::where('phone_number', 'like', "%{$phoneNumber}%")->get();
            return $this->_response($user, 'Search result');
        }
    }

    public function userAddress(Request $request)
    {
        $userId = $request->input('user_id', null);

        if ($userId) {
            $addresses = Address::where('user_id', $userId)->get();

            return $this->_response($addresses, 'Search result');
        }
    }

    public function checkOfferQty(Request $request)
    {
        $productId = $request->input('product_id', null);
        $quantity  = $request->input('quantity', null);

        if (!$productId && $quantity) {
            return false;
        }

        $utility = new Utility ();

        return $utility->checkOffer($productId, $quantity);
    }
}
