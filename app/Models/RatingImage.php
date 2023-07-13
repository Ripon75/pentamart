<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RatingImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating_id',
        'img_src'
    ];

    protected $casts = [
        'rating_id' => 'integer',
        'img_src'   => 'string'
    ];

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
        $appUrl = config('app.url');
        return str_replace("$appUrl/storage/", '/', $path);
    }
}
