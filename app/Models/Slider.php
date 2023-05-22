<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'large_img',
        'small_img'
    ];

    protected $casts = [
        'name'      => 'string',
        'slug'      => 'string',
        'large_img' => 'string',
        'small_img' => 'string'
    ];

    public function getLargeSrcAttribute($value)
    {
        if ($value) {
            if (Storage::disk('public')->exists($value)) {
                return Storage::url($value);
            }
        }
    }

    public function getSmallSrcAttribute($value)
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
