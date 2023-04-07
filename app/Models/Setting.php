<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Traits\Setting as BaseSetting;

class Setting extends Model
{
    use HasFactory;
    use BaseSetting;

    protected $fillable = [
        'key',
        'value',
        'group',
        'description',
        'created_by_id',
        'updated_by_id'
    ];

    protected $casts = [
        'key'           => 'string',
        'group'         => 'string',
        'description'   => 'string',
        'created_by_id' => 'integer',
        'updated_by_id' => 'integer',
        'created_at'    => 'datetime:Y-m-d H:i:s',
        'updated_at'    => 'datetime:Y-m-d H:i:s'
    ];
}
