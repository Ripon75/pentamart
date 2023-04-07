<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SearchLog extends Model
{
    use HasFactory;
    protected $table = 'logs_search';
    public $incrementing = false;
    protected $keyType = 'string';
    const CREATED_AT = 'logged_at';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'keywords',
        'result_count',
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
        'logged_at'
    ];

    protected $casts = [
        'id'               => 'string',
        'keywords'         => 'string',
        'result_count'     => 'integer',
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
        'logged_at'        => 'datetime:Y-m-d H:i:s',
    ];

    public function _store($keywords, $resultCount)
    {
        $agent     = new Agent();
        $searchLog = new Self();

        $userId = null;
        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $ipAddress = request()->ip();
        $userAgent = request()->header('User-Agent');
        $now       = Carbon::now();

        $uuid            = (string) Str::uuid();
        $deviceName      = $agent->device();
        $platform        = $agent->platform();
        $platformVersion = $agent->version($platform);
        $browser         = $agent->browser();
        $browserVersion  = $agent->version($browser);
        $isDesktop       = $agent->isDesktop();
        $isPhone         = $agent->isPhone();
        $isRobot         = $agent->isRobot();
        $robotName       = $agent->robot();
        $ugLanguage      = $agent->languages();

        $searchLog->id               = $uuid;
        $searchLog->keywords         = $keywords;
        $searchLog->result_count     = $resultCount;
        $searchLog->user_id          = $userId;
        $searchLog->device_name      = $deviceName;
        $searchLog->platform         = $platform;
        $searchLog->platform_version = $platformVersion;
        $searchLog->browser          = $browser;
        $searchLog->browser_version  = $browserVersion;
        $searchLog->is_desktop       = $isDesktop;
        $searchLog->is_phone         = $isPhone;
        $searchLog->is_robot         = $isRobot;
        $searchLog->robot_name       = $robotName;
        $searchLog->ip               = $ipAddress;
        $searchLog->user_agent       = $userAgent;
        $searchLog->ug_language      = $ugLanguage;
        $searchLog->logged_at        = $now;

        $searchLog->save();

        return $searchLog;
    }
}
