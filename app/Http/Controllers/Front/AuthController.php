<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Cart;
use App\Classes\Utility;
use App\Classes\SMSGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use App\Events\CustomerRegistration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\PasswordRecoveryCode;
use Laravel\Socialite\Facades\Socialite;
use App\Events\PasswordRecoveryAttempted;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $registrationView          = 'frontend.pages.signup';
    protected $loginView                 = 'frontend.pages.login';
    protected $successLoginRedirectRoute = '/';
    protected $faildLoginRedirectRoute   = '/login';

    // return registration view
    public function registrationCreate()
    {
        if (Auth::check()) {
            return redirect()->intended($this->successLoginRedirectRoute);
        }

        return view($this->registrationView);
    }

    public function registrationStore(Request $request)
    {
        $request->validate([
            'name'                  => ['required'],
            'email'                 => ['nullable', 'email', 'unique:users'],
            'phone_number'          => ['required', 'unique:users'],
            'password'              => ['required', 'min:5', 'confirmed'],
            'password_confirmation' => ['required'],
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
        $password           = $request->input('password');
        $termsAndConditions = $request->input('terms_and_conditons', null);
        $code               = $this->getRandomCode();

        try {
            DB::beginTransaction();
            // check first digit 0 or not
            $phoneNumber = $this->formatPhoneNumber($phoneNumber);

            $user = User::where('email', $email)->whereNotNull('email')->orWhere('phone_number', $phoneNumber)->first();
            if ($user) {
                if ($user->ac_active) {
                    return back()->with('success', 'User already active');
                } else {
                    if ($code && $phoneNumber) {
                        $user->code = $code;
                        $res = $user->save();
                        $SMSGateway = new SMSGateway();
                        $SMSGateway->sendActivationCode($phoneNumber, $code);
                    }
                    return redirect()->route('phone.active.code.check.view', [$phoneNumber]);
                }
            }

            $userObj = new User();

            $userObj->name  = $name;
            $userObj->email = $email;
            $userObj->phone_number        = $phoneNumber;
            $userObj->password            = Hash::make($password);
            $userObj->terms_and_conditons = $termsAndConditions;
            $userObj->code = $code;
            $res = $userObj->save();

            if ($res) {
                Utility::setUserEvent('customer-registration', [
                    'user' => $userObj
                ]);
                CustomerRegistration::dispatch($userObj, $phoneNumber, $code);
                return redirect()->route('phone.active.code.check.view', [$phoneNumber]);
            } else {
                return back()->with($res);
            }
            DB::commit();
        } catch (\Exception $e) {
            //throw $th;
            info($e);
            DB::rollback();
            return false;
        }
    }

    // return login view
    public function loginCreate()
    {
        if (Auth::check()) {
            return redirect()->intended($this->successLoginRedirectRoute);
        }

        Utility::saveIntendedURL();

        return view($this->loginView);
    }

    public function newLoginStore(Request $request)
    {
        $phoneNumber = $request->input('phone_number', null);

        if ($phoneNumber) {
            // check first digit 0 or not
            $phoneNumber = $this->formatPhoneNumber($phoneNumber);

            $user = User::where('phone_number', $phoneNumber)->first();

            if ($user) {
                if (!$user->ac_active) {
                    $code = $this->getRandomCode();
                    if ($code && $phoneNumber) {
                        $user->code = $code;
                        $res = $user->save();
                        $SMSGateway = new SMSGateway();
                        $SMSGateway->sendActivationCode($phoneNumber, $code);
                    }
                    return $res = [
                        'success'      => true,
                        'data'         => $user,
                        'ac_status'    => false,
                        'message'      => 'User is not active',
                        'phone_number' => $phoneNumber
                    ];
                }
            }

            if ($user) {
                return $res = [
                    'success'   => true,
                    'data'      => $user,
                    'ac_status' => true,
                    'message'   => 'User found'
                ];
            } else {
                return $res = [
                    'success'   => false,
                    'data'      => '',
                    'ac_status' => true,
                    'message'   => 'User not found'
                ];
            }
        }

        $phone      = $request->input('phone', null);
        $password   = $request->input('password', null);
        $isRemember = $request->input('is_remember', false);

        $isRemember = $isRemember ? true : false;

        if ($phone && $password) {
            // check first digit 0 or not
            $phone = $this->formatPhoneNumber($phone);

            if(Auth::attempt(['phone_number' => $phone, 'password' => $password, 'ac_active' => true], $isRemember)) {
                $user  = Auth::user();
                // $cart  = $user->cart;
                // if (!$cart) {
                //     $cartObj = new Cart();
                //     $cartObj->_createAndAssignCustomer($user->id);
                // }
                $request->session()->regenerate();

                Utility::setUserEvent('customer-login', [
                    'user' => $user,
                    'login-by' => 'password'
                ]);

                return $res = [
                    'success' => true,
                    'data'    => '',
                    'message' => 'Successfully login'
                ];
            }
        }

        $code    = $request->input('code', null);
        $pNumber = $request->input('p_number', null);

        if ($code) {
            // check first digit 0 or not
            $pNumber = $this->formatPhoneNumber($pNumber);
            $user = User::where('code', $code)->where('phone_number', $pNumber)->first();
            if ($user) {
                $code = $user->code;
                Auth::login($user);
                // if (!$user->cart) {
                //     $cartObj = new Cart();
                //     $cartObj->_createAndAssignCustomer($user->id);
                // }

                Utility::setUserEvent('customer-login', [
                    'user' => $user,
                    'login-by' => 'otp'
                ]);

                return $res = [
                    'success' => true,
                    'message' => 'Successfully login'
                ];
            }
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
        $user = Auth::user();
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


        return redirect($this->successLoginRedirectRoute);
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

                $user                       = new User();

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

    public function recover()
    {
        return view('frontend.pages.my-password-recover');
    }

    public function emailOrPhoneStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_or_email' => 'required'
        ]);

        if ($validator->fails()) {
            $res = [
                'code'    => 201,
                'message' => 'The phone or email is required'
            ];

            return $res;
        }

        $emailOrPhone = $request->input('phone_or_email', null);

        $obj = new PasswordRecoveryCode();

        // check if e-mail address is well-formed
        if (filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL)) {
            $obj->email = $emailOrPhone;
        }else {
            // Check first digit zero or not
            if (str_starts_with($emailOrPhone, '0')) {
                $emailOrPhone = '88'.$emailOrPhone;
            } else {
                $emailOrPhone = $emailOrPhone;
            }
            $obj->phone_number = $emailOrPhone;
        }

        $checkEmailOrPhone = User::where('email', $emailOrPhone)->orWhere('phone_number', $emailOrPhone)->first();
        if (!$checkEmailOrPhone) {
            $res = [
                'code'    => 201,
                'message' => 'The phone or email is not valid'
            ];

            return $res;
        }

        $code = $this->getRandomCode();
        $obj->code = $code;
        $res = $obj->save();
        // Call event
        PasswordRecoveryAttempted::dispatch($emailOrPhone, $code);

        $res = [
            'code'    => 200,
            'message' => 'OTP code send your phone'
        ];

        return $res;
    }

    public function codeCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required'
        ]);

        if ($validator->fails()) {
            $res = [
                'code'    => 201,
                'message' => 'The code is required'
            ];

            return $res;
        }

        $code = $request->input('code', null);
        $recoverCode = PasswordRecoveryCode::where('code', $code)->whereNull('used_at')->first();
        if (!$recoverCode) {
            $res = [
                'code'    => 201,
                'message' => 'This code does not match'
            ];

            return $res;
        }else {
            return $recoverCode;
        }
    }

    public function resendCode(Request $request)
    {
        $emailOrPhone = $request->input('phone_or_email', null);

        // check if e-mail address is well-formed
        if (filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL)) {
            $emailOrPhone = $emailOrPhone;
        }else {
            // Check first digit zero or not
            if (str_starts_with($emailOrPhone, '0')) {
                $emailOrPhone = '88'.$emailOrPhone;
            } else {
                $emailOrPhone = $emailOrPhone;
            }
        }

        $resendCode = PasswordRecoveryCode::where(function ($q) use ($emailOrPhone) {
            $q->where('email', $emailOrPhone)->orWhere('phone_number', $emailOrPhone);
        })->whereNull('used_at')->first();

        $code = $this->getRandomCode();
        $resendCode->code = $code;
        $res = $resendCode->save();

        if ($res) {
            $SMSGateway = new SMSGateway();
            $SMSGateway->sendPasswordRecoveryCode($emailOrPhone, $code);
            $res = [
                'code'    => 200,
                'message' => 'Code resend successfully'
            ];

            return $res;
        }
    }

    public function phoneActivationResendCode(Request $request)
    {
        $request->validate([
            'phone_number' => ['required']
        ]);

        $phoneNumber = $request->input('phone_number', null);
        // Check first digit zero or not
        if (str_starts_with($phoneNumber, '0')) {
            $phoneNumber = '88'.$phoneNumber;
        } else {
            $phoneNumber = $phoneNumber;
        }

        $code = $this->getRandomCode();
        $user = User::where('phone_number', $phoneNumber)->first();

        if ($user) {
            $user->code = $code;
            $res = $user->save();
            if ($res) {
                $SMSGateway = new SMSGateway();
                $SMSGateway->sendActivationCode($phoneNumber, $code);

                $res = [
                    'code'    => 200,
                    'message' => 'Code resend successfully'
                ];

                return $res;
            }
        }
    }

    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'              => ['required', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        if ($validator->fails()) {
            $res = [
                'code'    => 201,
                'message' => $validator->errors()
            ];

            return $res;
        }

        $emailOrPhone         = $request->input('phone_or_email', null);
        $password             = $request->input('password', null);
        $passwordConfirmation = $request->input('password_confirmation', null);

        if (str_starts_with($emailOrPhone, '0')) {
            $emailOrPhone = '88'.$emailOrPhone;
        } else {
            $emailOrPhone = $emailOrPhone;
        }

        $user = User::where('email', $emailOrPhone)->orWhere('phone_number', $emailOrPhone)->first();

        if ($user) {
            $user->password = Hash::make($password);
            $user->save();
            $res = [
                'code' => 200,
                'message' => 'Password update successfully'
            ];

            $recoverCode = PasswordRecoveryCode::where(function($query) use ($emailOrPhone) {
                $query->where('email', $emailOrPhone)->orWhere('phone_number', $emailOrPhone);
            })->whereNull('used_at')->first();

            $now = Carbon::now();
            $recoverCode->used_at = $now;
            $recoverCode->save();

            Utility::setUserEvent('customer-password-update', [
                'user' => $user,
            ]);

            return $res;
        } else {
            Utility::setUserEvent('customer-password-update-faild', [
                'user' => [
                    'email_phone' => $emailOrPhone,
                    'password' => $password
                ],
            ]);

            $res = [
                'code'    => 201,
                'message' => 'The email or phone number not valid'
            ];

            return $res;
        }
    }

    public function sendActivatonCode()
    {
        return view('frontend.pages.send-activation-code');
    }

    public function phoneActivationcodeView(Request $request, $phoneNumber)
    {
        return view('frontend.pages.send-activation-code', [
            'phoneNumber' => $phoneNumber
        ]);
    }

    public function phoneActivationcodeCheck(Request $request)
    {
        $request->validate([
            'phone_number' => ['required'],
            'pin_code'     => ['required']
        ]);

        $phoneNumber = $request->input('phone_number', null);
        $code        = $request->input('pin_code', null);

        $user = User::where('phone_number', $phoneNumber)->first();
        if($user) {
            if ($user->code == $code) {
                $user->ac_active = 1;
                $user->save();

                $intendedURL = session('url.intended') ? session('url.intended') : $this->successLoginRedirectRoute;
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

    public function sendotp(Request $request)
    {
        $phoneNumber = $request->input('phone_number', null);

        if ($phoneNumber) {
            // Check first digit zero or not
            if (str_starts_with($phoneNumber, '0')) {
                $phoneNumber = '88'.$phoneNumber;
            } else {
                $phoneNumber = $phoneNumber;
            }
            $code = $this->getRandomCode();
            $user = User::where('phone_number', $phoneNumber)->first();
            $user->code = $code;
            $res = $user->save();
            if ($res) {
                $SMSGateway = new SMSGateway();
                $SMSGateway->sendActivationCode($phoneNumber, $code);
                $res = [
                    'success' => true,
                    'code'    => 200,
                    'message' => 'OTP send successfully'
                ];

                return $res;
            }
        }
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
