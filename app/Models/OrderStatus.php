<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'seller_visibility',
        'customer_visibility',
        'description'
    ];

    protected $casts = [
        'id'                  => 'integer',
        'slug'                => 'string',
        'name'                => 'string',
        'seller_visibility'   => 'boolean',
        'customer_visibility' => 'boolean',
        'description'         => 'string',
        'created_at'          => 'datetime:Y-m-d H:i:s',
        'updated_at'          => 'datetime:Y-m-d H:i:s',
        'deleted_at'          => 'datetime:Y-m-d H:i:s',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_status_map', 'status_id', 'order_id')
                    ->withPivot('created_by_id', 'created_at');
    }
}
