<div class="footer-wrapper bg-[#00798c] border-t">

    <div class="container">

        <footer class="page-footer">

            <div class="main-footer grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-3 py-4 md:py-8 gap-4">

                {{-- <div class="md:hidden lg:hidden">
                    <img class="" src="/images/logos/logo.png" alt="logo image"
                        style="width: 80%; display:block;margin-left:auto;margin-right:auto;">
                </div> --}}

                <div class="col-span-1 flex flex-col space-y-2 order-last md:order-first">

                    <div class="logo-wrapper hidden md:block">
                        {{-- TODO: Make a logo component --}}
                        <img class="logo w-[200px] sm:w-[200px] md:w-[250px] h-[56px] sm:h-[56px] md:h-[64px] mx-auto sm:mx-auto md:mx-auto lg:mr-auto xl:mr-auto xl:ml-0 lg:ml-0"
                            src="/images/logos/logo.png">
                    </div>

                    <div class="md:hidden lg:hidden">
                        <img class="" src="/images/logos/logo.png" alt="logo image"
                            style="width: 80%; display:block;margin-left:auto;margin-right:auto;">
                    </div>

                    <div class="p-3">
                        <div class="flex justify-items-center p-1">
                            <p class="flex items-center">
                                <i class="fa-solid fa-location-dot text-white"></i>
                            </p>
                            <p class="text-white ml-2">
                                Gulshan, Dhaka, Bangladesh
                            </p>
                        </div>

                        <div class="flex justify-items-center p-1">
                            <p class="flex items-center">
                                <i class="fa-solid fa-phone text-white"></i>
                            </p>
                            <p class="text-white ml-2">
                                09610-609940
                            </p>
                        </div>

                        <div class="flex justify-items-center p-1">
                            <p class="flex items-center">
                                <i class="fa-regular fa-envelope text-white"></i>
                            </p>
                            <p class="text-white ml-2">
                                info@pentamart.com
                            </p>
                        </div>
                    </div>

                </div>
                {{-- =====footer-navs====== --}}
                <div
                    class="col-span-1 grid grid-cols-3 gap-2 sm:gap-2 md:gap-4 lg:gap-4 xl:gap-4 text-white mobile:flex-cols-4">

                    <div class="sm:w-2">
                        <div class="nav mt-6 text-center md:text-center lg:text-left">
                            <a href="/about" class="item">About</a>
                            <a href="/about" class="item">Faq</a>
                        </div>
                    </div>

                    <div class="">
                        <div class="nav mt-6 text-center md:text-center lg:text-left">
                            <a href="{{ route('terms.and.condition') }}" class="item">Terms & Conditions</a>
                            <a href="/contact" class="item">Contact Us</a>
                        </div>
                    </div>

                    <div class="">
                        <div class="nav mt-6 text-center sm:text-center lg:text-left">
                            <a href="/privacy-policy" class="item">Privacy & Policy</a>
                            <a href="/return-policy" class="item">Return & Refund</a>
                        </div>
                    </div>

                </div>
                {{-- ========Download our app========= --}}
                <div class="download-app-section col-span-1 flex flex-col justify-center lg:justify-self-end ">
                    <div class="text-center sm:text-center md:text-center lg:text-left xl:text-left">
                        <div class="text-lg text-white font-medium">Join with us</div>
                    </div>
                    <div
                        class="mt-5 flex space-x-4 justify-center sm:justify-center md:justify-center lg:justify-start xl:justify-start">
                        {{-- social --}}
                        <div
                            class="social-nav justify-center sm:justify-center md:justify-center lg:justify-start xl:justify-start">
                            <a href="#" class="item">
                                <img src="{{ asset('images/sample/facebook.png') }}" alt="facebook"
                                    style="width:20px;height:20px;">
                            </a>
                            <a href="#" class="item">
                                <img src="{{ asset('images/sample/instagram.png') }}" alt="instagram"
                                    style="width:20px;height:20px;">
                            </a>
                            <a href="#" class="item">
                                <img src="{{ asset('images/sample/linkedin.png') }}" alt="linkedin"
                                    style="width:20px;height:20px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
