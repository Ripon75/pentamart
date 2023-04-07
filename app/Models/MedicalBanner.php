<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Storage;

class MedicalBanner extends Model
{
    use HasFactory;

    protected $table = 'medical_banners';

    protected $fillbale = [
        'bg_color',
        'pre_title',
        'title',
        'post_title',
        'img_src',
        'status',
        'link'
    ];

    protected $casts = [
        'bg_color'    => 'string',
        'pre_title'   => 'string',
        'title'       => 'string',
        'post_title'  => 'string',
        'img_src'     => 'string',
        'status'      => 'string',
        'link'        => 'string',
        'created_at'  => 'datetime:Y-m-d H:i:s',
        'updated_at'  => 'datetime:Y-m-d H:i:s'
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
