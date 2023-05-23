<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
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

    public function create()
    {
        return view('adminend.pages.coupon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => ['required', "unique:coupons,name"],
            'code'            => ['required'],
            'min_cart_amount' => ['required'],
            'discount_amount' => ['required'],
            'discount_type'   => ['required'],
            'started_at'      => ['required'],
            'ended_at'        => ['required']
        ]);

        try {
            DB::beginTransaction();

            $name           = $request->input('name');
            $code           = $request->input('code', null);
            $status         = $request->input('status', 'active');
            $discountType   = $request->input('discount_type', 'fixed');
            $discountAmount = $request->input('discount_amount', 0);
            $minCartAmount  = $request->input('min_cart_amount', 0);
            $description    = $request->input('description', null);
            $startedAt      = $request->input('started_at', null);
            $endedAt        = $request->input('ended_at', null);
            $startedAt      = $startedAt ? $startedAt : Carbon::now();

            $coupon = new Coupon();

            $coupon->name            = $name;
            $coupon->code            = $code;
            $coupon->status          = $status;
            $coupon->discount_type   = $discountType;
            $coupon->discount_amount = $discountAmount;
            $coupon->min_cart_amount = $minCartAmount;
            $coupon->description     = $description;
            $coupon->started_at      = $startedAt;
            $coupon->ended_at        = $endedAt;
            $res = $coupon->save();
            if ($res) {
                DB::commit();
                return redirect()->route('admin.coupons.index')->with("Coupon created successfully");
            }
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('Something went wrong');
        }
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        if (!$coupon) {
            abort(404);
        }

        return view('adminend.pages.coupon.edit', [
            'coupon' => $coupon
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'            => ['required', "unique:coupons,name,$id"],
            'code'            => ['required'],
            'min_cart_amount' => ['required'],
            'discount_amount' => ['required'],
            'discount_type'   => ['required'],
            'started_at'      => ['required'],
            'ended_at'        => ['required']
        ]);

        try {
            DB::beginTransaction();

            $name           = $request->input('name');
            $code           = $request->input('code', null);
            $status         = $request->input('status', 'active');
            $discountType   = $request->input('discount_type', 'fixed');
            $discountAmount = $request->input('discount_amount', 0);
            $minCartAmount  = $request->input('min_cart_amount', 0);
            $description    = $request->input('description', null);
            $startedAt      = $request->input('started_at', null);
            $endedAt        = $request->input('ended_at', null);
            $startedAt      = $startedAt ? $startedAt : Carbon::now();

            $coupon = Coupon::find($id);

            $coupon->name            = $name;
            $coupon->code            = $code;
            $coupon->status          = $status;
            $coupon->discount_type   = $discountType;
            $coupon->discount_amount = $discountAmount;
            $coupon->min_cart_amount = $minCartAmount;
            $coupon->description     = $description;
            $coupon->started_at      = $startedAt;
            $coupon->ended_at        = $endedAt;
            $res = $coupon->save();
            if ($res) {
                DB::commit();
                return redirect()->route('admin.coupons.index')->with("Coupon updated successfully");
            }
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('Something went wrong');
        }
    }
}
