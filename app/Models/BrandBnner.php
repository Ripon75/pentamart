<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Storage;

class BrandBnner extends Model
{
    use HasFactory;

    protected $table = 'brand_bnners';

    protected $fillbale = [
        'name',
        'slug',
        'title',
        'status',
        'link',
        'img_src'
    ];

    protected $casts = [
        'name'       => 'string',
        'slug'       => 'string',
        'title'      => 'string',
        'status'     => 'string',
        'link'       => 'string',
        'img_src'    => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function _getImageUploadPath()
    {
        $now = Carbon::now();
        return "images/{$this->table}/{$now->year}/{$now->month}/{$now->day}";
    }

    // Customise function
    public function getImgSrcValueAttribute()
    {
        return $this->attributes['img_src'];
    }

    public function getImgSrcAttribute($value)
    {
        if ($value) {
            return Storage::url($value);
        } else {
            return "";
        }
    }
}
