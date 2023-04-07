<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchased_by_id',
        'vendor_id',
        'purchased_at',
        'note'
    ];

    protected $casts = [
        'purchased_by_id' => 'integer',
        'vendor_id'       => 'integer',
        'note'            => 'integer',
        'purchased_at'    => 'datetime:Y-m-d H:i:s',
        'created_at'      => 'datetime:Y-m-d H:i:s',
        'updated_at'      => 'datetime:Y-m-d H:i:s'
    ];

    public function purchaseBy()
    {
        return $this->belongsTo(User::class, 'purchased_by_id', 'id');
    }

    // public function items()
    // {
    //     return $this->belongsToMany('purchase_items', 'purchased_id', 'item_id')
    //         ->withPivot('mrp', 'selling_price', 'purchased_price', 'quantity')
    //         ->withTimestamps();
    // }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, 'purchased_id', 'id');
    }

    public function getTotalPrice() {
        return $this->purchaseItems->sum(function($pItem) {
            return $pItem->quantity * $pItem->purchased_price;
        });
    }
}
