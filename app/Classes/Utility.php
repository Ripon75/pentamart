<?php

namespace App\Classes;
class Utility
{
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
