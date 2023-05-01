@extends('frontend.layouts.default')
@section('title', 'My-Password')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            {{-- =======List========= --}}
            <div class="col-span-1 hidden sm:hidden md:hidden lg:block xl:block 2xl:block">
                <x-frontend.customer-nav/>
            </div>
            {{-- =============== --}}
            <div class="col-span-3">
                <div class="flex space-x-2 sm:space-x-2 md:space-x-2 lg:space-x-0 xl:space-x-0 2xl:space-x-0">
                    <div class="relative block sm:block md:block lg:hidden xl:hidden 2xl:hidden">
                        <button id="category-menu" onclick="menuToggleCategory()" class="h-[46px] w-14 bg-white flex items-center justify-center rounded border-2 ">
                            <i class="text-xl fa-solid fa-ellipsis-vertical"></i>
                        </button>
                          {{-- ===Mobile menu for order===== --}}
                        <div id="category-list-menu" style="display: none" class="absolute z-10 left-0 w-60">
                            <x-frontend.customer-nav/>
                        </div>
                    </div>
                    <div class="mb-4 flex-1">
                        <x-frontend.header-title
                            type="else"
                            title="Change Password"
                            bg-Color="#00798c"
                        />
                    </div>
                </div>
                <div class="card p-4">
                    <div class="">
                        <form class="w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2" action="{{ route('my.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if(Session::has('message'))
                                <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                            @endif

                            <div class="form-item flex justify-between">
                                <label class="form-label">Current Password <span class="text-red-600">*</span></label>
                                <div class="flex items-center justify-end relative">
                                    <input id="password-one" class="form-input flex-1" type="password" name="current_password"/>
                                    <div class="absolute mr-4">
                                        <i id="eye-open-one" class="fa-regular fa-eye"></i>
                                        <i id="eye-close-one" class="fa-regular fa-eye-slash"></i>
                                    </div>
                                </div>
                                <span class="text-xs mt-1 px-1 text-primaryError-darkest">
                                    @error('current_password') {{ $message }} @enderror
                                    {{-- Show error message if current password does not match --}}
                                    @if(Session::has('failed'))
                                        <span>{{ Session::get('failed') }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="form-item">
                                <label class="form-label">New Password <span class="text-red-600">*</span></label>
                                <div class="flex items-center justify-end relative">
                                    <input id="password-two" class="form-input flex-1" type="password" name="new_password"/>
                                    <div class="absolute mr-4">
                                        <i id="eye-open-two" class="fa-regular fa-eye"></i>
                                        <i id="eye-close-two" class="fa-regular fa-eye-slash"></i>
                                    </div>
                                </div>
                                <span class="form-helper error">@error('new_password') {{ $message }} @enderror</span>
                            </div>
                            <div class="form-item">
                                <label class="form-label">Confirm new Password <span class="text-red-600">*</span></label>
                                <div class="flex items-center justify-end relative">
                                    <input id="password-three" class="form-input flex-1" type="password" name="new_password_confirmation"/>
                                    <div class="absolute mr-4">
                                        <i id="eye-open-three" class="fa-regular fa-eye"></i>
                                        <i id="eye-close-three" class="fa-regular fa-eye-slash"></i>
                                    </div>
                                </div>
                                <span class="form-helper error">@error('new_password_confirmation') {{ $message }} @enderror</span>
                            </div>
                            <div class="mt-4 text-right">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script>
        var   openIconOne    = $('#eye-open-one').hide();
        var   closeIconOne   = $('#eye-close-one');
        var   openIconTwo    = $('#eye-open-two').hide();
        var   closeIconTwo   = $('#eye-close-two');
        var   openIconThree  = $('#eye-open-three').hide();
        var   closeIconThree = $('#eye-close-three');
        const passwordOne    = document.querySelector("#password-one");
        const passwordTwo    = document.querySelector("#password-two");
        const passwordThree  = document.querySelector("#password-three");

        $(function() {
            // Set time to flash message
            setTimeout(function(){
                $("div.alert").remove();
            }, 5000 );

            // For current password
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
            // For new password
            closeIconTwo.click(function() {
                openIconTwo.show();
                closeIconTwo.hide();
                passwordTwo.setAttribute('type', 'text');
            });

            openIconTwo.click(function() {
                openIconTwo.hide();
                closeIconTwo.show();
                passwordTwo.setAttribute('type', 'password');
            });
            // for confirm password
            closeIconThree.click(function() {
                closeIconThree.hide();
                openIconThree.show();
                passwordThree.setAttribute('type', 'text');
            });

            openIconThree.click(function() {
                openIconThree.hide();
                closeIconThree.show();
                passwordThree.setAttribute('type', 'password');
            });
        });

        // Category Menu for Address
        function menuToggleCategory() {
            var categoryList = document.getElementById('category-list-menu');
            if(categoryList.style.display == "none") { // if is menuBox displayed, hide it
                categoryList.style.display = "block";
            }
            else { // if is menuBox hidden, display it
                categoryList.style.display = "none";
            }
        }
    </script>
@endpush
