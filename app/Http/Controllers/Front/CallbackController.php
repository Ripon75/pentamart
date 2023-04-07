<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use App\Classes\Bkash;
use App\Classes\SSLGateway;
use Illuminate\Http\Request;
use App\Models\PaymentTransaction;
use App\Http\Controllers\Controller;

class CallbackController extends Controller
{
    public function callback(Request $request, $gateway, $type = 'success')
    {
        if ($gateway === 'ssl') {
            return $this->sslCheckTRXId($request, $type);
        }

        // $type is not nedded for bkash
        if ($gateway === 'bkash') {
            return $this->bkashCheckTRXId($request);
        }

        // $type is not nedded for nagad
        if ($gateway === 'nagad') {
            return $this->nagadCheckTRXId($request);
        }
    }

    private function sslCheckTRXId($request, $type)
    {
        $status         = $request->input("status");
        $tranId         = $request->input("tran_id");
        $error          = $request->input("error");
        $bankTranId     = $request->input("bank_tran_id");
        $currency       = $request->input("currency");
        $tranDate       = $request->input("tran_date");
        $amount         = $request->input("amount");
        $storeId        = $request->input("store_id");
        $currencyType   = $request->input("currency_type");
        $currencyAmount = $request->input("currency_amount");
        $currencyRate   = $request->input("currency_rate");
        $baseFair       = $request->input("base_fair");
        $valueA         = $request->input("value_a");
        $valueB         = $request->input("value_b");
        $valueC         = $request->input("value_c");
        $valueD         = $request->input("value_d");
        $verifySign     = $request->input("verify_sign");
        $verifySignSha2 = $request->input("verify_sign_sha2");
        $verifyKey      = $request->input("verify_key");

        $paymentTransactionObj = PaymentTransaction::find($tranId);

        $view = 'fail';
        if ($paymentTransactionObj) {
            $orderId = $paymentTransactionObj->order_id;
            $orderObj = Order::find($orderId);

            if ($status === 'VALID') {
                $paymentTransactionObj->status = 'success';
                $orderObj->is_paid = true;
                $view = 'success';
            } else if ($status === 'FAILED') {
                $paymentTransactionObj->status = 'failed';
                $view = 'fail';
            } else {
                $paymentTransactionObj->status = 'cancel';
                $view = 'cancel';
            }

            $paymentTransactionObj->save();
            $orderObj->save();
        }
        return $this->returnView($view);
    }

    private function bkashCheckTRXId($request)
    {
        $type       = 'failed';
        $status     = $request->input("status");
        $paymentID  = $request->input("paymentID");
        $apiVersion = $request->input("apiVersion");

        if ($status === 'failure') {
            return $this->returnView('fail', '');
        }
        if ($status === 'cancel') {
            return $this->returnView('fail', 'Your payment is canceled.');
        }

        $bKashObj      = new Bkash();
        $res           = $bKashObj->executePayment($paymentID);
        $statusCode    = $res['statusCode'];
        $statusMessage = $res['statusMessage'];

        if ($statusCode === '0000') {
            $tranId        = $res['merchantInvoiceNumber'];
            $pgtrxID       = $res['trxID'];

            $paymentTransactionObj = PaymentTransaction::find($tranId);

            if ($paymentTransactionObj) {
                $orderId                                      = $paymentTransactionObj->order_id;
                $paymentTransactionObj->payment_id            = $paymentID;
                $paymentTransactionObj->payment_gateway_trxid = $pgtrxID;
                $paymentTransactionObj->status = 'success';
                $paymentTransactionObj->save();

                $orderObj = Order::find($orderId);
                $type = 'success';
                $orderObj->is_paid = true;
                $orderObj->save();

                return $this->returnView($type, $statusMessage);
            } else {
                return $this->returnView('fail', 'PaymentTransaction not found.');
            }
        }

        return $this->returnView('fail', $statusMessage);
    }

    private function nagadCheckTRXId($request)
    {
        $endpointUrl    = config("payment.drivers.nagad.endpoint");
        $Query_String   = explode("&", explode("?", $_SERVER['REQUEST_URI'])[1] );
        $payment_ref_id = substr($Query_String[2], 15);
        $url            = "{$endpointUrl}/verify/payment/{$payment_ref_id}";
        $json           = $this->httpGet($url);
        $response       = json_decode($json, true);
        if ($response) {
            $status  = $response['status'];
            $message = $request['message'];
            // Return payment failed page
            if ($status === 'Failed') {
                return $this->returnView('fail', $message);
            }
            // Find order and set is_paid true
            // Find payment transaction and set status succes
            if ($status === 'Success') {
                $paymentId = $response['paymentRefId'];
                $orderId   = $response['orderId'];
                $orderId = explode('MC', $orderId)[0];
                $ptObj = PaymentTransaction::where('order_id', $orderId)->first();
                if ($ptObj) {
                    $ptObj->payment_id = $paymentId;
                    $ptObj->status = 'success';
                    $ptObj->save();

                    $orderObj = Order::find($orderId);
                    $type = 'success';
                    $orderObj->is_paid = true;
                    $orderObj->save();
                    return $this->returnView($type, $message);
                } else {
                    return $this->returnView('fail', 'PaymentTransaction not found.');
                }
            } else {
                return $this->returnView('fail', $message);
            }
        }
        return $this->returnView('fail');
        // return json_encode($arr);
    }

    private function httpGet($url)
    {
        $ch      = curl_init();
        $timeout = 10;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/0 (Windows; U; Windows NT 0; zh-CN; rv:3)");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $file_contents = curl_exec($ch);
        echo curl_error($ch);
        curl_close($ch);
        return $file_contents;
    }

    private function returnView($type, $message = null)
    {
        if ($type === 'success') {
            return view('frontend.pages.callback-payment-gateway-success');
        } else if ($type === 'fail') {
            return view('frontend.pages.callback-payment-gateway-fail', ['message' => $message]);
        } else if ($type === 'cancel') {
            return view('frontend.pages.callback-payment-gateway-cancel', ['message' => $message]);
        } else if ($type === 'ipn') {
            return '';
        } else {
            return view('frontend.pages.callback-payment-gateway-fail', ['message' => $message]);
        }
    }
}
