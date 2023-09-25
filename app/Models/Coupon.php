<?php

namespace App\Models;

use Carbon\Carbon;
use App\Classes\Utility;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory, Userstamps, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'status',
        'discount_type',
        'discount_amount',
        'min_cart_amount',
        'started_at',
        'ended_at',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'name'            => 'string',
        'code'            => 'string',
        'status'          => 'string',
        'discount_type'   => 'string',
        'discount_amount' => 'decimal:2',
        'min_cart_amount' => 'decimal:2',
        'created_by'      => 'integer',
        'updated_by'      => 'integer',
        'started_at'      => 'datetime:Y-m-d H:i:s',
        'ended_at'        => 'datetime:Y-m-d H:i:s',
        'created_at'      => 'datetime:Y-m-d H:i:s',
        'updated_at'      => 'datetime:Y-m-d H:i:s',
        'deleted_at'      => 'datetime:Y-m-d H:i:s'
    ];
}
