<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Storage;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'pre_title',
        'pre_title_link',
        'title',
        'title_link',
        'post_title',
        'post_title_link',
        'box_link',
        'position',
        'serial',
        'img_src',
        'status',
        'caption'
    ];

    protected $casts = [
        'pre_title'       => 'string',
        'pre_title_link'  => 'string',
        'title'           => 'string',
        'title_link'      => 'string',
        'post_title'      => 'string',
        'post_title_link' => 'string',
        'box_link'        => 'string',
        'position'        => 'string',
        'serial'          => 'string',
        'img_src'         => 'string',
        'status'          => 'string',
        'caption'         => 'string',
        'created_at'      => 'datetime:Y-m-d H:i:s',
        'updated_at'      => 'datetime:Y-m-d H:i:s'
    ];

    public $positionList = [
        [
            'label' => 'Slider',
            'value' => 'slider'
        ],
        [
            'label' => 'Offer',
            'value' => 'offer'
        ],
        [
            'label' => 'Medical Device Offer',
            'value' => 'medical-device-offer'
        ],
        [
            'label' => 'Top Brand Offer',
            'value' => 'top-brand-offer'
        ]
    ];

    public function _getImageUploadPath()
    {
        $now = Carbon::now();
        return "images/{$this->table}/{$now->year}/{$now->month}/{$now->day}";
    }

    // get image source
    public function getImgSrcValueAttribute()
    {
        return $this->attributes['img_src'];
    }

    // get mobile image source
    public function getMobileImgSrcValueAttribute()
    {
        return $this->attributes['mobile_img_src'];
    }

    public function getImgSrcAttribute($value)
    {
        if ($value) {
            return Storage::url($value);
        } else {
            return "";
        }
    }

    public function getMobileImgSrcAttribute($value)
    {
        if ($value) {
            return Storage::url($value);
        } else {
            return "";
        }
    }
}
