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
            return $phoneNumber;
        } elseif (str_starts_with($phoneNumber, '1')) {
            return $phoneNumber = '0' . $phoneNumber;
        } elseif (str_starts_with($phoneNumber, '80')) {
            return $phoneNumber = substr($phoneNumber, 1);
        } elseif (str_starts_with($phoneNumber, '88')) {
            return $phoneNumber = substr($phoneNumber, 2);
        } elseif (str_starts_with($phoneNumber, '+88')) {
            return $phoneNumber = substr($phoneNumber, 3);
        } else {
            return $phoneNumber;
        }
    }
}
