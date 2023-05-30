<?php

namespace App\Http\Controllers\Front;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
class WishlistController extends Controller
{
    public function index()
    {
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
                $this->sendResponse(null, 'Product wishlist remove successfully');
            }
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
