<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SMSGateway
{
    private $endPoint;
    private $token;
    private $senderId;

    public function __construct()
    {
        $this->endPoint = config('sms.end_point');
        $this->token    = config('sms.token');
        $this->senderId = config('sms.sender_id');
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
        $message = "Your pentamart order is submitted. Estimated delivery by {$deliveryday}.";
        return $this->send($phoneNumber, $message);
    }

    private function send($phoneNumber, $message)
    {
        $headers = [
            "Accept"        => "application/json",
            "Authorization" => "Bearer {$this->token}",
            "Content-Type"  => "application/json",
        ];

        $data = [
            'recipient' => '88' . $phoneNumber,
            'sender_id' => $this->senderId,
            'message'   => $message,
        ];


        $response = Http::withHeaders($headers)->post($this->endPoint, $data);

        return $response;
    }
}