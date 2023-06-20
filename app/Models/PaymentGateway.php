<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentGateway extends Model
{
    use HasFactory, Userstamps, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'img_src',
        'created_by',
        'updated_by'
    ];

    protected $casta = [
        'name'       => 'string',
        'slug'       => 'string',
        'status'     => 'string',
        'img_src'    => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
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
