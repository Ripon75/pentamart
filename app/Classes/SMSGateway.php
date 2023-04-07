<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SMSGateway
{
    private $default;
    private $username;
    private $password;
    private $endPoint;
    private $source;
    private $apiKey;
    private $secretKey;

    public function __construct()
    {
        $this->default  = config('sms.default');

        if ($this->default === 'dstbd') {
            $this->initDSTBD();
        }else if ($this->default === 'reve') {
            $this->initREVE();
        } else {
            $this->initDSTBD();
        }
    }

    private function initDSTBD()
    {
        $this->username = config('sms.driver.dstbd.username');
        $this->password = config('sms.driver.dstbd.password');
        $this->endPoint = config('sms.driver.dstbd.end_point');
        $this->source   = config('sms.driver.dstbd.source');
    }

    private function initREVE()
    {
        $this->endpoint  = config('sms.driver.reve.end_point');
        $this->source    = config('sms.driver.reve.source');
        $this->apiKey    = config('sms.driver.reve.api_key');
        $this->secretKey = config('sms.driver.reve.secret_key');
    }

    public function sendPasswordRecoveryCode($phoneNumber, $code)
    {
        $appName = config('app.name');
        $message = "Your {$appName} password recovery code is {$code}.";
        return $this->send($phoneNumber, $message);
    }

    public function sendActivationCode($phoneNumber, $code)
    {
        $appName = config('app.name');
        $message = "Your {$appName} confirmation code is {$code}. Thank you for trusting {$appName}";
        return $this->send($phoneNumber, $message);
    }

    public function sendOrderSubmitSMS($phoneNumber, $orderId)
    {
        $appName     = config('app.name');
        $url         = "https://cutt.ly/uX4ibKw";
        $now         = Carbon::now();
        $deliveryday = $now->addDays(2);
        $deliveryday = $deliveryday->format('l');
        $message = "Thank you for your order! Your order ID #{$orderId} is submitted. Estimated delivery by {$deliveryday}. Helpline: 09609080706.
        {$url}";
        return $this->send($phoneNumber, $message);
    }

    public function send($phoneNumber, $message)
    {
        if ($this->default === 'dstbd') {
            $response = $this->sendByDSTBD($phoneNumber, $message);
        } else if ($this->default === 'reve') {
            $response = $this->sendByREVE($phoneNumber, $message);
        } else {
            $response = $this->sendByDSTBD($phoneNumber, $message);
        }

        return $response;
    }

    // ========================================================================
    // Deriver function
    // ========================================================================
    private function sendByDSTBD($phoneNumber, $message)
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

    private function sendByREVE($phoneNumber, $message)
    {
        $response = Http::get($this->endpoint, [
            'apikey'         => $this->apiKey,
            'secretkey'      => $this->secretKey,
            'callerID'       => $this->source,
            'toUser'         => $phoneNumber,
            'messageContent' => $message
        ]);
        return $response;
    }
}
