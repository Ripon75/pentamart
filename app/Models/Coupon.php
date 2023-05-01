<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use App\Classes\Model;
use App\Classes\Utility;
use App\Rules\NotNumeric;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table      = 'coupons';
    protected $_className = 'Coupon';


     // All view templates
     protected $_views = [
        'index'  => 'adminend.pages.couponCode.index',
        'create' => 'adminend.pages.couponCode.create',
        'edit'   => 'adminend.pages.couponCode.edit',
        'show'   => 'adminend.pages.couponCode.show'
    ];

    // All routes
    protected $_routeNames = [
        'index'  => 'admin.coupon-codes.index',
        'create' => 'admin.coupon-codes.create',
        'edit'   => 'admin.coupon-codes.edit',
        'show'   => 'admin.coupon-codes.show'
    ];

    protected $fillable = [
        'name',
        'name',
        'code',
        'status',
        'discount_type',
        'discount_amount',
        'min_cart_amount',
        'description',
        'started_at',
        'ended_at'
    ];

    protected $casts = [
        'id'              => 'integer',
        'name'            => 'string',
        'code'            => 'string',
        'status'          => 'string',
        'discount_type'   => 'string',
        'discount_amount' => 'decimal:2',
        'min_cart_amount' => 'decimal:2',
        'description'     => 'string',
        'started_at'      => 'datetime:Y-m-d H:i:s',
        'ended_at'        => 'datetime:Y-m-d H:i:s',
        'created_at'      => 'datetime:Y-m-d H:i:s',
        'updated_at'      => 'datetime:Y-m-d H:i:s',
        'deleted_at'      => 'datetime:Y-m-d H:i:s'
    ];

    public function _isActive($code)
    {
        if (!$code) {
            return false;
        }

        if (strtoupper($code) == 'MDFREE') {
            $order = Order::where('user_id', Auth::id())->first();
            if ($order) {
                return false;
            }
        }

        $now    = Carbon::now();
        $coupon = Self::where('code', $code)
            ->where('status', 'active')
            ->whereDate('started_at', '<=', $now )
            ->whereDate('ended_at', '>=', $now)->first();

        if (!$coupon) {
            return false;
        }

        return $coupon;
    }

    public function _isValidForCart($cart, $code)
    {
        $coupon = $this->_isActive($code);

        if (!$coupon) {
            return [
                'error'   => true,
                'code'    => 400,
                'message' => 'Coupon code is not valid',
                'result'  => null
            ];
        }

        $minCartValue    = $coupon->min_cart_amount;
        $cartTotalAmount = $cart->_getSubTotalAmount();
        if ($cartTotalAmount < $minCartValue) {
            return [
                'error'   => true,
                'code'    => 400,
                'message' => "Minimum cart amount without delivery charge {$minCartValue} is required",
                'result'  => null
            ];
        }

        return $coupon;
    }

    // Store or update
    public function _storeOrUpdate($request, $id = 0, $action = 'store')
    {
        // TODO: Creating Form Requests
        $obj = null;
        $rules = [];

        if ($action === 'store') {
            $rules = [
                'name'            => ['required', "unique:{$this->table}", new NotNumeric],
                'code'            => ['required'],
                'min_cart_amount' => ['required'],
                'discount_amount' => ['required'],
                'discount_type'   => ['required'],
                'started_at'      => ['required'],
                'ended_at'        => ['required'],
                'applicable_on'   => ['required']
            ];
            $request->validate($rules);
            $obj = new Self();

        } else {
            $rules = [
                'name'            => ['required', "unique:{$this->table},name,$id", new NotNumeric],
                'code'            => ['required'],
                'min_cart_amount' => ['required'],
                'discount_amount' => ['required'],
                'discount_type'   => ['required'],
                'started_at'      => ['required'],
                'ended_at'        => ['required'],
                'applicable_on'   => ['required']
            ];
            $request->validate($rules);
            $obj = Self::find($id);

            if (!$obj) { // If the product not found
                $msg = $this->_getMessage('not_found');
                return $this->_makeResponse(false, null, $msg);
            }
        }

        $name           = $request->input('name');
        $code           = $request->input('code', null);
        $status         = $request->input('status', 'inactivated');
        $discountType   = $request->input('discount_type', 'fixed');
        $discountAmount = $request->input('discount_amount', 0);
        $minCartAmount  = $request->input('min_cart_amount', 0);
        $description    = $request->input('description', null);
        $startedAt      = $request->input('started_at', null);
        $endedAt        = $request->input('ended_at', null);
        $applicableOn   = $request->input('applicable_on', null);
        $startedAt      = $startedAt ? $startedAt : Carbon::now();

        $obj->name            = $name;
        $obj->code            = $code;
        $obj->status          = $status;
        $obj->discount_type   = $discountType;
        $obj->discount_amount = $discountAmount;
        $obj->min_cart_amount = $minCartAmount;
        $obj->description     = $description;
        $obj->started_at      = $startedAt;
        $obj->ended_at        = $endedAt;
        $obj->applicable_on   = $applicableOn;
        $res                  = $obj->save();

        if ($res) {
            $action = $action === 'store' ? $action : 'update';
            $msg = $this->_getMessage($action);
            return $this->_makeResponse(true, $obj, $msg);
        } else {
            $action = $action === 'store' ? 'failed_store' : 'failed_update';
            $msg = $this->_getMessage($action);
            return $this->_makeResponse(true, $obj, $msg);
        }
    }
}
