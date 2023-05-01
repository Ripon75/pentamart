{{-- ==============Login New Form================ --}}
<section id="login-section" class="">
    <div id="login-step-1" class="steps w-full lg:w-[500px] xl:w-[500px] mx-auto px-0">
        <div class="">
            <div class="body rounded pb-2 md:pb-2 lg:pb-4 px-4 lg:px-0">
                <div class="form-item">
                    <label class="form-label">Phone Number<span class="ml-1 text-red-500 font-medium">*</span></label>
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
                </div>
                <div class="mt-4">
                    <button id="login-step1-button-confirm" type="button" class="btn btn-md btn-primary btn-block">
                        <i class="login-page-loading-icon fa-solid fa-spinner fa-spin mr-2"></i>
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="login-step-2" class="steps md:w-[500px] lg:w-[500px] xl:w-[500px] mx-auto hidden">
        <div class="">
            <div class="body px-4">
                <div class="form-item flex justify-between">
                    <label class="form-label">Password <span class="text-red-500 font-medium">*</span></label>
                    <div class="flex items-center justify-end relative">
                        <input id="password-format" class="input-password form-input flex-1" type="password" name="password" placeholder="Please enter your password"/>
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
                    <button id="btn-submit-1" type="butoon" class="btn btn-primary btn-block">
                        <i class="login-page-loading-icon fa-solid fa-spinner fa-spin mr-2"></i>
                        Submit
                    </button>
                </div>
                {{-- <div class="text-center mt-2">
                    <span class="text-sm">OR</span>
                </div> --}}
                {{-- <div class="flex gap-2 mt-2">
                    <button id="btn-otp" type="button" class="btn btn-secondary btn-block">Login with OTP</button>
                    <button type="button" class="btn-change-account-number btn btn-success btn-block">Change Number</button>
                </div> --}}
            </div>
        </div>
    </div>

    {{-- <div id="login-step-3" class="steps md:w-[500px] lg:w-[500px] xl:w-[500px] mx-auto hidden">
        <div class="">
            <div class="body px-4">
                <div class="form-item flex justify-between">
                    <label class="form-label">OTP <span class="text-red-500 font-medium">*</span></label>
                    <div class="flex items-center justify-end relative">
                        <input id="input-code" class="form-input flex-1" type="text" placeholder="Please enter your OTP"
                        autocomplete="off"/>
                    </div>
                    <div class="flex justify-between">
                        <a id="resend-code" class="mt-2 text-primary text-sm">Resend</a>
                    </div>
                </div>
                <div class="mt-4">
                    <button id="btn-submit-2" type="button" class="btn btn-primary btn-block">
                        <i class="login-page-loading-icon fa-solid fa-spinner fa-spin mr-2"></i>
                        Submit
                    </button>
                </div>
                <div class="flex gap-2 mt-4">
                    <button id="btn-password" type="button" class="btn btn-secondary btn-block">Login with password</button>
                    <button type="button" class="btn-change-account-number btn btn-success btn-block">Change Number</button>
                </div>
            </div>
        </div>
    </div> --}}
