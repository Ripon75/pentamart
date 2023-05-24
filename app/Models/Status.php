<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'name',
        'slug',
        'seller_visibility',
        'customer_visibility',
        'description',
        'bg_color',
        'text_color',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'name'                => 'string',
        'slug'                => 'string',
        'seller_visibility'   => 'boolean',
        'customer_visibility' => 'boolean',
        'description'         => 'string',
        'created_by'          => 'integer',
        'updated_by'          => 'integer',
        'created_at'          => 'datetime:Y-m-d H:i:s',
        'updated_at'          => 'datetime:Y-m-d H:i:s',
        'deleted_at'          => 'datetime:Y-m-d H:i:s',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_status', 'status_id', 'order_id')
            ->withPivot('created_by_id', 'created_at');
    }
}
