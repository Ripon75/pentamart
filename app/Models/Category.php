<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $_columns = [
        'id' => [
            'cast'     => 'integer'
        ],
        'slug' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'name' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'status' => [
            'cast'     => 'string',
            'fillable' => true
        ],
        'is_top' => [
            'cast'     => 'boolean',
            'fillable' => true
        ],
        'created_at' => [
            'cast'     => 'datetime:Y-m-d H:i:s',
            'fillable' => true
        ],
        'updated_at' => [
            'cast'     => 'datetime:Y-m-d H:i:s',
            'fillable' => true
        ],
        'deleted_at' => [
            'cast'     => 'datetime:Y-m-d H:i:s'
        ]
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function getImgSrcAttribute($value)
    {
        if ($value) {
            if (Storage::disk('public')->exists($value)) {
                return Storage::url($value);
            }
        }
    }

    public function getOldPath($path)
    {
        return str_replace('http://localhost:3000/storage/', '/', $path);
    }
}
