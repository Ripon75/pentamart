<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'is_top',
        'img_src'
    ];

    protected $casts = [
        'name'       => 'string',
        'slug'       => 'string',
        'status'     => 'string',
        'is_top'     => 'boolean',
        'img_src'    => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
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
