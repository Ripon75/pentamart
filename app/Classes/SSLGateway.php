<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;

class SSLGateway
{
    private $name;
    private $endpoint;
    private $storeId;
    private $storePassword;
    private $callbackSuccess;
    private $callbackFail;
    private $callbackCancel;
    private $callbackIpn;
    private $wokingCustomerEmail;

    function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->name                = 'ssl';
        $this->endpoint            = config("payment.drivers.{$this->name}.endpoint");
        $this->storeId             = config("payment.drivers.{$this->name}.store_id");
        $this->storePassword       = config("payment.drivers.{$this->name}.store_password");
        $this->callbackSuccess     = config("payment.drivers.{$this->name}.callback_success");
        $this->callbackFail        = config("payment.drivers.{$this->name}.callback_fail");
        $this->callbackCancel      = config("payment.drivers.{$this->name}.callback_cancel");
        $this->callbackIpn         = config("payment.drivers.{$this->name}.callback_ipn");
        $this->wokingCustomerEmail = config("payment.drivers.{$this->name}.woking_customer_email");
    }

    public function requestSession(
        $amount, $trxId, $productCats, $productName, $productProfile,
        $customerName, $customerEmail, $customerAddress, $customerCity, $customerPostcode, $customerCountry, $customerPhone,
        $numOfItems, $multiCardName = "")
    {
        $endpoint      = "{$this->endpoint}/gwprocess/v4/api.php";
        $customerEmail = $customerEmail ?? $this->wokingCustomerEmail;

        $params = [
            "store_id"         => $this->storeId,
            "store_passwd"     => $this->storePassword,
            "total_amount"     => $amount,
            "currency"         => "BDT",
            "tran_id"          => $trxId,
            "product_category" => $productCats,
            "success_url"      => $this->callbackSuccess,
            "fail_url"         => $this->callbackFail,
            "cancel_url"       => $this->callbackCancel,
            "ipn_url"          => $this->callbackIpn,
            "emi_option"       => 0,
            "cus_name"         => $customerName,
            "cus_email"        => $customerEmail,
            "cus_add1"         => $customerAddress,
            "cus_city"         => $customerCity,
            "cus_postcode"     => $customerPostcode,
            "cus_country"      => $customerCountry,
            "cus_phone"        => $customerPhone,
            "shipping_method"  => "NO",
            "num_of_item"      => $numOfItems,
            "product_name"     => $productName,
            "product_profile"  => $productProfile,
            "multi_card_name"  => $multiCardName
        ];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($data, true);

        return $data;
    }
}
