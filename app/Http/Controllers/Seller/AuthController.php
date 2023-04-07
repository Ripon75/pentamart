<?php

namespace App\Http\Controllers\Seller;

use Auth;
use App\Classes\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function loginCreate(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('seller.dashboard');
        }

        return view('sellercenter.pages.login');
    }

    public function loginStore(Request $request)
    {
        $request->validate([
            'phone_number' => ['required'],
            'password'     => ['required']
        ]);

        $phoneNumber = $request->input('phone_number', null);
        $password    = $request->input('password', null);
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

        if (Auth::attempt(['phone_number' => $phoneNumber, 'password' => $password])) {

            $user = Auth::user();
            Utility::setUserEvent('seller-login', [
                'user' => $user,
            ]);

            return redirect()->route('seller.dashboard');
        }else {
            return back()->with('error', 'User credentil does not match');
        }
    }

    // logout function
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user->remember_token) {
            $user->remember_token = null;
            $user->save();
        }

        Utility::setUserEvent('seller-logout', [
            'user' => $user,
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect('/seller/login');
    }

    public function formatPhoneNumber($phoneNumber)
    {
        if (str_starts_with($phoneNumber, '0')) {
            return $phoneNumber = '88'.$phoneNumber;
        } elseif (str_starts_with($phoneNumber, '1')) {
            return $phoneNumber = '880'.$phoneNumber;
        }elseif (str_starts_with($phoneNumber, '80')) {
            return $phoneNumber = '8'.$phoneNumber;
        } elseif(str_starts_with($phoneNumber, '+88')) {
            return $phoneNumber = substr($phoneNumber, 1);
        } else {
            return $phoneNumber = $phoneNumber;
        }
    }
}