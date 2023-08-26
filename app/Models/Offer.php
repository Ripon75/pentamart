<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory, Userstamps;

    protected $fillable = [
        'title',
        'status',
        'offer_percent',
        'img_src'
    ];

    protected $casts = [
        'title'         => 'string',
        'status'        => 'string',
        'offer_percent' => 'integer',
        'img_src'       => 'string',
        'created_by'    => 'integer',
        'updated_by'    => 'integer',
        'created_at'    => 'datetime:Y-m-d H:i:s',
        'updated_at'    => 'datetime:Y-m-d H:i:s',
        'deleted_at'    => 'datetime:Y-m-d H:i:s'
    ];

    public function getImgSrcAttribute($value)
    {
        if ($value) {
            if (Storage::disk('public')->exists($value)) {
                return Storage::url($value);
            }
        }

        return '/images/sample/brand.jpeg';
    }

    public function getOldPath($path)
    {
        $appUrl = config('app.url');
        return str_replace("$appUrl/storage/", '/', $path);
    }
}
