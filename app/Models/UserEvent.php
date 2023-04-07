<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserEvent extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'event',
        'data',
        'user_id',
        'device_name',
        'platform',
        'platform_version',
        'browser',
        'browser_version',
        'is_desktop',
        'is_phone',
        'is_robot',
        'robot_name',
        'ip',
        'user_agent',
        'ug_language',
    ];

    protected $casts = [
        'id'               => 'string',
        'event'            => 'string',
        'data'             => 'json',
        'user_id'          => 'integer',
        'device_name'      => 'string',
        'platform'         => 'string',
        'platform_version' => 'string',
        'browser'          => 'string',
        'browser_version'  => 'string',
        'is_desktop'       => 'boolean',
        'is_phone'         => 'boolean',
        'is_robot'         => 'boolean',
        'robot_name'       => 'string',
        'ip'               => 'string',
        'user_agent'       => 'string',
        'ug_language'      => 'array',
    ];
}
