<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'user_defined'
    ];

    protected $casts = [
        'slug'         => 'string',
        'name'         => 'string',
        'description'  => 'string',
        'user_defined' => 'string',
        'created_at'       => 'datetime:Y-m-d H:i:s',
        'updated_at'       => 'datetime:Y-m-d H:i:s'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class, 'family_id', 'id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'family_attribute', 'family_id', 'attribute_id')
        ->withPivot('attribute_group')->withTimestamps();
    }
}
