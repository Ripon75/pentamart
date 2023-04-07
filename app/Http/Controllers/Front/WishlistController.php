<?php

namespace App\Http\Controllers\Front;

use Auth;
use App\Models\Wishlist;
use App\Classes\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        Utility::setUserEvent('pageView', [
            'page' => 'customer-wishlist',
        ]);

        $result  = Wishlist::with(['product'])->where('user_id', Auth::id())->get();

        return view('frontend.pages.my-wishlist', [
            'result' => $result
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required']
        ]);

        $productId = $request->input('product_id');
        $userId    = Auth::id();

        $productCheck = Wishlist::where('product_id', $productId)->where('user_id', $userId)->first();
        if ($productCheck) {
            $res = [
                'data'     => $productCheck,
                'error'    => 'Product already added to wishlist'
            ];
            return $res;
        }

        $wishlist = new Wishlist();

        $wishlist->product_id = $productId;
        $wishlist->user_id    = $userId;
        $data = $wishlist->save();

        Utility::setUserEvent('product-add-wishlist', [
            'product_id' => $productId,
        ]);

        if ($data) {
            $res = [
                'data'    => $data,
                'success' => 'Product wishlist added successfully'
            ];
            return $res;
        }
    }

    public function undo(Request $request)
    {
        $request->validate([
            'product_id' => ['required']
        ]);

        $productId = $request->input('product_id');
        $userId    = Auth::id();

        $product = Wishlist::where('product_id', $productId)->where('user_id', $userId)->first();
        if ($product) {
            $res = $product->delete();
            if ($res) {
                Utility::setUserEvent('product-removed-wishlist', [
                    'product_id' => $productId,
                ]);

                $res = ['success' => 'Product wishlist remove successfully'];
            }
            return $res;
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'item_id'      => ['required', 'integer'],
        ]);

        $itemId = $request->input('item_id');

        $result = Wishlist::find($itemId);

        if ($result) {

            Utility::setUserEvent('removed-wishlist', [
                'wishlist' => $result,
            ]);

            $result->delete();
        }

        return back()->with('success', 'Product remove successfully');
    }

    public function wishlistCount()
    {
        $wishlistObj   = Wishlist::where('user_id', Auth::id())->get();
        $wishlistCount = $wishlistObj->count();
        $wishlistCount = $wishlistCount ? $wishlistCount : 0;

        return $wishlistCount;
    }
}
