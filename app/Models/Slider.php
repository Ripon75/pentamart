<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'name',
        'slug',
        'large_img',
        'small_img',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'name'       => 'string',
        'slug'       => 'string',
        'large_img'  => 'string',
        'small_img'  => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
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
        $appUrl = config('app.url');
        return str_replace("$appUrl/storage/", '/', $path);
    }
}
