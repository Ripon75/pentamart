<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryGateway extends Model
{
    use HasFactory, Userstamps, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'promo_price',
        'min_time',
        'max_time',
        'time_unit',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'name'        => 'string',
        'slug'        => 'string',
        'price'       => 'decimal:2',
        'promo_price' => 'decimal:2',
        'min_time'    => 'integer',
        'max_time'    => 'integer',
        'time_unit'   => 'string',
        'status'      => 'string',
        'created_by'  => 'integer',
        'updated_by'  => 'integer',
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at'  => 'datetime:Y-m-d H:i:s',
        'deleted_at'  => 'datetime:Y-m-d H:i:s'
    ];
}
