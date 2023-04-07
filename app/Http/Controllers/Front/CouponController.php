<?php

namespace App\Http\Controllers\Front;

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
            return false;
        }

        $cartObj = new Cart();
        $cart    = $cartObj->_getCurrentCustomerCart();

        $couponObj = new Coupon();
        return $couponObj->_isValidForCart($cart, $couponCode);
    }
}
