<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'slug'             => 'string',
        'name'             => 'string',
        'start_date'       => 'datetime:Y-m-d H:i:s',
        'end_date'         => 'datetime:Y-m-d H:i:s',
        'created_at'       => 'datetime:Y-m-d H:i:s',
        'updated_at'       => 'datetime:Y-m-d H:i:s'
    ];

    public function productsQty()
    {
        return $this->belongsToMany(Product::class, 'offer_product', 'offer_id', 'product_id')
            ->withPivot('quantity', 'discount_percent', 'discount_amount')->withTimestamps();
    }

    public function productsBSGSBuy()
    {
        return $this->belongsToMany(Product::class, 'offer_bsgs_product', 'offer_id', 'buy_product_id')
            ->withPivot('buy_qty', 'get_product_id', 'get_qty')->withTimestamps();
    }

    public function productsBSGSGet()
    {
        return $this->belongsToMany(Product::class, 'offer_bsgs_product', 'offer_id', 'get_product_id')
            ->withPivot('buy_qty', 'buy_product_id', 'get_qty')->withTimestamps();
    }
}
