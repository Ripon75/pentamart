{{-- @extends('frontend.layouts.default')

@section('title', 'Login')

@section('content')

    <div class="py-8 px-4 page-top-gap">
        <x-frontend.auth-login/>
    </div>

@endsection --}}


@extends('frontend.layouts.default')
@section('title', 'login')
@section('content')
    <section class="">
        <div class="container page-section page-top-gap">
            <div class="sm:[w-500px] md:w-[500px] lg:w-[500px] xl:w-[500px] 2xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            @if (Session::has('error'))
                                <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                            @endif

                            <div class="form-item">
                                <label class="form-label">Phone Number <span
                                        class="text-red-500 font-medium">*</span></label>
                                <input type="text" value="{{ old('phone_number') ?? Request::get('phone_number') }}"
                                    name="phone_number" class="form-input rounded" placeholder="Your phone number" />
                                @error('phone_number')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item ">
                                <label class="form-label">Password <span class="text-red-500 font-medium">*</span></label>
                                <input type="password" name="password" value="{{ old('password') }}" autocomplete="off"
                                    placeholder="Your password" class="form-input" />
                                @error('password')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-8">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                            <div class="">
                                <div class="text-center mt-4 text-gray-500 text-sm">Don`t have an account?</div>
                                <a href="{{ route('registration') }}" class="btn btn-block mt-2">
                                    Register
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
