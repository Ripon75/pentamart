<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'status'
    ];

    protected $casts = [
        'id'     => 'integer',
        'title'  => 'string',
        'link'   => 'string',
        'status' => 'string'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'section_item', 'section_id', 'item_id')->withTimestamps();
    }
}
