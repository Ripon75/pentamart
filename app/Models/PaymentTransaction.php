<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'type',
        'payment_method_id',
        'payment_id',
        'payment_gateway_trxid',
        'status',
        'remark',
        'trx_by_id'
    ];

    protected $casts = [
        'order_id'              => 'integer',
        'amount'                => 'decimal:2',
        'type'                  => 'string',
        'payment_method_id'     => 'integer',
        'payment_id'            => 'string',
        'payment_gateway_trxid' => 'string',
        'status'                => 'string',
        'remark'                => 'string',
        'trx_by_id'             => 'integer',
        'created_at'            => 'datetime:Y-m-d H:i:s',
        'updated_at'            => 'datetime:Y-m-d H:i:s',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'trx_by_id', 'id');
    }

    public function make($orderID, $amount = null, $type = null, $method = null, $status = null, $remark = null)
    {
        $order = Order::find($orderID);

        $method = $method ?? 1;
        $status = $status ?? 'completed';
        $userID = Auth::id();

        $amount = $amount ?? round($order->payable_order_value);

        $trxObj = new Self();

        $trxObj->order_id          = $orderID;
        $trxObj->amount            = $amount;
        $trxObj->type              = $type;
        $trxObj->payment_method_id = $method;
        $trxObj->status            = $status;
        $trxObj->remark            = $remark;
        $trxObj->trx_by_id         = $userID;
        $res                       = $trxObj->save();
        if ($res) {
            return $trxObj;
        }

        return false;
    }
}
