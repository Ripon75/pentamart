<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory, Userstamps, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'name'       => 'string',
        'slug'       => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s'
    ];
}
