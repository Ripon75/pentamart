<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchased_id',
        'item_id',
        'mrp',
        'selling_price',
        'purchased_price',
        'quantity'
    ];

    protected $casts = [
        'purchased_id'    => 'integer',
        'item_id'         => 'integer',
        'mrp'             => 'decimal:2',
        'selling_price'   => 'decimal:2',
        'purchased_price' => 'decimal:2',
        'quantity'        => 'integer',
        'created_at'      => 'datetime: Y-m-d H:i:s',
        'updated_at'      => 'datetime: Y-m-d H:i:s'
    ];

    public function item()
    {
        return $this->belongsTo(Product::class, 'item_id', 'id');
    }
}