</section>
{{-- .//==============Login New Form================ --}}

@push('scripts')
    <script>
        var   eyeOpen              = $('.eye-open').hide();
        var   eyeClose             = $('.eye-close');
        const passwordFormat       = document.querySelector("#password-format");
        var   currentStep          = 1;
        var   steps                = $('.steps');
        var   step1                = $('#login-step-1');
        var   step2                = $('#login-step-2');
        var   step3                = $('#login-step-3');
        var   loginStep1BtnConfirm = $('#login-step1-button-confirm');
        var   btnSubmit1           = $('#btn-submit-1');
        var   btnPassword          = $('#btn-password');
        var   btnOTP               = $('#btn-otp');
        var   changeAccountNumber  = $('.btn-change-account-number');
        var   btnSubmit2           = $('#btn-submit-2');
        var   inputCode            = $('#input-code');
        var   inputPhoneNumber     = $('#input-phone-number');
        var   inputPassword        = $('.input-password');
        // resend code
        var resendCodeEndPoint = '/phone/activation/resend-code';
        var resendCode         = $('#resend-code');
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
                            __step1(phoneNumber);
                        } else {
                            loginPageLoadingIcon.hide();
                            __showNotification('error', 'Please enter phone number', 1000);
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
                            __step2(phone, password, isRemember);
                        } else {
                            loginPageLoadingIcon.hide();
                            __showNotification('error', 'Please enter password', 1000);
                            return false;
                        }
                    }

                    if (currentStep == 3) {
                        loginPageLoadingIcon.show();
                        var code = inputCode.val();
                        var phoneNumber = inputPhoneNumber.val();
                        if (code) {
                            __step3(phoneNumber, code);
                        } else {
                            loginPageLoadingIcon.hide();
                            __showNotification('error', 'Please provided your OTP', 1000);
                            return false;
                        }
                    }
                }
            });

            loginStep1BtnConfirm.click(function() {
                loginPageLoadingIcon.show();
                var phoneNumber = inputPhoneNumber.val();
                if (phoneNumber) {
                    __step1(phoneNumber);
                } else {
                    loginPageLoadingIcon.hide();
                    __showNotification('error', 'Please enter phone number', 1000);
                    return false;
                }
            });

            btnSubmit1.click(function() {
                var password = inputPassword.val();
                var phone    = inputPhoneNumber.val();
                var isRemember = false;
                loginPageLoadingIcon.show();

                $('input:checkbox[id=is-remember]:checked').each(function()
                {
                    isRemember = $(this).val();
                });

                if (phone, password) {
                    __step2(phone, password, isRemember);
                } else {
                    loginPageLoadingIcon.hide();
                    __showNotification('error', 'Please enter password', 1000);
                    return false;
                }
            });

            btnOTP.click(function() {
                var phoneNumber = inputPhoneNumber.val();
                steps.hide();
                step3.show();
                currentStep = 3;
                __sendOTP(phoneNumber);
            });

            btnPassword.click(function() {
                steps.hide();
                step2.show();
                currentStep = 2;
            });

            changeAccountNumber.click(function() {
                steps.hide();
                step1.show();
                currentStep = 1;
            });

            btnSubmit2.click(function() {
                var code = inputCode.val();
                var phoneNumber = inputPhoneNumber.val();
                loginPageLoadingIcon.show();
                if (code) {
                    __step3(phoneNumber, code);
                } else {
                    loginPageLoadingIcon.hide();
                    __showNotification('error', 'Please provided your OTP', 1000);
                    return false;
                }
            });

            resendCode.click(function() {
                var phoneNumber = inputPhoneNumber.val();
                __resendCode(phoneNumber);
            });
        });

        function __step1(phoneNumber) {
            axios.post('/login', {
                phone_number: phoneNumber,
                '_token': '{{ csrf_token() }}'
            })
            .then((response) => {
                if (response.data.success) {
                    if (!response.data.ac_status) {
                        var phoneNum = response.data.phone_number;
                        location.href = '/phone/activation/code-check/' + phoneNum;
                    } else {
                        steps.hide();
                        step2.show();
                        currentStep = 2;
                    }
                    loginPageLoadingIcon.hide();
                } else {
                    location.href = '{{ route('signup') }}?phone_number='+phoneNumber;
                }
            })
            .catch((error) => {
                console.log(error);
                loginPageLoadingIcon.hide();
            });
        }

        function __step2(phone, password, isRemember=false) {
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
                    __showNotification('error', "User credential doesn't match.", 1000)
                    return false;
                }
            })
            .catch((error) => {
                console.log(error);
                loginPageLoadingIcon.hide();
            });
        }

        function __step3(phoneNumber, code) {
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
                    __showNotification('error', 'Please provided valid OTP', 1000);
                    return false;
                }
            })
            .catch((error) => {
                console.log(error);
                loginPageLoadingIcon.hide();
            })
        }

        function __sendOTP(phoneNumber) {
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

        // Resend code
        function __resendCode(phoneNumber) {
            axios.get(resendCodeEndPoint, {
                params: {
                    phone_number: phoneNumber
                }
            })
            .then(function (response) {
                if (response.data.code === 200) {
                __showNotification('success', response.data.message, 1000);
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        function onSuccessLogin() {
            __adminLogin();
            __redirectPreviousURL();
        }

        // Admin login
        function __adminLogin() {
            @php
                $posBaseURL  = config('pos.api.base_url');
                $posUsername = config('pos.api.username');
                $posPassword = config('pos.api.password');
            @endphp
            var endPoint = `{{ $posBaseURL }}/api/admin/auth/public/login`;

            var res = axios.post(endPoint, {
                email: `{{ $posUsername }}`,
                password: `{{ $posPassword }}`

            })
            .then(function (response) {
                var token = response.data.token;
                // set localstorage
                localStorage.setItem('pos_token', token);
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    </script>
@endpush
