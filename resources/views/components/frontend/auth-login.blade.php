{{-- ==============Login New Form================ --}}
<section id="login-section" class="">
    {{-- Step 1 --}}
    <div id="login-step-div-1" class="common-steps w-full lg:w-[500px] xl:w-[500px] mx-auto px-0">
        <div class="">
            <div class="body rounded pb-2 md:pb-2 lg:pb-4 px-4 lg:px-0">
                <div class="form-item">
                    <label class="form-label">Your Phone Number<span class="ml-1 text-red-500 font-medium">*</span></label>
                    <div class="flex">
                        <div class="left-0 flex items-center">
                            <select class="text-xs md:text-base rounded rounded-r-none focus:ring-0 focus:outline-none">
                                <option>+880</option>
                            </select>
                        </div>
                        <input id="input-phone-number"
                            class="w-full text-xs md:text-base border-l-0 rounded rounded-l-none focus:ring-0 focus:outline-none placeholder:text-xs md:placeholder:text-sm"
                            type="text" placeholder="1XXXXXXXXX"/>
                        </div>
                        <div class="flex justify-between text-gray-500 mt-1">
                            <span class="text-sm">Don`t have a account</span>
                            <a class="text-sm hover:text-[#00798c]" href="{{ route('registration') }}">Register now</a>
                        </div>
                </div>
                <div class="mt-4">
                    <button id="btn-login-step-1" type="button" class="btn btn-md btn-primary btn-block">
                        <i class="login-page-loading-icon fa-solid fa-spinner fa-spin mr-2"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Step 2 --}}
    <div id="login-step-div-2" class="steps md:w-[500px] lg:w-[500px] xl:w-[500px] mx-auto hidden">
        <div class="">
            <div class="body px-4">
                <div class="form-item flex justify-between">
                    <label class="form-label">Enter your OTP <span class="text-red-500 font-medium">*</span></label>
                    <div class="flex items-center justify-end relative">
                        <input id="input-otp-code" class="form-input flex-1" type="text" placeholder="Please enter your OTP"
                        autocomplete="off"/>
                    </div>
                    <div class="flex justify-between">
                        <a id="input-resend-otp-code" class="mt-2 text-primary text-sm">Resend</a>
                    </div>
                </div>
                <div class="mt-4">
                    <button id="btn-login-step-2" type="button" class="btn btn-primary btn-block">
                        <i class="login-page-loading-icon fa-solid fa-spinner fa-spin mr-2"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        var   currentStep      = 1;
        var   commonSteps      = $('.common-steps');
        var   loginStepDiv1    = $('#login-step-div-1');
        var   loginStepDiv2    = $('#login-step-div-2');
        var   btnLoginStep1    = $('#btn-login-step-1');
        var   btnLoginStep2    = $('#btn-login-step-2');
        var   inputPhoneNumber = $('#input-phone-number');
        var   inputOtpCode     = $('#input-otp-code');
        // resend code
        var resendCodeEndPoint   = '/resend-otp-code';
        var inputResendOtpCode   = $('#input-resend-otp-code');
        var loginPageLoadingIcon = $('.login-page-loading-icon').hide();

        $(function() {
            $('#login-section').keypress(function (e) {
                var key = e.which;
                if(key == 13)  // the enter key code
                {
                    if (currentStep == 1) {
                        loginPageLoadingIcon.show();
                        var phoneNumber = inputPhoneNumber.val();
                        if (phoneNumber) {
                            loginStep1(phoneNumber);
                        } else {
                            loginPageLoadingIcon.hide();
                            __showNotification('error', 'Please enter phone number');
                            return false;
                        }
                    }

                    if (currentStep == 2) {
                        loginPageLoadingIcon.show();
                        var phoneNumber = inputPhoneNumber.val();
                        var otpCode     = inputOtpCode.val();

                        if (phoneNumber, otpCode) {
                            loginStep2(phoneNumber, otpCode);
                        } else {
                            loginPageLoadingIcon.hide();
                            __showNotification('error', 'Please enter OTP');
                            return false;
                        }
                    }
                }
            });

            btnLoginStep1.click(function() {
                loginPageLoadingIcon.show();
                var phoneNumber = inputPhoneNumber.val();
                if (phoneNumber) {
                    loginStep1(phoneNumber);
                } else {
                    loginPageLoadingIcon.hide();
                    __showNotification('error', 'Please enter phone number');
                    return false;
                }
            });

            btnLoginStep2.click(function() {
                loginPageLoadingIcon.show();
                var otpCode     = inputOtpCode.val();
                var phoneNumber = inputPhoneNumber.val();

                if (phoneNumber, otpCode) {
                    loginStep2(phoneNumber, otpCode);
                } else {
                    loginPageLoadingIcon.hide();
                    __showNotification('error', 'Please enter OTP');
                    return false;
                }
            });

            inputResendOtpCode.click(function() {
                var phoneNumber = inputPhoneNumber.val();
                resendOtpCode(phoneNumber);
            });
        });

        function loginStep1(phoneNumber) {
            axios.post('/check-user', {
                phone_number: phoneNumber,
                '_token': '{{ csrf_token() }}'
            })
            .then((res) => {
                if (res.data.success) {
                    commonSteps.hide();
                    loginStepDiv2.show();
                    currentStep = 2;
                    loginPageLoadingIcon.hide();
                } else {
                    loginPageLoadingIcon.hide();
                    __showNotification('error', 'Don`t have a account register first')
                    return false;
                }
            })
            .catch((error) => {
                loginPageLoadingIcon.hide();
                console.log(error);
            });
        }

        function loginStep2(phoneNumber, otpCode) {
            axios.post('/login', {
                phone_number: phoneNumber,
                otp_code: otpCode
            })
            .then((res) => {
                if (res.data.success) {
                    onSuccessLogin();
                    loginPageLoadingIcon.hide();
                } else {
                    loginPageLoadingIcon.hide();
                    __showNotification('error', res.data.msg);
                    return false;
                }
            })
            .catch((error) => {
                console.log(error);
                loginPageLoadingIcon.hide();
            });
        }

        // Resend activation code
        function resendOtpCode(phoneNumber) {
            axios.get(resendCodeEndPoint, {
                params: {
                    phone_number: phoneNumber
                }
            })
            .then(function (res) {
                if (res.data.success) {
                    __showNotification('success', res.data.msg);
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        function onSuccessLogin() {
            __redirectPreviousURL();
        }
    </script>
@endpush
