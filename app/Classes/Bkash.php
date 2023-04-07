<?php

namespace App\Classes;

use Log;
use Illuminate\Support\Facades\Http;

class Bkash
{
    private $endpointUrl;
    private $appKey;
    private $appSecret;
    private $username;
    private $password;
    private $callbackURL;

    // The Token obj will be look like this
    // {
    //     "expires_in"   : "string"
    //     "id_token"     : "string"
    //     "refresh_token": "string"
    //     "token_type"   : "string"
    //     "statusCode"   : "string"
    //     "statusMessage": "string"
    // }
    private $token;

    public function __construct()
    {
        $this->initConfig();
    }

    public function initConfig()
    {
        $this->endpointUrl = config("payment.drivers.bkash.endpoint");
        $this->appKey      = config("payment.drivers.bkash.appkey");
        $this->appSecret   = config("payment.drivers.bkash.appSecret");
        $this->username    = config("payment.drivers.bkash.username");
        $this->password    = config("payment.drivers.bkash.password");
        $this->callbackURL = config("payment.drivers.bkash.callback");

        $data = $this->getToken();
        $this->token = $data;
    }

    /**
     * Get token from bkash server
     *
     * @return object {
            "expires_in"   : "string"
            "id_token"     : "string"
            "refresh_token": "string"
            "token_type"   : "string"
            "statusCode"   : "string"
            "statusMessage": "string"
        }
     */
    public function getToken()
    {
        $requestBody = [
            'app_key'    => $this->appKey,
            'app_secret' => $this->appSecret
        ];
        $url = "{$this->endpointUrl}/token/grant";

        $headers = [
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "username"     => $this->username,
            "password"     => $this->password
        ];

        $res = Http::withHeaders($headers)
            ->post($url, $requestBody);

        $jsonRes = json_decode($res, true);

        $this->log([
            'url'      => $url,
            'headers'  => $headers,
            'body'     => $requestBody,
            'response' => json_decode($res, true)
        ]);

        return $jsonRes;
    }

    /**
     * Create bkash payment request
     *
     * @param integer $amount
     * @param string $payerReference
     * @param string $invoiceNumber
     * @param string $mode
     * @param string $currency
     * @param string $intent
     * @return array $res {
            "paymentID"            : "string"
            "createTime"           : "string"
            "orgLogo"              : "string"
            "orgName"              : "string"
            "transactionStatus"    : "string"
            "amount"               : "string"
            "currency"             : "string"
            "intent"               : "string"
            "merchantInvoiceNumber": "string"
            "bkashURL"             : "string"
            "callbackURL"          : "string"
            "successCallbackURL"   : "string"
            "failureCallbackURL"   : "string"
            "cancelledCallbackURL" : "string"
            "statusCode"           : "string"
            "statusMessage"        : "string"
        }
     */
    public function createPayment(
        $amount,
        $invoiceNumber,
        $payerReference,
        $currency = 'BDT',
        $mode = '0011',
        $intent = 'sale'
    ) {
        $requestBody = [
            'mode'                  => $mode,
            'amount'                => $amount,
            'currency'              => $currency,
            'intent'                => $intent,
            'payerReference'        => $payerReference,
            'merchantInvoiceNumber' => $invoiceNumber,
            'callbackURL'           => $this->callbackURL,
        ];

        $url = "{$this->endpointUrl}/create";
        $token = "{$this->token['token_type']} {$this->token['id_token']}";

        $headers = [
            "Accept" => "application/json",
            "Content-Type"  => "application/json",
            "Authorization" => $token,
            "X-APP-Key"     => $this->appKey
        ];

        $res = Http::withHeaders($headers)
            ->post($url, $requestBody);

        $jsonRes = json_decode($res, true);

        $this->log([
            'url'      => $url,
            'headers'  => $headers,
            'body'     => $requestBody,
            'response' => json_decode($res, true)
        ]);

        return $jsonRes;
    }

    /**
     * Execute bkash payment from payment request
     *
     * @param string $paymentID
     * @return object {
            "paymentID"            : "string"
            "agreementID"          : "string"
            "customerMsisdn"       : "string"
            "payerReference"       : "string"
            "agreementExecuteTime" : "string"
            "agreementStatus"      : "string"
            "paymentExecuteTime"   : "string"
            "trxID"                : "string"
            "transactionStatus"    : "string"
            "amount"               : "string"
            "currency"             : "string"
            "intent"               : "string"
            "merchantInvoiceNumber": "string"
            "statusCode"           : "string"
            "statusMessage"        : "string"
        }
     */
    public function executePayment($paymentID)
    {
        $tokenType = "";
        $IDToken = "";
        $url = "{$this->endpointUrl}/execute";

        if (array_key_exists('token_type', $this->token)) {
            $tokenType = $this->token['token_type'];
        }

        if (array_key_exists('id_token', $this->token)) {
            $IDToken = $this->token['id_token'];
        }

        $headers = [
            "Accept" => "application/json",
            "Content-Type"  => "application/json",
            "Authorization" => "{$tokenType} {$IDToken}",
            "X-APP-Key"     => $this->appKey
        ];

        $requestBody = [
            'paymentID' => $paymentID
        ];

        $res = Http::withHeaders($headers)
            ->post($url, $requestBody);

        $jsonRes = json_decode($res, true);

        $this->log([
            'url'      => $url,
            'headers'  => $headers,
            'body'     => $requestBody,
            'response' => json_decode($res, true)
        ]);

        return $jsonRes;
    }

