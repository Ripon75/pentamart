<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Storage;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rate'    => ['required', 'numeric'],
            'comment' => ['required']
        ]);

        $rate      = $request->input('rate', 1);
        $productId = $request->input('product_id', null);
        $comment   = $request->input('comment', null);
        $userId    = Auth::id();

        try {
            DB::beginTransaction();

            $product = Product::where('id', $productId)->where('status', 'active')->first();
            if ($product) {
                $order = Order::where('orders.user_id', $userId)
                ->join('order_item', 'orders.id', 'order_item.order_id')
                ->where('order_item.item_id', $productId)->get();
                if ($order) {
                    $rating = Rating::where('user_id', $userId)->where('product_id', $productId)->first();
                    if ($rating) {
                        $rating->rate    = $rate;
                        $rating->comment = $comment;
                        $rating->save();
                    } else {
                        $rating = new Rating;

                        $rating->user_id    = $userId;
                        $rating->rate       = $rate;
                        $rating->product_id = $productId;
                        $rating->comment    = $comment;
                        $rating->save();
                    }
                    DB::commit();
                    return back()->with('success', 'Product rated successfully');
                } else {
                    return back()->with('error', 'You can not rate this product without purchase');
                }
            } else {
                return back()->with('error', 'Product not found');
            }
        } catch (\Exception $e) {
            info($e);
            DB::commit();
            return back()->with('error', 'Something went wrong');
        }
    }
}
