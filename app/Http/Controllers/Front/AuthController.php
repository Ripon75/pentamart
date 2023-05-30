<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Classes\Utility;
use App\Classes\SMSGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Events\CustomerRegistration;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $util;

    function __construct(Utility $Util)
    {
        $this->util = $Util;
    }

    public function registrationCreate()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('frontend.pages.registration');
    }

    public function registrationStore(Request $request)
    {
        $request->validate([
            'name'                  => ['required'],
            'email'                 => ['nullable', 'email', 'unique:users'],
            'phone_number'          => ['required', 'unique:users'],
            'terms_and_conditons'   => ['required']
        ],
        [
            'terms_and_conditons.required' => 'Please checked terms and conditions'
        ]
        );

        Utility::saveIntendedURL();

        $name               = $request->input('name');
        $email              = $request->input('email', null);
        $phoneNumber        = $request->input('phone_number', null);
        $termsAndConditions = $request->input('terms_and_conditons', null);

        try {
            DB::beginTransaction();

            // Format phone number
            $phoneNumber = $this->util->formatPhoneNumber($phoneNumber);

            $user = User::where('phone_number', $phoneNumber)->first();

            if ($user) {
                return redirect()->route('login');
            } else {
                $user = new User();

                $user->name  = $name;
                $user->email = $email;
                $user->phone_number        = $phoneNumber;
                $user->terms_and_conditons = $termsAndConditions;
                $res = $user->save();

                if ($res) {
                    CustomerRegistration::dispatch($user);

                    DB::commit();
                    return redirect()->route('login.create');
                }
            }
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'User registration failed');
        }
    }

    public function loginCreate()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        Utility::saveIntendedURL();

        return redirect()->route('home');
    }

    public function checkUser(Request $request)
    {
        $phoneNumber = $request->input('phone_number', null);
        $phoneNumber = $this->util->formatPhoneNumber($phoneNumber);

        $user = User::where('phone_number', $phoneNumber)->first();

        if ($user) {
            $otpCode = $this->getRandomCode();
            $user->otp_code = $otpCode;
            $user->save();
            // $this->forwardOtpCode($phoneNumber, $otpCode);

            return $this->sendResponse($user, 'User exists');
        } else {
            return $this->sendError('User not found');
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'otp_code'     => 'required'
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return $this->sendError($validator->errors());
        }

        $phoneNumber = $request->input('phone_number', null);
        $otpCode     = $request->input('otp_code', null);
        $phoneNumber = $this->util->formatPhoneNumber($phoneNumber);

        $user = User::where('phone_number', $phoneNumber)->where('otp_code', $otpCode)->first();

        if ($user) {
            Auth::login($user, true);
            $request->session()->regenerate();

            return $this->sendResponse($user, 'Successfully login');
        } else {
            return $this->sendError("Invalid your OTP");
        }
    }

    // Resend otp code
    public function resendOtpCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required'
        ]);

        if ($validator->stopOnFirstFailure()->fails()) {
            return $this->sendError($validator->errors());
        }

        $phoneNumber = $request->input('phone_number', null);
        $phoneNumber = $this->util->formatPhoneNumber($phoneNumber);

        $user = User::where('phone_number', $phoneNumber)->first();

        if ($user) {
            $otpCode = $this->getRandomCode();
            $user->otp_code = $otpCode;
            $res = $user->save();
            if ($res) {
                // $this->forwardOtpCode($phoneNumber, $otpCode);

                return $this->sendResponse($user, 'OTP send successfully');
            }
        } else {
            return $this->sendError("User doesn't exist");
        }
    }

    // Socialite login
    public function socialRedirect(Request $request, $service)
    {
        return Socialite::driver($service)->redirect();
    }

    // public function socialCallback(Request $request, $service)
    // {
    //     $user = null;
    //     $socialUser = Socialite::driver($service)->stateless()->user();

    //     if ($service === 'google') {
    //         $user = $this->socialGoogleAuth($socialUser);
    //     }
    //     else if ($service === 'facebook') {
    //         $user = $this->socialFacebookAuth($socialUser);
    //     } else {
    //         $user = $this->socialGoogleAuth($socialUser);
    //     }

    //     Auth::login($user);

    //     return redirect('/');
    // }

    // logout function
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function socialGoogleAuth($socialUser)
    {
        $user = User::where('google_id', $socialUser->id)->first();
        if ($user) {
            $user->name                 = $socialUser->name;
            $user->google_token         = $socialUser->token;
            $user->google_refresh_token = $socialUser->refreshToken;
            $user->avatar               = $socialUser->avatar;
            $user->save();
        } else {
            $user = User::where('email', $socialUser->email)->first();
            if ($user) {
                $user->google_id            = $socialUser->id;
                $user->name                 = $socialUser->name;
                $user->google_token         = $socialUser->token;
                $user->google_refresh_token = $socialUser->refreshToken;
                $user->avatar               = $socialUser->avatar;
                $user->save();
            } else {
                $user = new User();

                $user->name                 = $socialUser->name;
                $user->email                = $socialUser->email;
                $user->google_id            = $socialUser->id;
                $user->google_token         = $socialUser->token;
                $user->google_refresh_token = $socialUser->refreshToken;
                $user->avatar               = $socialUser->avatar;
                $user->save();
            }
        }
        return $user;
    }

    private function socialFacebookAuth($socialUser)
    {
        $user = User::where('facebook_id', $socialUser->id)->first();
        if ($user) {
            $user->name                   = $socialUser->name;
            $user->facebook_token         = $socialUser->token;
            $user->facebook_refresh_token = $socialUser->refreshToken;
            $user->avatar                 = $socialUser->avatar;
            $user->save();
        } else {
            $user = User::where('email', $socialUser->email)->first();
            if ($user) {
                $user->facebook_id            = $socialUser->id;
                $user->name                   = $socialUser->name;
                $user->facebook_token         = $socialUser->token;
                $user->facebook_refresh_token = $socialUser->refreshToken;
                $user->avatar                 = $socialUser->avatar;
                $user->save();
            } else {
                $user = new User();

                $user->name                   = $socialUser->name;
                $user->email                  = $socialUser->email;
                $user->facebook_id            = $socialUser->id;
                $user->facebook_token         = $socialUser->token;
                $user->facebook_refresh_token = $socialUser->refreshToken;
                $user->avatar                 = $socialUser->avatar;
                $user->save();
            }
        }
        return $user;
    }

    public function forwardOtpCode($phoneNumber, $otpCode)
    {
        $SMSGateway = new SMSGateway();
        $SMSGateway->sendActivationCode($phoneNumber, $otpCode);
    }

    // Generate random code
    public function getRandomCode()
    {
        $randomCode = rand(1111, 9999);

        return $randomCode;
    }
}
