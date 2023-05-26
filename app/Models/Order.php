<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model implements Auditable
{
    use HasFactory, Userstamps;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'pg_id',
        'status_id',
        'address_id',
        'address',
        'coupon_id',
        'coupon_value',
        'delivery_charge',
        'price',
        'sell_price',
        'discount',
        'net_price',
        'payable_price',
        'is_paid',
        'note',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'user_id'         => 'integer',
        'pg_id'           => 'integer',
        'status_id'       => 'integer',
        'address_id'      => 'integer',
        'address'         => 'string',
        'coupon_id'       => 'integer',
        'coupon_value'    => 'decimal:2',
        'delivery_charge' => 'decimal:2',
        'price'           => 'decimal:2',
        'sell_price'      => 'decimal:2',
        'discount'        => 'decimal:2',
        'net_price'       => 'decimal:2',
        'payable_price'   => 'decimal:2',
        'is_paid'         => 'boolean',
        'note'            => 'string',
        'created_by'      => 'integer',
        'updated_by'      => 'integer',
        'created_at'      => 'datetime:Y-m-d H:i:s',
        'updated_at'      => 'datetime:Y-m-d H:i:s',
        'deleted_at'      => 'datetime:Y-m-d H:i:s'
    ];

    // Start relation
    public function items()
    {
        return $this->belongsToMany(Product::class, 'order_item', 'order_id', 'item_id')
            ->withPivot('quantity', 'item_price', 'sell_price', 'item_discount')
            ->withTimestamps();
    }

    public function status()
    {
        return $this->belongsToMany(Status::class, 'order_status', 'order_id', 'status_id')
            ->orderBy('order_status.created_at', 'asc')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'pg_id', 'id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    public function currentStatus()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }

    public function transaction()
    {
        return $this->hasOne(PaymentTransaction::class, 'order_id', 'id');
    }

    public function setStatus($status, $orderDatetime = null)
    {
        $statusObj = null;
        if(is_numeric($status)) {
            $statusObj = Status::find($status);
        } else {
            $statusObj = Status::where('slug', $status)->first();
        }

        if (!$statusObj) {
            return false;
        }

        $userId   = Auth::id();
        $statusId = $statusObj->id;

        $this->status()->attach([
            $statusId => [
                'created_by' => $userId
            ]
        ]);

        $this->status_id = $statusId;
        $this->save();
    }
    // End relation

    // Helper function
    public function getCouponValue()
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
                        $itemsSubtotalAmount = $this->getTotalPrice();
                        $couponPercent       = $coupon->discount_amount;
                        $couponAmount        = ($couponPercent * $itemsSubtotalAmount)/100;
                    }
                }
            }
        }
        return $couponAmount;
    }

    // Calculate items total price
    public function getTotalPrice()
    {
        $totalPrice = $this->items->sum(function ($item) {
            $itemPrice = $item->pivot->item_price;
            $quantity  = $item->pivot->quantity;

            return $itemPrice * $quantity;
        });

        return $totalPrice;
    }

    // Calculate iems total MRP
    public function getTotalSellPrice()
    {
        $totalSellPrice = $this->items->sum(function ($item) {
            $sellPrice = $item->pivot->sell_price;
            $quantity  = $item->pivot->quantity;

            return $sellPrice * $quantity;
        });

        return $totalSellPrice;
    }

    // Get total items discount
    public function getTotalDiscount()
    {
        $totalDiscount = $this->items->sum(function ($item) {
            $discount = $item->pivot->item_discount;
            $quantity = $item->pivot->quantity;
            return $discount * $quantity;
        });

        return $totalDiscount;
    }

    public function getTotalWithDeliveryCharge()
    {
        $totalSellPrice = $this->getTotalSellPrice();
        $totalWithDeliveryCharge = $totalSellPrice + $this->delivery_charge;

        return $totalWithDeliveryCharge;
    }

    public function getNetPrice()
    {
        $totalWithDeliveryCharge = $this->getTotalWithDeliveryCharge();
        $couponValue = $this->getCouponValue();

        $grandTotal = $totalWithDeliveryCharge - $couponValue;
        return $grandTotal;
    }

    public function getPayablePrice($roundType = null)
    {
        $netPrice = $this->getNetPrice();

        if ($roundType === 'ceil') {
            return ceil($netPrice);
        } else if ($roundType === 'floor') {
            return floor($netPrice);
        } else if ($roundType === 'round') {
            return round($netPrice);
        } else {
            return $netPrice;
        }
    }

    public function updateOrderValue($orderObj)
    {
        $totalPrice     = $orderObj->getTotalPrice() ?? 0;
        $totalSellPrice = $orderObj->getTotalSellPrice() ?? 0;
        $couponValue    = $orderObj->getCouponValue() ?? 0;
        $totalDiscount  = $orderObj->getTotalDiscount() ?? 0;
        $netPrice       = $orderObj->getNetPrice() ?? 0;
        $payablePrice   = $orderObj->getPayablePrice('round') ?? 0;

        $orderObj->coupon_value  = $couponValue;
        $orderObj->price         = $totalPrice;
        $orderObj->sell_price    = $totalSellPrice;
        $orderObj->discount      = $totalDiscount;
        $orderObj->net_price     = $netPrice;
        $orderObj->payable_price = $payablePrice;
        $orderObj->save();
    }
}