    /**
     * Query bKash payment
     *
     * @param string $paymentID
     * @return object {
            "paymentID"             : "string"
            "mode"                  : "string"
            "agreementID"           : "string"
            "payerReference"        : "string"
            "agreementCreateTime"   : "string"
            "agreementExecuteTime"  : "string"
            "agreementVoidTime"     : "string"
            "agreementStatus"       : "string"
            "paymentCreateTime"     : "string"
            "paymentExecuteTime"    : "string"
            "trxID"                 : "string"
            "transactionStatus"     : "string"
            "amount"                : "string"
            "currency"              : "string"
            "intent"                : "string"
            "merchantInvoiceNumber" : "string"
            "userVerificationStatus": "string"
            "statusCode"            : "string"
            "statusMessage"         : "string"
        }
     */
    public function queryPayment($paymentID)
    {
        $tokenType = "";
        $IDToken = "";
        $url = "{$this->endpointUrl}/payment/status";

        if (array_key_exists('token_type', $this->token)) {
            $tokenType = $this->token['token_type'];
        }

        if (array_key_exists('id_token', $this->token)) {
            $IDToken = $this->token['id_token'];
        }

        $headers = [
            "Accept" => "application/json",
            "Content-Type"  => "application/json",
            "Authorization" => "{$tokenType} {$IDToken}",
            "X-APP-Key"     => $this->appKey
        ];

        $requestBody = [
            'paymentID' => $paymentID
        ];

        $res = Http::withHeaders($headers)
            ->post($url, $requestBody);

        $jsonRes = json_decode($res, true);

        $this->log([
            'url'      => $url,
            'headers'  => $headers,
            'body'     => $requestBody,
            'response' => json_decode($res, true)
        ]);

        return $jsonRes;
    }

    public function searchTransaction($trxID)
    {
        $tokenType = "";
        $IDToken = "";
        $url = "{$this->endpointUrl}/general/searchTransaction";

        if (array_key_exists('token_type', $this->token)) {
            $tokenType = $this->token['token_type'];
        }

        if (array_key_exists('id_token', $this->token)) {
            $IDToken = $this->token['id_token'];
        }

        $headers = [
            "Accept" => "application/json",
            "Content-Type"  => "application/json",
            "Authorization" => "{$tokenType} {$IDToken}",
            "X-APP-Key"     => $this->appKey
        ];

        $requestBody = [
            'trxID' => $trxID
        ];

        $res = Http::withHeaders($headers)
            ->post($url, $requestBody);

        $jsonRes = json_decode($res, true);

        $this->log([
            'url'      => $url,
            'headers'  => $headers,
            'body'     => $requestBody,
            'response' => json_decode($res, true)
        ]);

        return $jsonRes;
    }

    public function refundTransaction($paymentID, $amount, $trxID, $sku, $reason)
    {
        $tokenType = "";
        $IDToken = "";
        $url = "{$this->endpointUrl}/payment/refund";

        if (array_key_exists('token_type', $this->token)) {
            $tokenType = $this->token['token_type'];
        }

        if (array_key_exists('id_token', $this->token)) {
            $IDToken = $this->token['id_token'];
        }

        $headers = [
            "Accept" => "application/json",
            "Content-Type"  => "application/json",
            "Authorization" => "{$tokenType} {$IDToken}",
            "X-APP-Key"     => $this->appKey
        ];

        $requestBody = [
            'paymentID' => $paymentID,
            'amount'    => $amount,
            'trxID'     => $trxID,
            'sku'       => $sku,
            'reason'    => $reason
        ];

        $res = Http::withHeaders($headers)
            ->post($url, $requestBody);

        $jsonRes = json_decode($res, true);

        $this->log([
            'url'      => $url,
            'headers'  => $headers,
            'body'     => $requestBody,
            'response' => json_decode($res, true)
        ]);

        return $jsonRes;
    }

    public function refundStatusTransaction($paymentID, $trxID)
    {
        $tokenType = "";
        $IDToken = "";
        $url = "{$this->endpointUrl}/payment/refund";

        if (array_key_exists('token_type', $this->token)) {
            $tokenType = $this->token['token_type'];
        }

        if (array_key_exists('id_token', $this->token)) {
            $IDToken = $this->token['id_token'];
        }

        $headers = [
            "Accept" => "application/json",
            "Content-Type"  => "application/json",
            "Authorization" => "{$tokenType} {$IDToken}",
            "X-APP-Key"     => $this->appKey
        ];

        $requestBody = [
            'paymentID' => $paymentID,
            'trxID'     => $trxID
        ];

        $res = Http::withHeaders($headers)
            ->post($url, $requestBody);

        $jsonRes = json_decode($res, true);

        $this->log([
            'url'      => $url,
            'headers'  => $headers,
            'body'     => $requestBody,
            'response' => json_decode($res, true)
        ]);

        return $jsonRes;
    }

    private function log($data)
    {
        return Log::channel('bkash')->info($data);
    }
}

