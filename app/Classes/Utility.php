<?php

namespace App\Classes;

use Auth;
use Carbon\Carbon;
use App\Models\Offer;
use App\Models\UserEvent;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Artisan;

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

    public function sendResponse($data = null, $message = null, $type = 'json', $view = '', $code = 200)
    {
        // response
        $response = $this->makeResponse($data, $message, $code);

        if($type === 'view') {
            if($view === '') {
                // response when view not found
                return $this->makeResponse(null, "{$view} - View not found", 400);
            }
            return view($view, $response);
        } else {
            return response()->json($response, $code);
        }
    }

    public function makeResponse($data = null, $message = null, $code = 200)
    {
        $error = $code > 299 ? true : false;

        if ($error) {
            return [
                'error'   => true,
                'code'    => $code,
                'message' => $message,
                'result'  => $data
            ];
        } else {
            return [
                'success' => true,
                'code'    => $code,
                'message' => $message,
                'result'  => $data
            ];
        }
    }

    static public function saveIntendedURL($url = null)
    {
        $url = $url ? $url : url()->previous();
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => $url]);
        }
    }

    public function appResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'msg'     => $message,
            'result'  => $result
        ];
        return response()->json($response, 200);
    }

    public function appError($result, $message)
    {
    	$response = [
            'success' => false,
            'msg'     => $message,
            'result'  => $result
        ];

        return response()->json($response, 200);
    }

    static public function updateApp()
    {
        $username      = config('app.update.username');
        $accessToken   = config('app.update.access_token');
        $repositoryURL = config('app.update.repository_url');
        $branchName    = config('app.update.branch_name');

        $commend = "git checkout $branchName && git pull $username:$accessToken@$repositoryURL $branchName";

        $output['git'] = shell_exec($commend);

        $output['migrate'] = Artisan::call('migrate');
        $output['cache']   = Artisan::call('cache:clear');
        $output['route']   = Artisan::call('route:cache');
        $output['config']  = Artisan::call('config:cache');
        $output['view']    = Artisan::call('view:cache');

        return $output;
    }

    public function checkOffer($productId, $quantity)
    {
        $offerProductQty = Offer::with(['productsQty' => function($query) use ($productId, $quantity) {
            $query->wherePivot('product_id', $productId)->wherePivot('quantity', $quantity);
        }])->where('type', 'quantity')->where('status', 'activated')->first();


        if ($offerProductQty && count($offerProductQty->productsQty)) {
            $offerAmount    = 0;
            $productMRP     = $offerProductQty->productsQty[0]->mrp;
            $discountAmount = $offerProductQty->productsQty[0]->pivot->discount_amount;
            if ($productMRP >= $discountAmount) {
                $offerAmount = $productMRP - $discountAmount;
            }

            return $this->makeResponse($offerAmount, 'Offer amount');
        }
    }
}
