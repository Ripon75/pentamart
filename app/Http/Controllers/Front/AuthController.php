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
use Illuminate\Support\Facades\Hash;
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
            'name'            => ['required'],
            'email'           => ['nullable', 'email', 'unique:users'],
            'phone_number'    => ['required', 'unique:users'],
            'password'        => ['required', 'confirmed'],
            'terms_conditons' => ['required'],
        ],
        [
            'terms_conditons.required' => 'Please checked terms and conditions'
        ]);

        Utility::saveIntendedURL();

        $name            = $request->input('name');
        $email           = $request->input('email', null);
        $phoneNumber     = $request->input('phone_number', null);
        $password        = $request->input('password', null);
        $termsConditions = $request->input('terms_conditons', null);

        try {
            DB::beginTransaction();

            // Format phone number
            $phoneNumber = $this->util->formatPhoneNumber($phoneNumber);

            $user = User::where('phone_number', $phoneNumber)->first();

            if ($user) {
                return redirect()->route('login');
            } else {
                $user = new User();

                $otpCode = $this->getRandomCode();

                $user->name            = $name;
                $user->email           = $email;
                $user->phone_number    = $phoneNumber;
                $user->otp_code        = $otpCode;
                $user->password        = Hash::make($password);
                $user->terms_conditons = $termsConditions;
                $res = $user->save();

                if ($res) {
                    CustomerRegistration::dispatch($user);
                    $this->sendSMS($phoneNumber, $otpCode);

                    DB::commit();
                    return redirect("/send-otp-code?phone_number={$phoneNumber}");
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

        return view('frontend.pages.login');
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
            // $this->sendSMS($phoneNumber, $otpCode);

            return $this->sendResponse($user, 'User exists');
        } else {
            return $this->sendError('User not found');
        }
    }

    // Login by otp
    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'phone_number' => 'required',
    //         'otp_code'     => 'required'
    //     ]);

    //     if ($validator->stopOnFirstFailure()->fails()) {
    //         return $this->sendError($validator->errors());
    //     }

    //     $phoneNumber = $request->input('phone_number', null);
    //     $otpCode     = $request->input('otp_code', null);
    //     $phoneNumber = $this->util->formatPhoneNumber($phoneNumber);

    //     $user = User::where('phone_number', $phoneNumber)->where('otp_code', $otpCode)->first();

    //     if ($user) {
    //         Auth::login($user, true);
    //         $request->session()->regenerate();

    //         return $this->sendResponse($user, 'Successfully login');
    //     } else {
    //         return $this->sendError("Invalid your OTP");
    //     }
    // }

    // Login by password
    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => ['required'],
            'password'     => ['required']
        ]);

        $phoneNumber = $request->input('phone_number', null);
        $password    = $request->input('password', null);
        $phoneNumber = $this->util->formatPhoneNumber($phoneNumber);

        $user = User::where('phone_number', $phoneNumber)->first();
        if ($user && !$user->ac_status) {
            $otpCode = $this->getRandomCode();
            $user->otp_code = $otpCode;
            $user->save();
            // send user activation code
            $this->sendSMS($phoneNumber, $otpCode);

            return redirect("/send-otp-code?phone_number={$phoneNumber}");
        }

        if (Auth::attempt(['phone_number' => $phoneNumber, 'password' => $password], true)) {
            $request->session()->regenerate();

            return redirect()->route('home');
        } else {
            return back()->with('error', 'Invalid credential');
        }
    }

    public function sendOtp()
    {
        return view('frontend.pages.send-otp');
    }

    // Resend otp code
    public function resendOtpCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => ['required']
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
                $this->sendSMS($phoneNumber, $otpCode);

                return $this->sendResponse($user, 'OTP send successfully');
            }
        } else {
            return $this->sendError("User doesn't exist");
        }
    }

    public function checkOtp(Request $request) {
        $request->validate([
            'phone_number' => ['required'],
            'otp_code'     => ['required'],
        ]);

        $phoneNumber = $request->input('phone_number', null);
        $otpCode     = $request->input('otp_code', null);

        $user = User::where('phone_number', $phoneNumber)->first();

        if ($user) {
            if ($user->otp_code === $otpCode) {
                $user->ac_status = 1;
                $user->save();
                return redirect("/login?phone_number={$phoneNumber}");
            } else {
                return back()->with('error', 'Invalid otp');
            }
        } else {
            return back()->with('error', 'User not found');
        }

        return 'check otp';
    }

    // logout function
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function sendSMS($phoneNumber, $otpCode)
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
