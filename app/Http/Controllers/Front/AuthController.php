<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Classes\Utility;
use App\Classes\SMSGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Events\CustomerRegistration;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $registrationView  = 'frontend.pages.registration';
    protected $loginView         = 'frontend.pages.login';
    protected $successLoginRoute = '/';
    protected $faildLoginRoute   = '/login';

    public function registrationCreate()
    {
        if (Auth::check()) {
            return redirect()->intended($this->successLoginRoute);
        }

        return view($this->registrationView);
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
        $otpCode            = $this->getRandomCode();

        try {
            DB::beginTransaction();

            // Format phone number
            $phoneNumber = $this->formatPhoneNumber($phoneNumber);

            $user = User::where('phone_number', $phoneNumber)->first();

            if ($user) {
                return redirect()->route('login');
            } else {
                $user = new User();

                $user->name  = $name;
                $user->email = $email;
                $user->phone_number        = $phoneNumber;
                $user->terms_and_conditons = $termsAndConditions;
                $user->otp_code = $otpCode;
                $res = $user->save();

                if ($res) {
                    CustomerRegistration::dispatch($user, $phoneNumber, $otpCode);

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
            return redirect()->intended($this->successLoginRoute);
        }

        Utility::saveIntendedURL();

        return view($this->loginView);
    }

    public function checkUser(Request $request)
    {
        $phoneNumber = $request->input('phone_number', null);
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

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

    public function loginByPassword(Request $request)
    {
        $phoneNumber = $request->input('phone_number', null);
        $password    = $request->input('password', null);
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

        if (Auth::attempt(['phone_number' => $phoneNumber, 'password' => $password, 'ac_active' => true], true)) {
            $user  = Auth::user();
            $request->session()->regenerate();

            return $this->sendResponse($user, 'Successfully login');
        } else {
            return $this->sendError("User credential doesn't match");
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
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

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
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

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

    public function sendOtpCode($phoneNumber = null)
    {
        return view('frontend.pages.send-otp-code', [
            'phoneNumber' => $phoneNumber
        ]);
    }

    public function checkOtpCode(Request $request)
    {
        $request->validate([
            'phone_number' => ['required'],
            'pin_code'     => ['required']
        ]);

        $phoneNumber = $request->input('phone_number', null);
        $code        = $request->input('pin_code', null);
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);

        $user = User::where('phone_number', $phoneNumber)->first();
        if ($user) {
            if ($user->code == $code) {
                $user->ac_active = 1;
                $user->save();

                $intendedURL = session('url.intended') ? session('url.intended') : $this->successLoginRoute;
                session()->forget('url.intended');
                Auth::login($user);
                $request->session()->regenerate();

                Utility::setUserEvent('customer-phone-validation', [
                    'user' => $user,
                ]);

                return redirect()->intended($intendedURL);
            } else {
                return back()->with('message', 'Code does not match');
            }
        } else {
            return back()->with('message', 'User not found');
        }
    }

    // Socialite login
    public function socialRedirect(Request $request, $service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function socialCallback(Request $request, $service)
    {
        $user = null;
        $socialUser = Socialite::driver($service)->stateless()->user();

        if ($service === 'google') {
            $user = $this->socialGoogleAuth($socialUser);
        }
        else if ($service === 'facebook') {
            $user = $this->socialFacebookAuth($socialUser);
        } else {
            $user = $this->socialGoogleAuth($socialUser);
        }

        Auth::login($user);

        return redirect('/');
    }

    // logout function
    public function logout(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        if ($user->remember_token) {
            $user->remember_token = null;
            $user->save();
        }

        Utility::setUserEvent('customer-logout', [
            'user' => $user,
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($this->successLoginRoute);
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
