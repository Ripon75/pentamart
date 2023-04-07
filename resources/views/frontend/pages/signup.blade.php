@extends('frontend.layouts.default')
@section('title', 'Signup')
@section('content')
    <!--========Banner start========-->
    <section class="page-top-gap">
        <x-frontend.header-title
            type="default"
            bgColor="linear-gradient( #112f7a, rgba(111, 111, 211, 0.52))"
            bgImageSrc="/images/banners/home-banner.jpg"
            title="Signup"
        />
    </section>
    {{-- ==========Signup Form============== --}}
    <section class="">
        <div class="container page-section">
            <div class="sm:[w-500px] md:w-[500px] lg:w-[500px] xl:w-[500px] 2xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('signup.store') }}" method="POST">
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
                                <input type="text" value="{{ old('name') }}" name="name" placeholder="Jhon Doe" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Phone Number <span class="text-red-500 font-medium">*</span></label>
                                <input type="text" value="{{ old('phone_number') ?? Request::get('phone_number') }}"
                                    name="phone_number" class="form-input rounded" placeholder="1XXXXXXXXX" />
                                @error('phone_number')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Email</label>
                                <input type="email" value="{{ old('email') }}" name="email" placeholder="jhon@example.com" class="form-input" />
                                @error('email')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Password <span class="text-red-500 font-medium">*</span></label>
                                <div class="relative flex items-center justify-end">
                                    <input id="password-one" class="form-input flex-1" type="password" placeholder="Please enter your password" name="password"/>
                                    <div class="absolute mr-4">
                                        <i id="eye-open-one" class="fa-regular fa-eye"></i>
                                        <i id="eye-close-one" class="fa-regular fa-eye-slash"></i>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Confirm Password <span class="text-red-500 font-medium">*</span></label>
                                <div class="relative flex items-center justify-end">
                                    <input id="password-two" class="form-input flex-1" placeholder="Please confirm your password" type="password" name="password_confirmation"/>
                                    <div class="absolute mr-4">
                                        <i id="eye-open-two" class="fa-regular fa-eye"></i>
                                        <i id="eye-close-two" class="fa-regular fa-eye-slash"></i>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex space-x-2 items-center mt-2">
                                <input class="focus:ring-0" type="checkbox" value="1" name="terms_and_conditons">
                                <span class="text-gray-500 text-sm">
                                    I agree with
                                    <a href="/terms-and-conditions" class="text-primary">"Terms and Conditions"</a> &
                                    <a href="/privacy-policy" class="text-primary">"Privacy Policy"</a>
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
                                <a href="{{ route('login') }}" class="btn btn-block mt-2">Login</a>
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

@push('scripts')
    <script>
        var   openIconOne     = $('#eye-open-one').hide();
        var   closeIconOne    = $('#eye-close-one');
        var   openIconTwo     = $('#eye-open-two').hide();
        var   closeIconTwo    = $('#eye-close-two');
        const passwordOne     = document.querySelector("#password-one");
        const passwordTwo     = document.querySelector("#password-two");
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
        });
    </script>
@endpush
