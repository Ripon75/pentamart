@extends('frontend.layouts.default')
@section('title', 'registration')
@section('content')
    {{-- ==========registration Form============== --}}
    <section class="">
        <div class="container page-section page-top-gap">
            <div class="sm:[w-500px] md:w-[500px] lg:w-[500px] xl:w-[500px] 2xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('registration.store') }}" method="POST">
                            @csrf

                            @if(Session::has('error'))
                            <div class="alert mb-8 error">{{ Session::get('message') }}</div>
                            @endif

                            @if(Session::has('success'))
                            <div class="alert mb-8 success">{{ Session::get('success') }}</div>
                            @endif

                            <input type="hidden" name="type" value="phone"/>

                            <div class="form-item ">
                                <label class="form-label">Name <span class="text-red-500 font-medium">*</span></label>
                                <input type="text" value="{{ old('name') }}" name="name" placeholder="Your name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Phone Number <span class="text-red-500 font-medium">*</span></label>
                                <input type="text" value="{{ old('phone_number') ?? Request::get('phone_number') }}"
                                    name="phone_number" class="form-input rounded" placeholder="1*********" />
                                @error('phone_number')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Email</label>
                                <input type="email" value="{{ old('email') }}" name="email" placeholder="example@gmail.com" class="form-input" />
                                @error('email')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex space-x-2 items-center mt-2">
                                <input class="focus:ring-0" type="checkbox" value="1" name="terms_and_conditons">
                                <span class="text-gray-500 text-sm">
                                    I agree with
                                    <a href="{{ route('terms.and.condition') }}" class="text-primary">"Terms and Conditions"</a> &
                                </span>
                            </div>
                            @error('terms_and_conditons')
                                <span class="form-helper error mt-2 text-xs text-red-700">{{ $message }}</span>
                            @enderror
                            <div class="mt-8">
                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                            <div class="">
                                <div class="text-center mt-4 text-gray-500 text-sm">Already have an account?</div>
                                <a href="{{ route('login') }}" class="btn btn-block mt-2"
                                    @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                                    Login
                                </a>
                            </div>
                            {{-- <div class="text-center mt-4 text-gray-500 text-sm">Or, signup with</div>
                            <div class="flex space-x-6 justify-center mt-4">
                                <button type="button" class="bg-socials-facebook w-full py-2 px-6 text-white rounded "><i class="mr-3 fa-brands fa-facebook-f"></i>Facebook</button>
                                <button type="button" class="bg-socials-google w-full py-2 px-6 text-white rounded "><i class="mr-3 fa-brands fa-google"></i></i>Google</button>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
