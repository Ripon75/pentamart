<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function checkCouponCode(Request $request)
    {
        $couponCode = $request->input('coupon_code', null);
        $couponCode = Str::of($couponCode)->trim();

        if (!$couponCode) {
            return $this->sendError('Coupon code not found');
        }

        $cartObj = new Cart();
        $cart    = $cartObj->getCurrentCustomerCart();

        $now    = Carbon::now();
        $coupon = Coupon::where('code', $couponCode)
            ->where('status', 'active')
            ->whereDate('started_at', '<=', $now)
            ->whereDate('ended_at', '>=', $now)->first();

        if (!$coupon) {
            return $this->sendError('Invalid coupon code');
        }

        $minCartValue    = $coupon->min_cart_amount;
        $cartTotalAmount = $cart->getTotalSellPrice();
        if ($cartTotalAmount < $minCartValue) {
            $msg = "Minimum cart amount without delivery charge {$minCartValue} is required";
            return $this->sendError($msg);
        }

        return $this->sendResponse($coupon, 'Coupon information');
    }
}
