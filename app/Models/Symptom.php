<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Symptom extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'status',
        'description'
    ];

    protected $casts = [
        'id'          => 'integer',
        'slug'        => 'string',
        'name'        => 'string',
        'status'      => 'string',
        'description' => 'string',
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at'  => 'datetime:Y-m-d H:i:s',
        'deleted_at'  => 'datetime:Y-m-d H:i:s'
    ];

    public function products()
    {
       return $this->belongsToMany(Product::class, 'product_symptom')->withTimestamps();
    }
}
