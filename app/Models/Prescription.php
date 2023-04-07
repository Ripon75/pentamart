<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use App\Classes\Model;
use Storage;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'prescriptions';

    protected $fillable = [
        'user_id',
        'status',
        'img_src',
        'remark'
    ];

    protected $casts = [
        'user_id'    => 'integer',
        'status'     => 'string',
        'img_src'    => 'string',
        'remark'     => 'string',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
