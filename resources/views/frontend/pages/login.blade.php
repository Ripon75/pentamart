{{-- @extends('frontend.layouts.default')

@section('title', 'Login')

@section('content')

    <div class="py-8 px-4 page-top-gap">
        <x-frontend.auth-login/>
    </div>

@endsection --}}


@extends('frontend.layouts.default')
<style>
    .signupTitle {
        display: none;
    }

    .phoneBtn {
        background-color: #e9d58d;
        color: darkblue;
        font-weight: 600;
        padding: 2px;
        font-size: 15px;
    }
</style>
@section('title', 'login')
@section('content')
    <section class="">
        <div class="container page-section page-top-gap">
            <div class="sm:[w-500px] md:w-[500px] lg:w-[500px] xl:w-[500px] 2xl:w-[500px] mx-auto">
                <div class="card shadow" style="background-color: #d3e6e9;">
                    <div id="bodyP" class="body p-4">

                        <div>
                            <div style="background-color: #00798c;" class="w-20 h-20 block mx-auto rounded-full">
                                <div class="relative">
                                    <div class="absolute left-[23%]">
                                        <img class="w-[45px] mt-[16px]" src="{{ asset('images/user2.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="w-[102%] text-center" style="color: darkblue; padding:10px 12px 10px;">
                                <button style="font-weight: bold;">LOGIN</button>
                                <span style="font-weight: bold;" style="font-size: 25px;">|</span>
                                <button style="font-weight: bold;"><a href="{{ route('registration') }}" class="">
                                        SIGNUP
                                    </a></button>
                            </div>

                            <div class="text-center" style="padding:10px 12px 10px;">
                                <button class="phoneBtn" id="phoneBtn">
                                    LOGIN WITH PHONE
                                </button>
                                <button id="emailBtn">
                                    LOGIN
                                    WITH EMAIL
                                </button>
                            </div>
                        </div>
                        <hr>
                        <form id="loginForm" action="{{ route('login') }}" method="POST">
                            @csrf

                            @if (Session::has('error'))
                                <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                            @endif

                            {{-- hidden input field --}}
                            <input id="input-login-by-id" type="hidden" name="login_by" value="phone_number">

                            <div id="phoneInput">
                                <div class="w-[80%] block mx-auto form-item">
                                    <label class="form-label">Phone Number <span
                                            class="text-red-500 font-medium">*</span></label>
                                    <input type="text" id="number"
                                        value="{{ old('phone_number') ?? Request::get('phone_number') }}"
                                        name="phone_number" class="form-input rounded" placeholder="Your phone number" />

                                    <span id="show-phone-number-error-msg" class="text-red-400 text-sm"></span>
                                </div>

                                <div class="w-[50%] block mx-auto mt-8">
                                    <button type="button" class="btn-login-submit btn btn-primary btn-block">Next</button>
                                </div>
                            </div>

                            <div id="emailInput" style="display: none;">
                                <div class="w-[80%] block mx-auto form-item">
                                    <label class="form-label">Email <span class="text-red-500 font-medium">*</span></label>
                                    <input type="email" name="email" id="email" class="form-input rounded"
                                        placeholder="Your phone number" />
                                    <span id="show-email-error-msg" class="text-red-400 text-sm"></span>
                                </div>

                                <div class="w-[80%] block mx-auto form-item">
                                    <label class="form-label">Password <span
                                            class="text-red-500 font-medium">*</span></label>
                                    <input type="password" name="password" id="password" class="form-input rounded"
                                        placeholder="Your password" />
                                    <span id="show-password-error-msg" class="text-red-400 text-sm"></span>
                                </div>

                                <div class="w-[50%] block mx-auto mt-8">
                                    <button type="button" class="btn-login-submit btn btn-primary btn-block">Login</button>
                                </div>
                                <p class="text-center text-[12px] mt-2" style="color:#00798c;">
                                    <a href="#">Forget Password ?</a>
                                </p>
                                <div class="w-[50%] block mx-auto mt-4">
                                    <p class="text-center text-[12px] mb-2" style="color:#00798c;">
                                        <a href="{{ route('registration') }}">Don't have any account ?</a>
                                    </p>
                                    <button style="background-color: #22bc1b;color:#fff;" type="submit"
                                        class="btn btn-block">
                                        <a href="{{ route('registration') }}" class="">
                                            Sign Up
                                        </a>
                                    </button>
                                </div>
                            </div>

                            {{-- <div class="">
                                <div class="text-center mt-4 text-gray-500 text-sm">Don`t have an account?</div>
                                <a href="{{ route('registration') }}" class="btn btn-block mt-2">
                                    Register
                                </a>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        var btnLoginSubmit = $('.btn-login-submit');

        $("#emailBtn").click(function() {
            $('#input-login-by-id').val('email');
            $(this).addClass('phoneBtn');
            $("#emailInput").show();
            $("#phoneInput").hide();
            $("#phoneBtn").removeClass('phoneBtn');
        });

        $("#phoneBtn").click(function() {
            $('#input-login-by-id').val('phone_number');
            $(this).addClass('phoneBtn');
            $("#phoneInput").show();
            $("#emailInput").hide();
            $("#emailBtn").removeClass('phoneBtn');
        });

        $('#logForm').click(function() {
            $('#bodyP').show();
        });

        btnLoginSubmit.click(function() {
            var loginBy = $("input[name=login_by]").val();
            var phoneNumber = $("input[name=phone_number]").val();
            var email = $("input[name=email]").val();
            var password = $("input[name=password]").val();

            axios.post('/login', {
                    login_by: loginBy,
                    phone_number: phoneNumber,
                    email: email,
                    password: password
                })
                .then((res) => {
                    if (res.data.success) {
                        if (loginBy === 'phone_number') {
                            window.location.href = `/send-otp-code?phone_number=${phoneNumber}`;
                        } else {
                            window.location.href = "/";
                        }
                    } else {
                        if (res.data.msg.phone_number) {
                            $("input[name=phone_number]").focus();
                            $('#show-phone-number-error-msg').text(res.data.msg.phone_number[0]);
                            return false;
                        } else if (res.data.msg.email) {
                            $("input[name=email]").focus();
                            $('#show-email-error-msg').text(res.data.msg.email[0]);
                            return false;
                        } else if (res.data.msg.password) {
                            $("input[name=password]").focus();
                            $('#show-password-error-msg').text(res.data.msg.password[0]);
                            return false;
                        } else {
                            __showNotification('error', res.data.msg, 5000);
                        }
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        });
    });
</script>
