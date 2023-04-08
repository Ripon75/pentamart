<div class="footer-wrapper bg-white border-t">
    <div class="container">
        <footer class="page-footer">
            <div class="main-footer grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-3 py-4 md:py-8 gap-4">
                <div class="col-span-1 flex flex-col space-y-2 order-last md:order-first">
                    <div class="logo-wrapper hidden md:block">
                        {{-- TODO: Make a logo component --}}
                        <img class="logo w-[200px] sm:w-[200px] md:w-[250px] h-[56px] sm:h-[56px] md:h-[64px] mx-auto sm:mx-auto md:mx-auto lg:mr-auto xl:mr-auto xl:ml-0 lg:ml-0" src="{{ $about['logo'] }}">
                    </div>
                    <div class="description text-left sm:text-left md:text-center lg:text-left xl:text-left">
                        <p class="mb-2">{{ $about['description'] }}</p>
                    </div>
                    <div class="contact flex flex-col space-y-2">
                        <div class="flex items-center justify-start sm:justify-start md:justify-center lg:justify-start xl:justify-start space-x-2">
                            <div class="icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="label">{{ $about['loc1'] }} <br>{{ $about['loc2'] }}</div>
                        </div>
                        <div class="flex items-center space-x-2 justify-start sm:justify-start md:justify-center lg:justify-start xl:justify-start">
                            <div class="icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="">
                                <a href="tel:+880 9609080706" class="label">
                                    <span>{{ $about['phone'] }}</span>
                                </a>,
                                <a href="tel:+8801322800327" class="label">
                                    <span>{{ $about['phone2'] }}</span>
                                </a><br>
                                <a href="tel:+8801322800328" class="label">
                                    <span>{{ $about['phone3'] }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 justify-start sm:justify-start md:justify-center lg:justify-start xl:justify-start">
                            <div class="icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <a href="mailto:info@medicart.health" target="_blank" class="label">{{ $about['email'] }}</a>
                        </div>
                    </div>
                </div>
                {{-- =====footer-navs====== --}}
                <div class="col-span-1 grid grid-cols-3 gap-2 sm:gap-2 md:gap-4 lg:gap-4 xl:gap-4">
                    <div class="">
                        <div class="nav mt-6 text-center md:text-center lg:text-left">
                            <div class="header">{{ $nav1['title'] }}</div>
                            <a href="/about" class="item">{{ $nav1['about'] }}</a>
                            <a href="/frequently-asked-questions" class="item">{{ $nav1['faq'] }}</a>
                            <a href="/terms-and-conditions" class="item">{{ $nav1['termsAndConditions'] }}</a>
                        </div>
                    </div>
                    <div class="">
                        <div class="nav mt-6 text-center md:text-center lg:text-left">
                            <div class="header">{{ $nav2['title'] }}</div>
                            @guest
                            <a href="{{ route('login') }}" class="item">{{ $nav2['login'] }}</a>
                            @endguest
                            @auth
                            <a href="/my/dashboard" class="item">{{ $nav2['myAccount'] }} </a>
                            <a href="{{ route('my.wishlist') }}" class="item">{{ $nav2['wishList'] }} </a>
                            @endauth
                            <a href="/products" class="item">{{ $nav2['products'] }}</a>
                            <a href="{{ route('my.order') }}" class="item">{{ $nav2['ordertrac'] }} </a>
                        </div>
                    </div>
                    <div class="">
                        <div class="nav mt-6 text-center sm:text-center lg:text-left">
                            <div class="header">{{ $nav3['title'] }}</div>
                            <a href="/contact" class="item">{{ $nav3['contact'] }}</a>
                            <a href="/privacy-policy" class="item">{{ $nav3['privacy'] }}</a>
                            <a href="/return-policy" class="item">{{ $nav3['return'] }}</a>
                        </div>
                    </div>
                </div>
                {{-- ========Download our app========= --}}
                <div class="download-app-section col-span-1 flex flex-col justify-center lg:justify-self-end ">
                    {{-- <div class="mt-6 text-center sm:text-center md:text-center lg:text-left xl:text-left">
                        <div class="text-lg text-primary font-medium">{{ $nav4['title'] }}</div>
                    </div> --}}
                    {{-- <div class="mt-5 flex space-x-2 justify-center sm:justify-center md:justify-center lg:justify-start xl:justify-start">
                        <a href="" class="">
                            <img class="" src="/images/sample/appStore.png">
                        </a>
                        <a href="">
                            <img class="" src="/images/sample/google-Play.png">
                        </a>
                    </div> --}}
                    <div class="text-center sm:text-center md:text-center lg:text-left xl:text-left">
                        <div class="text-lg text-primary font-medium">{{ $nav4['title2'] }}</div>
                    </div>
                    <div class="mt-5 flex space-x-4 justify-center sm:justify-center md:justify-center lg:justify-start xl:justify-start">
                        {{-- social --}}
                        <div class="social-nav justify-center sm:justify-center md:justify-center lg:justify-start xl:justify-start">
                            <a href="#" class="item">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="item">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

@push('scripts')
    <script>
        // var chatbox = document.getElementById('fb-customer-chat');
        // chatbox.setAttribute("page_id", "107068648773339");
        // chatbox.setAttribute("attribution", "biz_inbox");
    </script>
@endpush
