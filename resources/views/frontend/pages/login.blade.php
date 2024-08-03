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
        padding: 5px;
        font-size: 15px;
        border-radius: 4px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .borderLeft {
        /* border-left: 1px solid darkblue;
        border-bottom: 1px solid darkblue; */
    }

    .borderRight {
        /* border-right: 1px solid darkblue;
        border-bottom: 1px solid darkblue; */
    }
</style>
@section('title', 'login')
@section('content')
    <section class="">
        <div class="container page-section page-top-gap">
            <div class="sm:[w-500px] md:w-[500px] lg:w-[500px] xl:w-[500px] 2xl:w-[500px] mx-auto">
                <div class="card shadow" style="background-color: #d3e6e9;">
                    <div class="body p-4">

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
                        </div>
                        <hr>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            @method('POST')

                            <div>
                                <div class="w-[80%] block mx-auto form-item">

                                    @if (Session::has('error'))
                                        <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                                    @endif

                                    <label class="form-label">Phone Number
                                        <span class="text-red-500 font-medium">*</span>
                                    </label>
                                    <input type="text" name="phone_number" id="phone_number" class="form-input rounded"
                                        placeholder="Your phone number" />
                                    <span id="show-email-error-msg" class="text-red-400 text-sm"></span>

                                    @error('phone_number')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="w-[80%] block mx-auto form-item">
                                    <label class="form-label">Password <span
                                            class="text-red-500 font-medium">*</span></label>
                                    <input type="password" name="password" id="password" class="form-input rounded"
                                        placeholder="Your password" />
                                    <span id="show-password-error-msg" class="text-red-400 text-sm"></span>

                                    @error('password')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="w-[50%] block mx-auto mt-8">
                                    <button class="btn-login-submit btn btn-primary btn-block">Login</button>
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
