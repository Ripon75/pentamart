@extends('frontend.layouts.default')
@section('title', 'registration')
@section('content')
    {{-- ==========registration Form============== --}}
    <section class="">
        <div class="container page-section page-top-gap">
            <div class="sm:[w-500px] md:w-[500px] lg:w-[500px] xl:w-[500px] 2xl:w-[500px] mx-auto">
                <div class="card shadow" style="background-color: #d3e6e9;">
                    <div class="body p-4">
                        <div>
                            <div style="background-color: #00798c;" class="w-20 h-20 block mx-auto rounded-full">
                                <div class="relative">
                                    <div class="absolute left-[19%]">
                                        <img class="w-[50px] mt-[22px]" src="{{ asset('images/user2.png') }}"
                                            alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="w-[100%] text-center" style="color: darkblue; padding:10px 12px 10px;">
                                <p class="text-2xl font-semibold">SIGN UP</p>
                            </div>
                        </div>
                        <form action="{{ route('registration.store') }}" method="POST">
                            @csrf

                            @if (Session::has('error'))
                                <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                            @endif

                            <div class="w-[80%] block mx-auto form-item ">
                                {{-- <label class="form-label">Name <span class="text-red-500 font-medium">*</span></label> --}}
                                <input type="text" value="{{ old('name') }}" name="name"
                                    placeholder="Your full name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-[80%] block mx-auto form-item">
                                {{-- <label class="form-label">Email (Optional)</label> --}}
                                <input type="email" value="{{ old('email') }}" name="email" placeholder="Email Address"
                                    class="form-input" />
                                @error('email')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-[80%] block mx-auto form-item">
                                {{-- <label class="form-label">Password <span class="text-red-500 font-medium">*</span></label> --}}
                                <div class="relative flex items-center justify-end">
                                    <input id="password-one" class="form-input flex-1" type="password"
                                        placeholder="Please enter your password" name="password" autocomplete="off" />
                                    <div class="absolute mr-4">
                                        <i id="eye-open-one" class="fa-regular fa-eye"></i>
                                        <i id="eye-close-one" class="fa-regular fa-eye-slash"></i>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-[80%] block mx-auto form-item">
                                {{-- <label class="form-label">Confirm Password <span
                                        class="text-red-500 font-medium">*</span></label> --}}
                                <div class="relative flex items-center justify-end">
                                    <input id="password-two" class="form-input flex-1" placeholder="Confirm password"
                                        type="password" name="password_confirmation" autocomplete="off" />
                                    <div class="absolute mr-4">
                                        <i id="eye-open-two" class="fa-regular fa-eye"></i>
                                        <i id="eye-close-two" class="fa-regular fa-eye-slash"></i>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- <div class="flex space-x-2 items-center mt-2">
                                <input class="focus:ring-0" type="checkbox" value="1" name="terms_conditons">
                                <span class="text-gray-500 text-sm">
                                    I agree with
                                    <a href="{{ route('terms.and.condition') }}" class="text-primary">Terms and
                                        Conditions</a>
                                </span>
                            </div>

                            @error('terms_conditons')
                                <span class="form-helper error text-xs text-red-700">{{ $message }}</span>
                            @enderror --}}

                            <div class="w-[50%] block mx-auto mt-8">
                                <button style="background-color: #22bc1b;color:#fff;" type="submit"
                                    class="btn btn-primary btn-block">Register</button>
                            </div>

                            <div class="mt-7 mb-4">
                                <div class="text-center mt-4 text-gray-500 text-sm">Already have an account? <a
                                        href="{{ route('login') }}" style="color: #00798c;">Login</a></div>
                                {{-- <a href="{{ route('login') }}" class="btn btn-block mt-2">
                                    Login
                                </a> --}}
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
        var openIconOne = $('#eye-open-one').hide();
        var closeIconOne = $('#eye-close-one');
        var openIconTwo = $('#eye-open-two').hide();
        var closeIconTwo = $('#eye-close-two');
        const passwordOne = document.querySelector("#password-one");
        const passwordTwo = document.querySelector("#password-two");
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
