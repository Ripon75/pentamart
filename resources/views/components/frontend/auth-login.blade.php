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
    <div id="login-step-div-2" class="common-steps md:w-[500px] lg:w-[500px] xl:w-[500px] mx-auto hidden">
        <div class="">
            <div class="body px-4">
                <div class="form-item flex justify-between">
                    <label class="form-label">Password <span class="text-red-500 font-medium">*</span></label>
                    <div class="flex items-center justify-end relative">
                        <input id="password-format" class="input-password form-input flex-1" type="password" name="password"
                            placeholder="Please enter your password"
                            autocomplete="off"
                        />
                        <div class="absolute mr-4">
                            <i class="eye-open fa-regular fa-eye"></i>
                            <i class="eye-close fa-regular fa-eye-slash"></i>
                        </div>
                    </div>
                    <div class="flex justify-between mt-2">
                        <div class="flex items-center">
                            <label class="text-gray-500 text-xs md:text-sm">
                                <input id="is-remember" type="checkbox" class="focus:ring-0 text-xs md:text-sm"> Remember me
                            </label>
                        </div>
                        <a href="{{ route('password.recover') }}" class="text-primary text-xs md:text-sm">Forget Password?</a>
                    </div>
                </div>
                <div class="mt-4">
                    <button id="btn-login-step-2" type="butoon" class="btn btn-primary btn-block">
                        <i class="login-page-loading-icon fa-solid fa-spinner fa-spin mr-2"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Step 3 --}}
    <div id="login-step-div-3" class="steps md:w-[500px] lg:w-[500px] xl:w-[500px] mx-auto hidden">
        <div class="">
            <div class="body px-4">
                <div class="form-item flex justify-between">
                    <label class="form-label">Enter your OTP <span class="text-red-500 font-medium">*</span></label>
                    <div class="flex items-center justify-end relative">
                        <input id="input-code" class="form-input flex-1" type="text" placeholder="Please enter your OTP"
                        autocomplete="off"/>
                    </div>
                    <div class="flex justify-between">
                        <a id="input-resend-code" class="mt-2 text-primary text-sm">Resend</a>
                    </div>
                </div>
                <div class="mt-4">
                    <button id="btn-login-step-3" type="button" class="btn btn-primary btn-block">
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
        var   eyeOpen          = $('.eye-open').hide();
        var   eyeClose         = $('.eye-close');
        const passwordFormat   = document.querySelector("#password-format");
        var   commonSteps      = $('.common-steps');
        var   loginStepDiv1    = $('#login-step-div-1');
        var   loginStepDiv2    = $('#login-step-div-2');
        var   loginStepDiv3    = $('#login-step-div-3');
        var   btnLoginStep1    = $('#btn-login-step-1');
        var   btnLoginStep2    = $('#btn-login-step-2');
        var   btnLoginStep3    = $('#btn-login-step-3');
        var   inputPhoneNumber = $('#input-phone-number');
        var   inputPassword    = $('.input-password');
        // resend code
        var resendCodeEndPoint = '/activation-resend-code';
        var inputResendCode    = $('#input-resend-code');
        var loginPageLoadingIcon = $('.login-page-loading-icon').hide();

        $(function() {
            eyeOpen.click(function() {
                eyeOpen.hide();
                eyeClose.show();
                passwordFormat.setAttribute('type', 'password');
            });

            eyeClose.click(function() {
                eyeClose.hide();
                eyeOpen.show();
                passwordFormat.setAttribute('type', 'text');
            });

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
                        var password = inputPassword.val();
                        var phone    = inputPhoneNumber.val();
                        var isRemember = false;
                        $('input:checkbox[id=is-remember]:checked').each(function()
                        {
                            isRemember = $(this).val();
                        });

                        if (phone, password) {
                            loginStep2(phone, password, isRemember);
                        } else {
                            loginPageLoadingIcon.hide();
                            __showNotification('error', 'Please enter password');
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
                var password = inputPassword.val();
                var phone    = inputPhoneNumber.val();
                var isRemember = false;
                loginPageLoadingIcon.show();

                $('input:checkbox[id=is-remember]:checked').each(function()
                {
                    isRemember = $(this).val();
                });

                if (phone, password) {
                    loginStep2(phone, password, isRemember);
                } else {
                    loginPageLoadingIcon.hide();
                    __showNotification('error', 'Please enter password');
                    return false;
                }
            });

            inputResendCode.click(function() {
                var phoneNumber = inputPhoneNumber.val();
                resendActivationCode(phoneNumber);
            });
        });

        function loginStep1(phoneNumber) {
            axios.post('/login', {
                phone_number: phoneNumber,
                '_token': '{{ csrf_token() }}'
            })
            .then((res) => {
                console.log(res);
                if (res.data.success) {
                    if (!res.data.result.ac_status) {
                        // var pNumber = res.data.result.phone_number;
                        // location.href = '/send-activation-code/' + pNumber;
                        commonSteps.hide();
                        loginStepDiv3.show();
                        currentStep = 3;
                    } else {
                        commonSteps.hide();
                        loginStepDiv2.show();
                        currentStep = 2;
                    }
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

        function loginStep2(phone, password, isRemember=false) {
            axios.post('/login', {
                phone: phone,
                password: password,
                is_remember: isRemember
            })
            .then((response) => {
                if (response.data.success) {
                    onSuccessLogin();
                    loginPageLoadingIcon.hide();
                } else {
                    loginPageLoadingIcon.hide();
                    __showNotification('error', "User credential doesn't match.")
                    return false;
                }
            })
            .catch((error) => {
                console.log(error);
                loginPageLoadingIcon.hide();
            });
        }

        function loginStep3(phoneNumber, code) {
            axios.post('/login', {
                p_number: phoneNumber,
                code: code
            })
            .then((response) => {
                if (response.data.success) {
                    onSuccessLogin();
                    loginPageLoadingIcon.hide();
                } else {
                    loginPageLoadingIcon.hide();
                    __showNotification('error', 'Please provided valid OTP');
                    return false;
                }
            })
            .catch((error) => {
                console.log(error);
                loginPageLoadingIcon.hide();
            })
        }

        function sendActivationOTP(phoneNumber) {
            axios.post('/send/otp', {
                phone_number: phoneNumber
            })
            .then((response) => {
                // console.log(response);
            })
            .catch((error) => {
                console.log(error);
            });
        }

        // Resend activation code
        function resendActivationCode(phoneNumber) {
            axios.get(resendCodeEndPoint, {
                params: {
                    phone_number: phoneNumber
                }
            })
            .then(function (response) {
                if (response.data.code === 200) {
                __showNotification('success', response.data.message);
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
