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
                                    <div class="absolute left-[19%]">
                                        <img class="w-[50px] mt-[22px]" src="{{ asset('images/user2.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="w-[102%] text-center" style="color: darkblue; padding:10px 12px 10px;">
                                <button style="font-weight: bold;" id="loginBtn">LOGIN</button>
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

                            <div id="phoneInput">
                                <div class="w-[80%] block mx-auto form-item">
                                    <label class="form-label">Phone Number <span
                                            class="text-red-500 font-medium">*</span></label>
                                    <input type="text" id="number"
                                        value="{{ old('phone_number') ?? Request::get('phone_number') }}"
                                        name="phone_number" class="form-input rounded" placeholder="Your phone number" />

                                    <span class="error"></span>
                                </div>

                                <div class="w-[50%] block mx-auto mt-8">
                                    <button id="nextfrmBtn" type="button" class="btn btn-primary btn-block">Next</button>
                                </div>
                            </div>

                            <div id="emailInput" style="display: none;">
                                <div class="w-[80%] block mx-auto form-item">
                                    <label class="form-label">Email <span class="text-red-500 font-medium">*</span></label>
                                    <input type="email" value="{{ old('phone_number') ?? Request::get('phone_number') }}"
                                        name="email" id="email" class="form-input rounded"
                                        placeholder="Your phone number" />
                                </div>

                                <div class="w-[80%] block mx-auto form-item">
                                    <label class="form-label">Password <span
                                            class="text-red-500 font-medium">*</span></label>
                                    <input type="password" value="{{ old('phone_number') ?? Request::get('phone_number') }}"
                                        name="password" id="password" class="form-input rounded"
                                        placeholder="Your password" />
                                </div>

                                <div class="w-[50%] block mx-auto mt-8">
                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
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
        $("#emailBtn").click(function() {
            $(this).addClass('phoneBtn');
            $("#emailInput").show();
            $("#phoneInput").hide();
            $("#phoneBtn").removeClass('phoneBtn');
        });

        $("#phoneBtn").click(function() {
            $(this).addClass('phoneBtn');
            $("#phoneInput").show();
            $("#emailInput").hide();
            $("#emailBtn").removeClass('phoneBtn');
        });

        $("#loginBtn").click(function() {
            $("#loginForm").show();
            $("#such").show();
            $("#signupForm").hide();
        });

        $('#logForm').click(function() {
            $('#bodyP').show();
        });

        $('#nextfrmBtn').click(function() {
            var number = $('#number').val();
            var email = $('#email').val();

            if (number == '') {
                $('.error').text('Please fill first *');
                $('.error').css({
                    'color': 'darkred',
                    'font-size': '14px',
                    'margin-left': '5px'
                });
            } else {
                $('.error').text('Looks good!');
                $('#passwordBox').show();
                $('#nextfrmBtn').hide();
            }
        });
    });
</script>
