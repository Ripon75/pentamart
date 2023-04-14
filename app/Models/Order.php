<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\BaseStatusMap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements Auditable
{
    use HasFactory, BaseStatusMap;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'delivery_type_id',
        'payment_method_id',
        'shipping_address_id',
        'terms_and_condition',
        'note'
    ];

    protected $casts = [
        'id'                  => 'integer',
        'user_id'             => 'integer',
        'delivery_type_id'    => 'integer',
        'payment_method_id'   => 'integer',
        'shipping_address_id' => 'integer',
        'terms_and_condition' => 'string',
        'current_status_id'   => 'integer',
        'note'                => 'string',
        'current_status_at'   => 'datetime:Y-m-d H:i:s',
        'ordered_at'          => 'date:Y-m-d',
        'created_at'          => 'datetime:Y-m-d H:i:s',
        'updated_at'          => 'datetime:Y-m-d H:i:s',
        'deleted_at'          => 'datetime:Y-m-d H:i:s'
    ];

    function __construct()
    {
        $this->initStatusMap('order');
    }

    // Start relation
    public function items()
    {
        return $this->belongsToMany(Product::class, 'order_item', 'order_id', 'item_id')
            ->withPivot('quantity', 'pack_size', 'item_mrp', 'price', 'discount', 'status', 'pos_product_id')
            ->withTimestamps();
    }

    public function status()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_status_map', 'order_id', 'status_id')
                    ->withPivot('created_by_id', 'created_at')->orderBy('order_status_map.created_at', 'asc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryGateway()
    {
        return $this->belongsTo(DeliveryGateway::class, 'delivery_type_id', 'id');
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_method_id', 'id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id', 'id');
    }

    public function currentStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'current_status_id', 'id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'order_id', 'id');
    }

    public function transaction()
    {
        return $this->hasOne(PaymentTransaction::class, 'order_id', 'id');
    }

    public function setStatus($status, $orderDatetime = null)
    {
        $statusObj = null;
        if(is_numeric($status)) {
            $statusObj = OrderStatus::find($status);
        } else {
            $statusObj = OrderStatus::where('slug', $status)->first();
        }

        if (!$statusObj) {
            return false;
        }

        $userId   = Auth::id();
        $now      = $orderDatetime ?? Carbon::now();
        $statusId = $statusObj->id;

        $this->status()->attach([
            $statusId => [
                'created_by_id' => $userId,
                'created_at'    => $now
            ]
        ]);

        $this->current_status_id = $statusId;
        $this->current_status_at = $now;
        $this->save();
    }
    // End relation

    // Helper function
    public function _getCouponValue()
    {
        $couponAmount = 0;

        if ($this->coupon_id) {
            $coupon = Coupon::find($this->coupon_id);
            if ($coupon) {
                // Check coupon code applied on delivery charge
                if ($coupon->applicable_on === 'delivery_fee') {
                    $couponAmount = 0;
                }
                // Check coupon code applied on cart
                if ($coupon->applicable_on === 'cart') {
                    if ($coupon->discount_type == 'fixed') {
                        $couponAmount = $coupon->discount_amount;
                    } else {
                        $itemsSubtotalAmount = $this->_getSubTotalAmount();
                        $couponPercent       = $coupon->discount_amount;
                        $couponAmount        = ($couponPercent * $itemsSubtotalAmount)/100;
                    }
                }
                // Check coupon code applied on product
                if ($coupon->applicable_on === 'products' && $coupon->discount_type === 'percentage') {
                    foreach ($this->items as $item) {
                        $itemMRP      = $item->pivot->item_mrp;
                        $itemDiscount = $item->pivot->discount;
                        $itemQuantity = $item->pivot->quantity;
                        $itemDiscountPercent = ($itemDiscount * 100) / $itemMRP;
                        $couponDiscountPercent = $coupon->discount_amount;
                        if ($itemDiscountPercent < $couponDiscountPercent) {
                            $itemDiscountCalculate = ($itemMRP * $couponDiscountPercent) /100;
                            $itemDiscountCalculate = $itemDiscountCalculate * $itemQuantity;
                            $couponAmount += $itemDiscountCalculate;
                        } else {
                            $itemDiscountCalculate = ($itemMRP * $itemDiscountPercent) /100;
                            $itemDiscountCalculate = $itemDiscountCalculate * $itemQuantity;
                            $couponAmount += $itemDiscountCalculate;
                        }
                    }
                }
            }
        }
        return $couponAmount;
    }

    // Calculate items total price
    public function _getSubTotalAmount()
    {
        $itemsSubtotalAmount = $this->items->sum(function ($item) {
            $price    = $item->pivot->price;
            $quantity = $item->pivot->quantity;

            return $price * $quantity;
        });

        return $itemsSubtotalAmount;
    }

    // Calculate iems total MRP
    public function _getSubTotalMRP()
    {
        $itemsSubtotalMRP = $this->items->sum(function ($item) {
            $itemMRP  = $item->pivot->item_mrp;
            $quantity = $item->pivot->quantity;

            return $itemMRP * $quantity;
        });

        return $itemsSubtotalMRP;
    }

    // Get total items discount
    public function _getItemsDiscount()
    {
        $totalDiscount = $this->items->sum(function ($item) {
            $ssum = 0;
            $itemDiscount = $item->pivot->discount;
            $quantity     = $item->pivot->quantity;
            $ssum         = $itemDiscount * $quantity;
            return $ssum;
        });

        return $totalDiscount;
    }

    public function deliveryCharge()
    {
        $deliveryCharge = $this->delivery_charge;

        return $deliveryCharge;
    }

    // Calculate items total amount with delivery charge
    public function _getSubTotalAmountWithDeliveryCharge()
    {
        $deliveryCharge          = $this->deliveryCharge();
        $itemsSubtotalAmount     = $this->_getSubTotalAmount();
        $totalWithDeliveryCharge = $itemsSubtotalAmount + $deliveryCharge;

        return $totalWithDeliveryCharge;
    }

    public function _getGrandTotal()
    {
        $subTotalAmountWithDeliveryCharge = $this->_getSubTotalAmountWithDeliveryCharge();
        $couponAmount = $this->_getCouponValue();

        if ($this->coupon && $this->coupon->applicable_on === 'products' ) {
            $subTotalAmountWithDeliveryCharge = $subTotalAmountWithDeliveryCharge + $this->_getItemsDiscount();
        }

        $grandTotal = $subTotalAmountWithDeliveryCharge - $couponAmount;
        return $grandTotal;
    }

    public function _getPayableTotal($roundType = null)
    {
        $grandTotal           = $this->_getGrandTotal();
        $totalSpecialDiscount = $this->total_special_discount;
        $payableTotal         = $grandTotal - $totalSpecialDiscount;
        if ($roundType === 'ceil') {
            return ceil($payableTotal);
        } else if ($roundType === 'floor') {
            return floor($payableTotal);
        } else if ($roundType === 'round') {
            return round($payableTotal);
        } else {
            return $payableTotal;
        }
    }

    public function updateOrderValue($orderObj)
    {
        $subTotalMRP       = $orderObj->_getSubTotalMRP();
        $subTotalAmount    = $orderObj->_getSubTotalAmount();
        $couponValue       = $orderObj->_getCouponValue();
        $itemsDiscount     = $orderObj->_getItemsDiscount();
        $payableOrderValue = $orderObj->_getPayableTotal();

        $orderObj->coupon_value         = $couponValue ?? 0;
        $orderObj->total_items_discount = $itemsDiscount ?? 0;
        $orderObj->order_items_value    = $subTotalAmount ?? 0;
        $orderObj->order_items_mrp      = $subTotalMRP ?? 0;
        $orderObj->payable_order_value  = $payableOrderValue ?? 0;
        $orderObj->save();
    }
}
