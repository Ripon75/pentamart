<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponCodeController extends Controller
{
    protected $_responseFormat = 'view';

    function __construct()
    {
        $this->modelObj = new Coupon();
    }

    public function index(Request $request)
    {
        $paginate     = config('crud.paginate.default');
        $name         = $request->input('name', null);
        $code         = $request->input('code', null);
        $discountType = $request->input('discount_type', null);
        $status       = $request->input('status', null);

        $coupons = new Coupon();

        if ($name) {
            $coupons = $coupons->where('name', 'like', "{$name}%");
        }

        if ($code) {
            $coupons = $coupons->where('code', $code);
        }

        if ($status) {
            $coupons = $coupons->where('status', $status);
        }

        if ($discountType) {
            $coupons = $coupons->where('discount_type', 'like', "{$discountType}%");
        }

        $coupons = $coupons->orderBy('created_at', 'desc')->paginate($paginate);

        return view('adminend.pages.couponCode.index', [
            'coupons' => $coupons
        ]);
    }

    public function create(Request $request)
    {
        $applicableOn = config('coupon.applicable_on');
        $view = $this->modelObj->_getView('create');

        return view($view, [
            'applicableOn' => $applicableOn
        ]);
    }

    public function edit(Request $request, $id)
    {
        $result       = $this->modelObj->_show($id);
        $applicableOn = config('coupon.applicable_on');
        $view         = $this->modelObj->_getView('edit');

        return view($view, [
            'data'         => $result['data'],
            'applicableOn' => $applicableOn
        ]);
    }
}
