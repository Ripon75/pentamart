<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPriceLog extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'logs_product_price';
    const CREATED_AT = 'logged_at';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'old_mrp',
        'new_mrp',
        'old_selling_price',
        'new_selling_price'
    ];

    protected $casts = [
        'user_id'           => 'integer',
        'product_id'        => 'integer',
        'old_mrp'           => 'decimal:2',
        'new_mrp'           => 'decimal:2',
        'old_selling_price' => 'decimal:2',
        'new_selling_price' => 'decimal:2',
        'logged_at'         => 'datetime:Y-m-d H:i:s'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    static public function _store($productId, $newMRP, $newSellingPrice, $oldMRP = 0, $oldSellingPrice = 0)
    {
        if (!$productId) {
            return false;
        }

        $priceLog = new self();
        $now = Carbon::now();

        $priceLog->user_id           = Auth::id();
        $priceLog->product_id        = $productId;
        $priceLog->old_mrp           = $oldMRP;
        $priceLog->new_mrp           = $newMRP;
        $priceLog->old_selling_price = $oldSellingPrice;
        $priceLog->new_selling_price = $newSellingPrice;
        $priceLog->logged_at         = $now;
        $res                         = $priceLog->save();
        if ($res) {
            return $priceLog;
        } else {
            return false;
        }
    }
}
