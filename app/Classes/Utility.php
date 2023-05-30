<?php

namespace App\Classes;

use Carbon\Carbon;
use App\Models\UserEvent;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Auth;

class Utility
{
    static public function setUserEvent(string $event, mixed $data)
    {
        $agent  = new Agent();
        $userId = null;

        if (Auth::check()) {
            $userId = Auth::user()->id;
        }

        $ipAddress = request()->ip();
        $userAgent = request()->header('User-Agent');
        $now       = Carbon::now();

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

        $userEventObj                   = new UserEvent();
        $userEventObj->event            = $event;
        $userEventObj->data             = $data;
        $userEventObj->user_id          = $userId;
        $userEventObj->device_name      = $deviceName;
        $userEventObj->platform         = $platform;
        $userEventObj->platform_version = $platformVersion;
        $userEventObj->browser          = $browser;
        $userEventObj->browser_version  = $browserVersion;
        $userEventObj->is_desktop       = $isDesktop;
        $userEventObj->is_phone         = $isPhone;
        $userEventObj->is_robot         = $isRobot;
        $userEventObj->robot_name       = $robotName;
        $userEventObj->ip               = $ipAddress;
        $userEventObj->user_agent       = $userAgent;
        $userEventObj->ug_language      = $ugLanguage;

        return $userEventObj->save();
    }

    static public function saveIntendedURL($url = null)
    {
        $url = $url ? $url : url()->previous();
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => $url]);
        }
    }

    static public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'msg'     => $message,
            'result'  => $result
        ];
        return response()->json($response, 200);
    }

    static public function sendError($message)
    {
    	$response = [
            'success' => false,
            'msg'     => $message,
            'result'  => []
        ];

        return response()->json($response, 201);
    }

    public function formatPhoneNumber($phoneNumber)
    {
        if (str_starts_with($phoneNumber, '0')) {
            return $phoneNumber = '88' . $phoneNumber;
        } elseif (str_starts_with($phoneNumber, '1')) {
            return $phoneNumber = '880' . $phoneNumber;
        } elseif (str_starts_with($phoneNumber, '80')) {
            return $phoneNumber = '8' . $phoneNumber;
        } elseif (str_starts_with($phoneNumber, '+88')) {
            return $phoneNumber = substr($phoneNumber, 1);
        } else {
            return $phoneNumber = $phoneNumber;
        }
    }
}
