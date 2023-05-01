<?php
namespace App\Classes;
session_start();

use Log;

class Nagad
{
    private $appUrl;
    private $endpointUrl;
    private $publicKey;
    private $merchantPrivateKey;
    private $callback;

    public function __construct()
    {
        $this->initConfig();
    }

    public function initConfig()
    {
        $this->appUrl             = config('app.url');
        $this->endpointUrl        = config("payment.drivers.nagad.endpoint");
        $this->publicKey          = config("payment.drivers.nagad.publicKey");
        $this->merchantPrivateKey = config("payment.drivers.nagad.merchantPrivateKey");
        $this->callbackURL        = config("payment.drivers.nagad.callback");
        $this->merchantId         = config("payment.drivers.nagad.merchantId");
    }

    public function generateRandomString($length = 40)
    {
        $characters       = '7399C6D07CF14B8C58CFDA5AA87BCC6AB4C27D1CE6AD5DFCAB56C13FA2FE56CC';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function encryptDataWithPublicKey($data)
    {
        $publicKey   = "-----BEGIN PUBLIC KEY-----\n{$this->publicKey}\n-----END PUBLIC KEY-----";
        $keyResource = openssl_get_publickey($publicKey);
        openssl_public_encrypt($data, $cryptText, $keyResource);
        return base64_encode($cryptText);
    }

    function signatureGenerate($data)
    {
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n{$this->merchantPrivateKey}\n-----END RSA PRIVATE KEY-----";
        openssl_sign($data, $signature, $private_key, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }


    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    function httpPostMethod($PostURL, $PostData)
    {
        $url = curl_init($PostURL);
        $postToken = json_encode($PostData);
        $header = [
            'Content-Type:application/json',
            'X-KM-Api-Version:v-0.2.0',
            'X-KM-IP-V4:' . $this->get_client_ip(),
            'X-KM-Client-Type:PC_WEB'
        ];

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $postToken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_SSL_VERIFYPEER, false);

        $resultData = curl_exec($url);
        $ResultArray = json_decode($resultData, true);
        $header_size = curl_getinfo($url, CURLINFO_HEADER_SIZE);
        curl_close($url);
        return $ResultArray;
    }

    public function nagadPaymentRequest($orderId, $amount)
    {
        $_SESSION['orderId'] = $orderId;
        $postURL             = "{$this->endpointUrl}/check-out/initialize/{$this->merchantId}/{$orderId}";
        $merchantCallbackURL = $this->callbackURL;
        $dateTime            = Date('YmdHis');
        $random              = $this->generateRandomString();

        $sensitiveData = [
            'merchantId' => $this->merchantId,
            'datetime'   => $dateTime,
            'orderId'    => $orderId,
            'challenge'  => $random
        ];

        $postData = [
            'accountNumber' => "01322800310", //Replace with Merchant Number (not mandatory)
            'dateTime'      => $dateTime,
            'sensitiveData' => $this->encryptDataWithPublicKey(json_encode($sensitiveData)),
            'signature'     => $this->signatureGenerate(json_encode($sensitiveData))
        ];
        try {
            $response = $this->httpPostMethod($postURL, $postData);

            if ($response) {
                if (array_key_exists('sensitiveData', $response) && array_key_exists('signature', $response)) {

                    $decryptDataWithPrivateKey = $this->decryptDataWithPrivateKey($response['sensitiveData']);

                    $plainResponse = json_decode($decryptDataWithPrivateKey, true);

                    if ($plainResponse['paymentReferenceId'] && $plainResponse['challenge']) {

                        $paymentReferenceId = $plainResponse['paymentReferenceId'];
                        $randomServer       = $plainResponse['challenge'];

                        $sensitiveDataOrder = [
                            'merchantId'   => $this->merchantId,
                            'orderId'      => $orderId,
                            'currencyCode' => '050',
                            'amount'       => $amount,
                            'challenge'    => $randomServer
                        ];

                        $logo = "{$this->appUrl}/images/logos/logo.png";

                        $merchantAdditionalInfo = '{
                            "serviceName":"Medicart",
                            "serviceLogoURL": "'.$logo.'",
                            "additionalFieldNameEN": "E-commerce",
                            "additionalFieldNameBN": "ই-কমার্স",
                            "additionalFieldValue": "Payment"
                        }';

                        $postDataOrder = [
                            'sensitiveData'          => $this->encryptDataWithPublicKey(json_encode($sensitiveDataOrder)),
                            'signature'              => $this->signatureGenerate(json_encode($sensitiveDataOrder)),
                            'merchantCallbackURL'    => $merchantCallbackURL,
                            'additionalMerchantInfo' => json_decode($merchantAdditionalInfo)
                        ];

                        $orderSubmitUrl    = "{$this->endpointUrl}/check-out/complete/" . $paymentReferenceId;
                        $resultDataOrder = $this->httpPostMethod($orderSubmitUrl, $postDataOrder);

                        if ($resultDataOrder['status'] == "Success") {
                            $url = json_encode($resultDataOrder['callBackUrl']);
                            echo "<script>window.open($url, '_self')</script>";
                        }
                        else {
                            echo json_encode($resultDataOrder)." Success";
                        }
                    } else {
                        echo json_encode($plainResponse)." Message";
                    }
                } else {
                    return back()->with('error', $response['message']);
                }
            }
        } catch (\Exception $e) {
            \Log::emergency($e);
        }
    }

    public function decryptDataWithPrivateKey($cryptText)
    {
        $merchantPrivateKey = $this->merchantPrivateKey;
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey . "\n-----END RSA PRIVATE KEY-----";
        openssl_private_decrypt(base64_decode($cryptText), $plain_text, $private_key);
        return $plain_text;
    }

    public function checkOutInitial($test)
    {
        return $test;
    }

    public function checkOutComplete()
    {
        return $request->all();
    }

    public function paymentVerification()
    {
        return $request->all();
    }

    private function log($data)
    {
        return Log::channel('Nagad')->info($data);
    }
}
