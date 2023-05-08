@extends('frontend.layouts.default')

@section('title', 'Password Recover')

@section('content')
    <!-- ========Login Form ======= -->
      <section class="">
        <div class="container page-section">
            <div class="md:w-[500px] lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <div id="step-1" class="step">
                            <div class="form-item">
                                <label class="form-label">Enter your phone number<span class="text-red-500 font-medium">*</span></label>
                                <input type="text" id="phone-or-email" name="email" placeholder="Please enter your phone number" class="form-input" autocomplete="off"/>
                                @error('email')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <button type="button" id="btn-submit-phone-email" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                        <div id="step-2" class="step">
                            <div class="form-item">
                                <label class="form-label">Enter your OTP code<span class="text-red-500 font-medium">*</span>
                                </label>
                                <input type="text" id="input-otp-code" name="code" class="form-input" placeholder="Enter your otp code" autocomplete="off"/>
                                <a id="resend-otp-code">Resend code</a>
                                @error('code')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <button type="button" id="btn-submit-code" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                        <div id="step-3" class="step">
                            <div class="form-item">
                                <label class="form-label">New Password</label>
                                <div class="flex items-center justify-end relative">
                                    <input id="input-new-password" class="form-input flex-1 password-one" type="password" autocomplete="off"/>
                                    <div class="absolute mr-4">
                                        <i id="eye-open-one" class="fa-regular fa-eye"></i>
                                        <i id="eye-close-one" class="fa-regular fa-eye-slash"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item">
                                <label class="form-label">Re-type new Password</label>
                                <div class="flex items-center justify-end relative">
                                    <input id="password-confirmation" class="form-input flex-1 password-two" type="password" autocomplete="off"/>
                                    <div class="absolute mr-4">
                                        <i id="eye-open-two" class="fa-regular fa-eye"></i>
                                        <i id="eye-close-two" class="fa-regular fa-eye-slash"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <button type="button" id="btn-update-password" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        var storePhoneOrEmailEndPoint = '/password/recover/email-or-phone';
        var checkCodeEndPoint         = '/password/recover/send-code';
        var storePasswordEndPoint     = '/password/recover/update-password';
        var otpResendCodeEndPoint        = '/password/recover/resend-code';
        var btnSubmitPE               = $('#btn-submit-phone-email');
        var btnSubmitCode             = $('#btn-submit-code');
        var btnUpdatePassword         = $('#btn-update-password');
        var inputPhoneOrEmail         = $('#phone-or-email');
        var inputOtpCode              = $('#input-otp-code');
        var inputNewPassword          = $('#input-new-password');
        var inputPasswordConfirmation = $('#password-confirmation');
        var resendOtpCode                = $('#resend-otp-code');

        var   openIconOne     = $('#eye-open-one').hide();
        var   closeIconOne    = $('#eye-close-one');
        var   openIconTwo     = $('#eye-open-two').hide();
        var   closeIconTwo    = $('#eye-close-two');
        const passwordOne     = document.querySelector(".password-one");
        const passwordTwo     = document.querySelector(".password-two");

        var currentStep = 1;
        var maxStep = 3;
        changeStep(1);

        $(function() {

            // For password
            closeIconOne.click(function() {
                openIconOne.show();
                closeIconOne.hide();
                passwordOne.setAttribute('type', 'text');
            });

            openIconOne.click(function() {
                openIconOne.hide();
                closeIconOne.show();
                passwordOne.setAttribute('type', 'password');
            });
            // for confirm password
            closeIconTwo.click(function() {
                closeIconTwo.hide();
                openIconTwo.show();
                passwordTwo.setAttribute('type', 'text');
            });

            openIconTwo.click(function() {
                openIconTwo.hide();
                closeIconTwo.show();
                passwordTwo.setAttribute('type', 'password');
            });

            btnSubmitPE.click(function() {
                var phoneOrEmail = inputPhoneOrEmail.val();
                if (phoneOrEmail) {
                    __addPhoneOrEmail(phoneOrEmail)
                } else {
                    __showNotification('error', 'Please enter phone number', 2000);
                return false;
                }
            });

            btnSubmitCode.click(function() {
                var code = inputOtpCode.val();
                __sendCode(code);
            });

            resendOtpCode.click(function() {
                var phoneOrEmail = inputPhoneOrEmail.val();
                __resendOtpCode(phoneOrEmail);
            });

            btnUpdatePassword.click(function() {
                var phoneOrEmail         = inputPhoneOrEmail.val();
                var password             = inputNewPassword.val();
                var passwordConfirmation = inputPasswordConfirmation.val();
                __updatePassword(phoneOrEmail, password, passwordConfirmation);
            });
        });


        function changeStep(step = 1) {
            if (currentStep <= maxStep) {
                currentStep = step;
                $('.step').hide();
                $(`#step-${currentStep}`).show();
            }
        }

        // Add phone or email
        function __addPhoneOrEmail(phoneOrEmail) {
            axios.post(storePhoneOrEmailEndPoint, {
                phone_or_email: phoneOrEmail
            })
            .then((response) => {
                if (response.data.code === 201) {
                __showNotification('error', response.data.message, 1000);
                return false;
                }else {
                    if (response.data.code === 200) {
                __showNotification('success', response.data.message, 1000);
                    }
                    changeStep(2);
                }
            })
            .catch((error) => {
                __showNotification('error', response.data.message, 1000);
            })
            .then(() => {

            });
        }

        // Send code
        function __sendCode(code) {
            axios.post(checkCodeEndPoint, {
                code: code
            })
            .then((response) => {
                if (response.data.code === 201) {
                __showNotification('error', response.data.message, 2000);
                return false;
                } else {
                    changeStep(3);
                }
            })
            .catch((error) => {
                console.log(error);
            })
            .then(() => {

            });
        }

        // Resend code
        function __resendOtpCode(phoneOrEmail) {
            axios.get(otpResendCodeEndPoint, {
                    params: {
                    phone_or_email: phoneOrEmail
                    }
                })
                .then(function (response) {
                    if (response.data.code === 200) {
                        __showNotification('success', response.data.message, 2000);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function __updatePassword(phoneOrEmail, password, passwordConfirmation) {
            axios.post(storePasswordEndPoint, {
                phone_or_email: phoneOrEmail,
                password: password,
                password_confirmation: passwordConfirmation
            })
            .then((response) => {
                if (response.data.code === 201) {
                    __showNotification('error', response.data.message.password, 2000);
                    return false;
                }  else {
                    if (response.data.code === 200) {
                        __showNotification('success', response.data.message, 2000);
                        setTimeout(function() {
                            window.location.href = "/login";
                        }, 2000);
                    }
                    changeStep(3);
                }
            })
            .catch((error) => {
                // console.log(error);
            });
        }

    </script>
@endpush
