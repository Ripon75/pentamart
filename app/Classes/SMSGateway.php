<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SMSGateway
{
    private $username;
    private $password;
    private $endPoint;
    private $source;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $this->username = config('sms.username');
        $this->password = config('sms.password');
        $this->endPoint = config('sms.end_point');
        $this->source   = config('sms.source');
    }


    public function sendActivationCode($phoneNumber, $code)
    {
        $appName = config('app.name');
        $message = "Your {$appName} confirmation code is {$code}.";
        return $this->send($phoneNumber, $message);
    }

    public function sendOrderSubmitSMS($phoneNumber)
    {
        $now         = Carbon::now();
        $deliveryday = $now->addDays(2);
        $deliveryday = $deliveryday->format('l');
        $message = "Thank you for your order! Your pentamart order is submitted. Estimated delivery by {$deliveryday}.";
        return $this->send($phoneNumber, $message);
    }

    private function send($phoneNumber, $message)
    {
        $response = Http::get($this->endPoint, [
            'username'    => $this->username,
            'password'    => $this->password,
            'type'        => 0,
            'dlr'         => 1,
            'destination' => $phoneNumber,
            'source'      => $this->source,
            'message'     => $message,
        ]);
        return $response;
    }
}
