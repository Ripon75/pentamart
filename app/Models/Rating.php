<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rate',
        'comment'
    ];

    protected $casts = [
        'user_id'    => 'integer',
        'product_id' => 'integer',
        'rate'       => 'integer',
        'comment'    => 'string'
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
