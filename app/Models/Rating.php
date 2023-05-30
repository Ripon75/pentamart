<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'user_id',
        'product_id',
        'rate',
        'comment',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'user_id'    => 'integer',
        'product_id' => 'integer',
        'rate'       => 'integer',
        'comment'    => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function ratingImages()
    {
        return $this->hasMany(RatingImage::class, 'rating_id', 'id');
    }
}
