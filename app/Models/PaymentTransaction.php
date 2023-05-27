<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentTransaction extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'order_id',
        'amount',
        'type',
        'pg_id',
        'payment_id',
        'pg_trxid',
        'status',
        'remark',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'order_id'   => 'integer',
        'amount'     => 'decimal:2',
        'type'       => 'string',
        'pg_id'      => 'integer',
        'payment_id' => 'string',
        'pg_trxid'   => 'string',
        'status'     => 'string',
        'remark'     => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'trx_by_id', 'id');
    }

    public function make($orderId, $amount = null, $type = null, $method = null, $status = null)
    {
        $trxObj = new Self();

        $trxObj->order_id = $orderId;
        $trxObj->amount   = $amount;
        $trxObj->type     = $type;
        $trxObj->pg_id    = $method ?? 1;
        $trxObj->status   = $status ?? 'pending';
        $trxObj->save();

        return $trxObj;
    }
}
