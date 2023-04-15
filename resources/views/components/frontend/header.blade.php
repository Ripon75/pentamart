<div class="header-wrapper">
    {{-- ============Top header==================== --}}
    <div class="top-header-bar">
        <div class="bg-[#00798c] h-8 sm:h-8 md:h-10">
            <div class="container flex flex-row space-x-4 items-center justify-between sm:justify-between text-white h-full">
                <div class="address flex-1 hidden sm:hidden md:block">
                    <span class="text-xs font-light">DELIVER TO : </span>
                    <span id="show-address-top-nav" class="text-xs font-light"></span>
                    <span class="ml-2 sm:ml-2 lg:ml-4">
                        <button id="btn-address-change" type="button" class="border py-1 px-2 sm:px-2 lg:px-3 rounded text-xxs font-light"
                            data-mc-on-previous-url="{{ url()->current() }}"
                            @auth data-bs-toggle="modal" data-bs-target="#address-modal" @endauth
                            @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                           Change
                       </button>
                    </span>
                </div>
                {{-- ======top links====== --}}
                <div class="top-links">
                    <div class="flex space-x-0 sm:space-x-0 lg:space-x-4">
                        <div class="social-icons flex">
                            <a href="#" class="p-2"><i class="text-sm sm:text-sm lg:text-base fa-brands fa-facebook"></i></a>
                            <a href="" class="p-2"><i class="text-sm sm:text-sm lg:text-base fa-brands fa-instagram"></i></a>
                            <a href="#" class="p-2"><i class="text-sm sm:text-sm lg:text-base fa-brands fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="border-b bg-white">
        <header class="page-header container hidden sm:hidden md:hidden lg:block xl:block">
            <div class="grid grid-cols-8 h-full gap-2">
                <div class="col-span-2">
                    <div class="logo-wrapper">
                        <a href="{{ route('home') }}">
                            <img class="logo lg:w-[160px] xl:w-[250px] h-[64px]" src="{{ $logo['imgSRC'] }}">
                        </a>
                    </div>
                </div>

                {{-- ======Search Box web ===== --}}
                <div class="col-span-4">
                    <div class="flex items-center h-full">
                        <div class="search-box group relative w-full flex-1">
                            <div class="flex bg-gray-50 rounded-md group-hover:rounded-b-none border border-gray-300">
                                <input type="text"
                                    class="search-box-input w-full text-base text-gray-600 bg-transparent border-0 focus:ring-0 focus:outline-none placeholder:text-gray-400 px-2 lg:px-2 xl:px-6 lg:py-2 xl:py-3"
                                    placeholder="Search for products.." autocomplete="off"/>
                                <button type="button"
                                    class="rounded-r-full px-6 flex items-center justify-items-end text-gray-400 group-hover:text-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                            <div class="hidden search-box-result absolute bg-white top-full left-0 right-0 p-4 shadow rounded-md group-hover:rounded-t-none">
                                <div class="search-box-result-list flex flex-col max-h-64 overflow-y-auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-2">
                    <div class="actions">
                        <a href="{{ route('my.wishlist') }}" class="flex items-center space-x-2"
                            data-mc-on-previous-url="{{ route('my.wishlist') }}"
                            @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                            <div class="item relative" title="Wishlist">
                                @php
                                    $wishlists = 0;
                                    if (Auth::user()) {
                                        $wishlists = count(Auth::user()->wishlist) ?? null;
                                    }
                                @endphp
                                @if ($wishlists > 0)
                                    <button class="block" type="button">
                                        <i class="text-primaryPositive-darkest fa-solid fa-heart"></i>
                                    </button>
                                @else
                                    <button class="block" type="button">
                                        <i class="icon text-primaryPositive-darkest fa-regular fa-heart"></i>
                                    </button>
                                @endif
                            </div>
                        </a>

                        <a href="{{ route('checkout') }}" class="flex items-center space-x-2" title="Cart"
                            data-mc-on-previous-url="{{ route('checkout') }}"
                            @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                            <div class="item relative">
                                <button class="block" type="button">
                                    <i class="icon fa-solid fa-cart-shopping text-primaryPositive-darkest"></i>
                                </button>
                                <div class="cart-dev hidden absolute top-0 lg:-top-2 xl:top-0 lg:-right-2 xl:right-0 -mt-1 bg-[#00798c] rounded-full w-6 h-6 text-center">
                                    <span class="cart-count flex items-center justify-center h-full text-white text-xs">0</span>
                                </div>
                            </div>
                        </a>
                        {{--==========user profile menu========--}}
                        @auth
                            <div class="group relative">
                                <a href="{{ route('my.dashboard') }}" class="user-profile group-hover:text-secondary bg-gray-50 h-12 flex items-center group-hover:rounded-b-none rounded-md shadow">
                                    <div class="flex items-center justify-center w-12 border-r">
                                        <i class="icon fa-solid fa-user"></i>
                                    </div>
                                    <div class="px-4">
                                        <span class="line-clamp-2 text-xs font-medium">
                                        <span class="font-normal">Hello</span><br>{{ Auth::user()->name }}
                                        </span>
                                    </div>
                                </a>
                                <div class="hidden absolute top-full left-0 z-20 group-hover:block">
                                    <div class="flex flex-col bg-gray-50 rounded-lg rounded-t-none w-40 shadow">
                                        @role('superadministrator|administrator')
                                            <a href="/admin/dashboard" class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                                <i class="mr-3 text-xs fa-solid fa-user"></i>Admin Panel
                                            </a>
                                        @endrole
                                        <a href="{{ route('my.dashboard') }}" class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-xs fa-solid fa-chart-line"></i>My Dashboard
                                        </a>
                                        <a href="{{ route('my.profile') }}" class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-xs fa-solid fa-user"></i>My Profile
                                        </a>
                                        <a href="{{ route('my.order') }}" class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-xs fa-solid fa-cart-shopping"></i>My Orders
                                        </a>
                                        <a href="#" class="relative border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-xs fa-solid fa-bell"></i>
                                            Notification
                                        </a>
                                        <a href="{{ route('my.password') }}" class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-xs fa-solid fa-lock"></i>Change Password
                                        </a>
                                        <a href="{{ route('logout') }}" class="text-xs px-3 py-2 hover:text-white hover:bg-secondary transition duration-150 ease-in-out rounded-b-lg">
                                            <i class="mr-3 text-xs fa-solid fa-arrow-right-from-bracket"></i>Logout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        @guest
                            <a href="" class="bg-gray-50 group-hover:text-secondary h-12 flex items-center rounded-md shadow"
                                data-mc-on-previous-url="{{ url()->current() }}"
                                @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                                <div class="flex items-center justify-center w-12 border-r">
                                    <i class="icon fa-regular fa-user"></i>
                                </div>
                                <div class="px-4">
                                    <span class="line-clamp-2 text-xs font-medium">
                                        Login or<br>Register
                                    </span>
                                </div>
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </header>
        {{-- ======Navigation bar for mobile=========== --}}
        {{-- =========Header Bar======== --}}
        <div class="container block sm:block md:block lg:hidden xl:hidden">
            <div class="relative header-bar flex space-x-4 items-center py-2">
                <div id="menu" onclick="toggleMenu()">
                    <button class="w-10 h-10 text-gray-500">
                        <i class="text-base fa-solid fa-bars"></i>
                    </button>
                </div>

                <div class="flex-1">
                    {{-- TODO: Make a logo component --}}
                    <a href="{{ route('home') }}">
                        <img class="logo h-[28px] md:h-[32px] mx-auto" src="/images/logos/logo.png">
                    </a>
                </div>
                {{-- =====Mobile user profile========= --}}
                @auth
                    <div class="item group relative">
                        <a id="user-menu" onclick="toogleOptionUser()" class="profile-btn item p-2" title="Profile">
                            @if (Auth::user()->avatar)
                                <img class="rounded" src="{{ Auth::user()->avatar }}" alt="Profile">
                            @else
                                <i class="text-secondary text-lg fa-solid fa-user"></i>
                            @endif
                        </a>
                        <div id="menu-profile" style="display: none" class="profile-list hidden absolute top-full -right-12 z-20 group-hover:block">
                            <div class="flex flex-col bg-gray-50 rounded-lg rounded-t-none w-40 shadow-xl">
                                <a href="{{ route('my.dashboard') }}" class="border-b px-3 py-2 text-sm hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                    <i class="mr-2 fa-solid fa-chart-line"></i>My Dashboard
                                </a>
                                <a href="{{ route('my.profile') }}" class="border-b px-3 py-2 text-sm hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                    <i class="mr-2 fa-solid fa-user"></i>My Profile
                                </a>
                                <a href="{{ route('my.order') }}" class="border-b px-3 py-2 text-sm hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                    <i class="mr-2 fa-solid fa-cart-shopping"></i>My Orders
                                </a>
                                <a href="{{ route('my.address.index') }}" class="border-b px-3 py-2 text-sm hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                    <i class="mr-2 fa-solid fa-location-dot"></i>My Address
                                </a>
                                <a href="#" class="relative border-b px-3 py-2 text-sm hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                    {{-- <div class="absolute rounded-full bg-red-500 w-4 h-4 flex items-center justify-center -mt-2 ml-1">
                                        <span class="text-white text-xxs">0</span>
                                    </div> --}}
                                    <i class="mr-2 fa-solid fa-bell"></i>
                                    Notification
                                </a>
                                <a href="{{ route('my.password') }}" class="border-b px-3 py-2 text-sm hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                    <i class="mr-2 fa-solid fa-lock"></i>Change Password
                                </a>
                                <a href="{{ route('logout') }}" class="text-sm px-3 py-2 hover:text-white hover:bg-secondary transition duration-150 ease-in-out rounded-b-lg">
                                    <i class="mr-2 fa-solid fa-arrow-right-from-bracket"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth
                @guest
                    <a href="" title="Login" class=""
                        data-mc-on-previous-url="{{ url()->current() }}"
                        @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                        <i class="text-lg text-secondary fa-solid fa-right-to-bracket"></i>
                    </a>
                @endguest
                <div class="pr-2">
                    <a href="{{ route('checkout') }}" class="flex items-center space-x-2"
                        data-mc-on-previous-url="{{ route('checkout') }}"
                        @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                        <div class="item relative">
                            <button class="block">
                                <i class="icon text-lg text-secondary fa-solid fa-cart-shopping"></i>
                            </button>
                            <div class="cart-dev absolute -top-3 -right-3 bg-primary rounded-full w-5 h-5 text-center flex items-center justify-center">
                                <span class="cart-count text-white text-xxs">0</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            {{-- ====search field & categories for mobile menu=====--}}
            <div class="flex space-x-2">
                <div class="relative">
                    <div class="">
                        <button type="button" id="category-menu" onclick="toogleOptionCategory()" class="category-btn px-3 h-8 text-sm border border-primary/50 rounded text-gray-500">
                            Select categories<i class="ml-1 text-xs fa-solid fa-angle-down"></i>
                        </button>
                    </div>
                    <div class="absolute">
                        <div class="">
                            <div id="menu-item" style="display: none" class="category-list mobile-nav w-64">
                                <a class="mobile-nav-item" href="{{ route('products.index') }}">
                                    <img class="img-wrapper" src="{{ asset('images/icons/watch_icon.png') }}"> All Products
                                </a>
                                {{-- <a class="mobile-nav-item" href="{{ route('tag.page', ['men-care']) }}">
                                    <img class="img-wrapper" src="{{ asset('images/icons/mencare.png') }}"> Men Care
                                </a>
                                <a class="mobile-nav-item" href="{{ route('tag.page', ['women-care']) }}">
                                    <img class="img-wrapper" src="{{ asset('images/icons/women-care.png') }}"> Women Care
                                </a>
                                <a class="mobile-nav-item" href="{{ route('tag.page', ['sexual-wellness']) }} ">
                                    <img class="img-wrapper" src="{{ asset('images/icons/sexual.png') }}"> Sexual Wellness
                                </a>
                                <a class="mobile-nav-item" href="{{ route('tag.page', ['herbal-homeopathy']) }}">
                                    <img class="img-wrapper" src="{{ asset('images/icons/herbal.png') }}"> Herbal & Homeopathy
                                </a>
                                <a class="mobile-nav-item" href="{{ route('tag.page', ['baby-mom-care']) }}">
                                    <img class="img-wrapper" src="{{ asset('images/icons/babymom.png') }}"> Baby & Mom Care
                                </a>
                                <a class="mobile-nav-item" href="{{ route('tag.page', ['personal-care']) }}">
                                    <img class="img-wrapper" src="{{ asset('images/icons/personal-care.png') }}"> Personal Care
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Search bar for mobile --}}
                <div id="search-bar" class="search-box flex-1">
                    <div class="flex rounded rounded-t-none top-0 mb-2 h-8">
                        <button class="px-2.5 flex items-center rounded-l border border-primary/50 border-r-0">
                            <i class="text-xs text-gray-500 fa-solid fa-magnifying-glass"></i>
                        </button>
                        <input class="search-box-input text-xs placeholder:text-sm border-primary/50 border border-l-0 py-1 w-full rounded rounded-l-none focus:outline-none"
                        placeholder="Search here.">
                    </div>

                    <div class="hidden search-box-result absolute bg-white top-full left-0 right-0 p-4 shadow rounded-md">
                        <div class="search-box-result-list flex flex-col max-h-64 overflow-y-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ==========New post header======================= --}}
    <div class="hidden sm:hidden md:hidden lg:block">
        <div class="post-header container h-14">
            <div class="flex space-x-6 items-center h-full">
                <div class="relative group">
                    <button class="category-btn group-hover:rounded-b-none lg:w-[160px] xl:w-[240px] flex items-center text-primary justify-between sm:text-sm text-sm lg:text-base border rounded-md px-4 py-2">
                        <div class="flex space-x-2">
                            <span><i class="fa-solid fa-bars"></i></span>
                            <span>Category</span>
                        </div>
                        <span class=""><i class="fa-solid fa-caret-down"></i></span>
                    </button>
                    <ul class="group-hover:block dropdown-menu min-w-max w-[160px] xl:w-[240px] absolute bg-white text-base z-50 float-left list-none text-left rounded-md rounded-t-none shadow-lg hidden m-0 bg-clip-padding border-none" aria-labelledby="dropdownMenuButton1">
                        <li class="border-b">
                            <a class=" dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                href="{{ route('products.index') }}">
                                <img class="inline-block mr-2 w-5 h-5 border shadow-sm rounded-full" src="{{ asset('images/icons/watch_icon.png') }}">All Products
                            </a>
                        </li>
                        {{-- <li class="border-b">
                            <a class=" dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                href="{{ route('tag.page', ['men-care']) }}">
                                <img class="inline-block mr-2 w-5 h-5 border shadow-sm rounded-full" src="{{ asset('images/icons/mencare.png') }}">Men Care
                            </a>
                        </li>
                        <li class="border-b">
                            <a class=" dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                href="{{ route('tag.page', ['women-care']) }}">
                                <img class="inline-block mr-2 w-5 h-5 border shadow-sm rounded-full" src="{{ asset('images/icons/women-care.png') }}">Women Care
                            </a>
                        </li>
                        <li class="border-b">
                            <a class=" dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                href="{{ route('tag.page', ['sexual-wellness']) }}">
                                <img class="inline-block mr-2 w-5 h-5 border shadow-sm rounded-full" src="{{ asset('images/icons/sexual.png') }}">Sexual Wellness
                            </a>
                        </li>
                        <li class="border-b">
                            <a class=" dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                href="{{ route('tag.page', ['herbal-homeopathy']) }}">
                                <img class="inline-block mr-2 w-5 h-5 border shadow-sm rounded-full" src="{{ asset('images/icons/herbal.png') }}">Herbal & Homeopathy
                            </a>
                        </li>
                        <li class="border-b">
                            <a class=" dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                href="{{ route('tag.page', ['baby-mom-care']) }}">
                                <img class="inline-block mr-2 w-5 h-5 border shadow-sm rounded-full" src="{{ asset('images/icons/babymom.png') }}">Baby & Mom Care
                            </a>
                        </li>
                        <li class="">
                            <a class=" dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                href="{{ route('tag.page', ['personal-care']) }}">
                                <img class="inline-block mr-2 w-5 h-5 border shadow-sm rounded-full" src="{{ asset('images/icons/personal-care.png') }}">Personal Care
                            </a>
                        </li> --}}
                    </ul>
                </div>
                <div class="flex-1">
                    <ul class="flex text-sm md:text-sm lg:text-base text-primary font-normal tracking-wide">
                        @foreach ($menus as $m)
                            <a href="{{ $m['route'] }}" class="p-2 lg:p-2 xl:p-4">{{ $m['label'] }}</a>
                        @endforeach
                    </ul>
                </div>
                {{-- <div class="flex justify-end">
                    <div class="flex justify-end space-x-4 items-center">
                        <span class="text-sm sm:text-sm lg:text-base text-primary">Download App</span>
                        <div class="download-app flex items-center space-x-3 text-primary">
                            <a href="https://apps.apple.com/us/app/apple-store/id6443554194/" target="_blank" class="icon-wrapper text-2xl xl:text-3xl"><i class="icon fa-brands fa-apple"></i></a>
                            <a href="https://play.google.com/store/apps/details?id=com.pulsetechltd.medicart" target="_blank" class="icon-wrapper text-xl xl:text-2xl"><i class="icon fa-brands fa-google-play"></i></a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

{{-- =========mobile drawer menu=========--}}
<section class="">
    <div id="menu-box" class="sidebar-menu fixed top-0 left-0 bottom-0 right-0 z-50 bg-black/30"
        style="display: none">
        <div class="w-60 h-full bg-white">
            <div class="header h-14 flex space-x-4 items-center bg-gray-300 shadow">
                <a href="{{ route('home') }}" class="flex-1">
                    <img class="w-[8.375rem] pl-4" src="/images/logos/logo.png">
                </a>
                <div class=""id="menu" onclick="toggleMenu()">
                    <button class="rounded px-4 py-2"><i class="text-lg fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="menu">
                <div class="flex flex-col">
                    <a href="{{ route('my.wishlist') }}"
                        class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out"
                        data-mc-on-previous-url="{{ route('my.wishlist') }}"
                        @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                        <i class="pr-3 fa-solid fa-heart"></i>
                        Wishcart
                    </a>
                    <a href="{{ route('my.address.index') }}" class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out"
                        data-mc-on-previous-url="{{ route('my.address.index') }}"
                        @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                        <i class="pr-3 fa-solid fa-location-dot"></i>
                        Add New Address
                    </a>
                    <a href="{{ route('products.index') }}" class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out">
                        <i class="pr-3 fa-solid fa-capsules"></i>
                        Medicine
                    </a>
                    {{-- <a href="{{ route('tag.page', 'personal-care') }}" class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out">
                        <i class="pr-3 fa-solid fa-hand-holding-medical"></i></i>
                        Personal Care
                    </a> --}}
                    <a href="{{ route('category.page', ['medical-devices']) }}" class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out">
                        <i class="pr-3 fa-solid fa-laptop-medical"></i>
                        Medical Devices
                    </a>
                    <a href="{{ route('offers.products') }}" class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out">
                        <i class="pr-3 fa-solid fa-percent"></i>
                        Offers
                    </a>
                    {{-- <a href="#" class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out">
                        <i class="pr-3 fa-solid fa-kit-medical"></i>
                        instaMed
                    </a> --}}
                    @auth
                        <a href="{{ route('logout') }}" class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out">
                            <i class="pr-3 fa-solid fa-arrow-right-from-bracket"></i>
                            Logout
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out"
                        data-mc-on-previous-url="{{ url()->current() }}"
                        @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                            <i class="pr-3 fa-solid fa-right-to-bracket"></i>
                            Login/Register
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
{{-- ========Cart Drawer=========== --}}
{{-- <div class="fixed inset-y-0 right-0 z-40 content-center hidden sm:hidden md:flex lg:flex xl:flex 2xl:flex">
    <button id="btn-cart-drawer" class="rounded-l-md rounded-tl-md group group:transition-all group:duration-300 group:ease-in-out w-16 h-20 mt-auto mb-auto shadow-lg hover:shadow-xl
        flex flex-col" type="button" data-bs-toggle="offcanvas" data-bs-target="#drawerCart" aria-controls="drawerCart">
        <div class="rounded-tl-md flex-1 flex flex-col items-center justify-center w-full space-y-2 bg-secondary-light group-hover:bg-secondary group-hover:transition-all group-hover:duration-300 group-hover:ease-in-out">
            <i class="icon fa-solid fa- cart-shopping"></i>
            <span class="text-xxs"><span class="cart-count">0</span> ITEMS</span>
        </div>
        <span class="bg-white rounded-bl-md group-hover:bg-primary-lightest group-hover:transition-all group-hover:duration-300 group-hover:ease-in-out w-full h-6 text-sm flex items-center justify-center">
            <span class="text-xxs flex flex-wrap items-center justify-center">Tk
                <span class="ml-1" id="drawer-cart-item-price-label">0</span>
            </span>
        </span>
    </button>
</div> --}}

{{-- <div style="z-index: 99999" class="offcanvas offcanvas-end fixed bottom-0 flex flex-col max-w-full bg-white invisible bg-clip-padding shadow-sm outline-none transition duration-300 ease-in-out text-gray-700 top-0 right-0 border-none w-[400px]"
    tabindex="-1" id="drawerCart" aria-labelledby="drawerCartLabel">
    <div class="offcanvas-header flex items-center justify-between bg-secondary px-4 py-2">
        <span class="font-medium">
            <i class="mr-2 fa-solid fa-basket-shopping"></i>
            <span class="cart-count">0</span> Items
        </span>
        <button type="button" class="btn-close box-content w-4 h-4 p-2 -my-5 -mr-2 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex flex-col flex-grow px-4 overflow-y-auto">
        <div class="list border-t flex-1 overflow-y-auto">
        </div>
    </div>
    <div class="p-4">
        <a href="{{ route('checkout') }}" class="flex items-center justify-center">
            <button class="flex-1 bg-secondary-light py-2.5 rounded-l">
                <span class="text-base text-primary hover:text-primary font-medium">Place Order</span>
            </button>
            <button class="bg-secondary px-10 py-2.5 rounded-r">
                <span class="mr-2 text-base text-primary hover:text-primary font-medium">Tk</span>
                <span id="s-total-price-label" class="text-base text-primary hover:text-primary font-medium"></span>
            </button>
        </a>
    </div>
</div> --}}

{{-- ========Login modal=========== --}}
@php
    $currentRouteName = Request::route() ? Request::route()->getName() : '';
@endphp
@if($currentRouteName != 'login')
    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto z-50"
        id="loginModalCenter" tabindex="-1" aria-labelledby="loginModalCenterTitle" aria-modal="true" role="dialog"
        style="background-color: rgba(0,0,0,0.7);">
        <div class="modal-dialog modal-lg modal-dialog-centered relative w-full pointer-events-none">
            <div class="w-3/4 mx-auto modal-contentx border-none shadow-lg relative flex flex-col
                pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-lg font-medium leading-normal text-gray-800" id="loginModalScrollableLabel">
                        Login/Signup
                    </h5>
                    <button type="button"
                        class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body relative py-4">
                    <x-frontend.auth-login/>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- New Address modal --}}
<div id="address-modal" class="modal z-50 fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    style="background-color: rgba(0,0,0,0.7);"
    tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable relative w-auto pointer-events-none">
    <div class="border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
      <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
        <h5 class="text-base md:text-lg font-medium leading-normal text-gray-800">
          Address
        </h5>
        <button type="button"
          class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
          data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body relative p-4">
        <div class="">
            {{-- For select shipping address --}}
            <form class="">
                <div class="form-item">
                    <label class="form-label font-medium">Select Shipping Address</label>
                    <div class="flex space-x-2 md:space-x-4">
                        <select class="header-shipping-address form-input w-full">
                            <option class="text-xs md:text-sm" value="">Select address</option>
                            @foreach ($userAddress as $address)
                                <option value="{{ $address->id }}" {{ $cart->shipping_address_id == $address->id ? "selected" : '' }}>
                                    {{ $address->title }}
                                </option>
                            @endforeach
                        </select>
                        <button id="btn-header-shepping-address-update" type="button" class="btn btn-primary btn-sm md:btn-md">
                            Update
                        </button>
                    </div>
                    <div id="header-address-show-dev" class="mt-1 hidden items-center">
                        <i class="mr-1 text-sm fa-solid fa-location-dot"></i>
                        <span id="show-address-label" class="text-sm text-primary font-medium"></span>
                    </div>
                </div>
            </form>
            {{-- For create shipping address --}}
            <h3 class="mt-2 md:mt-2 mb-2 text-base font-medium">Add new shipping address</h3>
            <form class="mb-0">
                <div class="grid grid-cols-1">
                    <div class="form-item">
                        <label for="" class="form-label">Address Title<span class="ml-1 text-red-500 font-medium">*</span></label>
                        <select id="address-title" class="form-select form-input w-full">
                            <option value="">Select</option>
                            <option value="Home">Home</option>
                            <option value="Office">Office</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div id="others-title-div" class="form-item">
                        <label for="">Your Address Title<span class="ml-1 text-red-500 font-medium">*</span></label>
                        <input id="header-others-title" class="form-input" type="text"
                            placeholder="Enter Your Address Title" />
                    </div>
                    <div class="form-item">
                        <label class="form-label">Alternative Phone Number</label>
                        <input id="contact-person-number" class="form-input" type="text"
                            placeholder="Enter Your Phone Number" />
                    </div>
                    <div class="form-item">
                        <label class="form-label">Address<span class="ml-1 text-red-500 font-medium">*</span></label>
                        <textarea id="address-line" class="form-input" rows="2" cols="50" placeholder="Enter your address here..."></textarea>
                    </div>
                    <div class="form-item">
                        <label class="form-label">Area<span class="ml-1 text-red-500 font-medium">*</span></label>
                        <select id="header-area-id" class="form-input">
                            <option value="" selected>Select</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">
                                    {{ $area->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-item">
                        <button id="addredd-create-btn" type="button" class="btn btn-primary">
                            Create
                            <i class="loadding-icon fa-solid fa-spinner fa-spin text-white"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
{{--./ New Address modal --}}

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Redirect current route when logn browser url
    var cccurl = '{{ url()->current() }}';
    if (cccurl.endsWith('login')) {
        cccurl = '{{ route('home') }}';
    }
    __savePreviousURL(cccurl);

    var categoryAllList = $('.category-list');
    var profileList     = $('.profile-list');

    //==========Mobile Navigation menu==========
        function toggleMenu() {
            var menuBox = document.getElementById('menu-box');
            if(menuBox.style.display == "none") {
                menuBox.style.display = "block";
            }
            else { // if is menuBox hidden, display it
                menuBox.style.display = "none";
            }
        }
    //==========./Mobile Navigation menu==========

    // =================dropdown category=====================
        // Select categories header menu
        function toogleOptionCategory() {
            var categoryList = document.getElementById('menu-item');
            if(categoryList.style.display == "none") {
                categoryList.style.display = "block";
            }
            else { // if is menuBox hidden, display it
                categoryList.style.display = "none";
            }
        }
        // If click outside of the categories button hide the list
        $(document).click(function(e) {
            var container = $('.category-btn');
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                categoryAllList.hide();
            }
        });
    // =================./dropdown category====================

    //==============Select user header menu===========
        function toogleOptionUser() {
            var categoryList = document.getElementById('menu-profile');
            if(categoryList.style.display == "none") {
                categoryList.style.display = "block";
            }
            else { // if is menuBox hidden, display it
                categoryList.style.display = "none";
            }
        }
        // If click outside of the profile then hide the list
        $(document).click(function(e) {
            var container = $('.profile-btn');
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                profileList.hide();
            }
        });
    //==============./Select user header menu===========
    // ==============hide on scroll===========
        $(function(){
            var lastScrollTop = 0, delta = 15;
            $(window).scroll(function(event) {
                var st = $(this).scrollTop();

                if(Math.abs(lastScrollTop - st) <= delta) {
                    return;
                }
                if ((st > lastScrollTop) && (lastScrollTop>0)) {
                    // downscroll code
                    $(".header-wrapper").addClass('small-header');

                } else {
                    // upscroll code
                    $(".header-wrapper").removeClass('small-header');
                }
                lastScrollTop = st;
            });
        });
    // ==============./hide on scroll===========
</script>

<script>
    var debounceTime     = 750;
    var setAlertTime     = {{ config('crud.alear_time') }};
    var cartCount        = $('.cart-count');
    var searchInput      = $('.search-box-input');
    var searchResult     = $('.search-box-result');
    var searchResultList = $('.search-box-result-list');
    // Header address change
    var shippingAddressEndPoint = '/cart/shipping/address/add';
    var addressModal         = $('#address-modal');
    var btnAddressChange     = $('#btn-address-change');
    var inputShippingAddress = $('.header-shipping-address');
    var showAddress          = $('#show-address-label');
    var btnHeaderSheppingAddressUpdate = $('#btn-header-shepping-address-update');
    //Default selected shipping address id
    var inputShippingId = inputShippingAddress.val();
    // address create
    var addressCreateBtn = $('#addredd-create-btn');
    var addressTitle     = $('#address-title');
    var addressLine      = $('#address-line');
    var contactNumber    = $('#contact-person-number');
    var headerAreaId     = $('#header-area-id');
    // hidden div for title othes
    var othersTitleDiv = $('#others-title-div').hide();

    // get geo location using latitude and longitude
    getLocation();

    @auth
        __cartItemCount();
        __getShippingAddress(inputShippingId, true);
    @endauth

    $(function() {
        // If click outside of the model search box hide the search result list
        $(document).click(function(e) {
            var container = $('.search-box');
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                searchResult.hide();
            }
        });

        searchInput.keyup(__debounce(function(e) {
            var key = e.which;
            var searchKeywords = $(this).val();

            if (searchKeywords.length >= 3) {
                productSearch(searchKeywords);
                searchResult.show();
            }
            if (searchKeywords.length < 3) {
                searchResult.hide();
            }
            // If press Enter key goto the product search page
            if (key == 13) // the enter key code
            {
                window.location.href = `/products?search_key=${searchKeywords}`;
            }
        }, debounceTime));

        // Header modal opration
        $('.modal .close-btn').click(function (e) {
            $("#address-modal").modal('hide')
        });


        // event with address change
        btnAddressChange.click(function () {
            @auth
                addressModal.show();
            @endauth
        });

        inputShippingAddress.on('change', function() {
            var addressId = $(this).val();
            __getShippingAddress(addressId);
        });

        // Shepping address update
        btnHeaderSheppingAddressUpdate.click(function() {
            var addressId = inputShippingAddress.val();
            __addShippingAddress(addressId);
            __getShippingAddress(addressId, true);
            $("#address-modal").modal('hide');
        });

        // create user address
        addressCreateBtn.click(function() {
            __addressCreate();
        });

        // Check address title is others
        addressTitle.change(function(){
            var title = $(this).val();
            if (title === 'Others') {
                othersTitleDiv.show();
            } else {
                othersTitleDiv.hide();
            }
        });
    });

    function productSearch(keywords) {
        axios.get('/api/product/search', {
            params: {
                search_query: keywords,
                search_limit: 10
            }
        })
        .then((response) => {
            var result = [];
            if (response.data.success) {
                result = response.data.result;
                renderSearchResult(result, keywords);
            }
        })
        .catch((error) => {
            console.log(error);
        });
    }

    function renderSearchResult(data, keywords) {
        searchResultList.html('');

        if (data.length > 0) {
            for (let index = 0; index < data.length; index++) {
                const product = data[index];
                var packSize     = product.pack_size;
                var sellingPrice = (product.selling_price * packSize).toFixed(2);
                var productMRP   = (product.mrp * packSize).toFixed(2);
                var isMRPHidden = '';
                var isSellingPriceHidden = 'hidden';
                if (sellingPrice > 0) {
                    isMRPHidden = 'line-through';
                    isSellingPriceHidden = '';
                }
                var itemHTML = `
                    <a href="/products/${product.id}/${product.slug}" class="hover:bg-gray-200 transition duration-150 ease-in-out border-b border-dashed flex space-x-2 py-2 pr-3 items-center" data-product-id="${product.id}">
                        <div class="w-14 h-14">
                            <img class="w-full h-full" src="${product.image_src}" alt="">
                        </div>
                        <div class="flex-1 flex flex-col">
                            <h4 class="text-xs text-gray-500">${product.dosage_form?.name}</h4>
                            <h2 class="text-base text-primary">${product.name}</h2>
                            <span class="text-xxs text-gray-500">${product.generic?.name}</span>
                        </div>
                        <div class="flex justify-center items-center text-sm ${isMRPHidden}">
                            <span class="text-gray-500">${productMRP} tk</span>
                        </div>
                        <div class="flex justify-center items-center text-sm ${isSellingPriceHidden}">
                            <span class="text-gray-500">${sellingPrice} tk</span>
                        </div>
                    </a>`;

                searchResultList.append(itemHTML);
            }
        } else {
            searchResultList.html(`<strong>No product found by "${keywords}"</strong>`);
        }

        searchResult.show();
    }

    function __addShippingAddress(addressId) {
        axios.post(shippingAddressEndPoint, {
            shipping_address_id: addressId
        })
        .then((response) => {
            // __showNotification('success', response.data.message, setAlertTime);
        })
        .catch((error) => {
            console.log(error);
            __showNotification('error', 'Something went to wrong', setAlertTime);
        })
        .then(() => {});
    }

    function __getShippingAddress(addressId, isUpdate = false) {
        axios.get('/my/shipping/addrss', {
            params: {
                address_id: addressId
            }
        })
        .then((response) => {
            let id      = response.data.result ? response.data.result.id : '';
            let title   = response.data.result ? response.data.result.title : '';
            let address = response.data.result ? response.data.result.address : '';
            // change shipping address id
            $('.shipping-address-id').val(id);
            // show address title
            if (isUpdate) {
                $('.shipping-address-label').text(title);
            }
            // show address in top nav
            if (isUpdate) {
                $('#show-address-top-nav').text(address);
            }
            // show address in address modal
            if (address) {
                $('#header-address-show-dev').show();
                showAddress.text(address);
            } else {
                $('#header-address-show-dev').hide();
            }
        })
        .catch((error) => {
            console.log(error);
        });
    }

    function __addressCreate() {
        var bodyFormData = new FormData();

        var title   = addressTitle.val();
        var address = addressLine.val();
        var phone   = contactNumber.val();
        var area    = headerAreaId.val();
        if (!title) {
            __showNotification('error', 'Please select address title', setAlertTime);
            return false;
        }
        if (!address) {
            __showNotification('error', 'Please enter address', setAlertTime);
            return false;
        }
        if (!area) {
            __showNotification('error', 'Please select area', setAlertTime);
            return false;
        }

        if (title && title === 'Others') {
            var headerOthersTitle = $('#header-others-title').val();
            if (!headerOthersTitle) {
                __showNotification('error', 'Please enter your address title', setAlertTime);
                return false;
            }
        }

        title = headerOthersTitle ? headerOthersTitle : title;

        bodyFormData.append('title', title);
        bodyFormData.append('address', address);
        bodyFormData.append('phone_number', phone);
        bodyFormData.append('area_id', area);
        axios({
            method: "post",
            url: "/my/address",
            data: bodyFormData
        })
        .then(function (response) {
            if (response.data.error) {
                __showNotification('error', response.data.message, setAlertTime);
                return false;
            } else {
                iconLoadding.show();
                location.reload(true);
            }
        })
        .catch(function (error) {
            console.log(error);
        });
    }

    // Get latitude and longitude
    function getLocation() {
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Sorry, your browser does not support HTML5 geolocation.");
        }
    }

    function showPosition(position) {
        var apiKey = `{{ config('app.google_map_api_key') }}`;
        var lat    = position.coords.latitude;
        var longi  = position.coords.longitude;
        if (lat && longi) {
            $.get({
                url: `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${longi}&sensor=false&key=${apiKey}`,
                success(data) {
                    var address = null;
                    var areaName = null;
                    if (data.results[0]) {
                        areaName    = data.results[0].address_components[1] ? data.results[0].address_components[1].long_name : '';
                        address     = data.results[0].formatted_address ? data.results[0].formatted_address : '';
                    }
                    if (address) {
                        addressLine.text(address);
                    }
                    if (areaName) {
                        const appBaseURL = '{{ config("app.url") }}';
                        const endpoint = `${appBaseURL}/area/${areaName}`;
                        axios.get(endpoint)
                        .then(res => {
                            if (res) {
                                if (res.data.result) {
                                    headerAreaId.val(res.data.result.id).change();
                                }
                            }
                        })
                        .catch(err => {
                            console.log(err);
                        });
                    }
                }
            });
        }
    }
</script>

{{-- Cart drower scripts --}}
<script>
    var cartAddItemEndPoint = '/cart/item/add';
    var deleteBtnForDrawer  = $('.delete-cart-item-btn-for-drawer');
    var totalPriceLabel     = $('#s-total-price-label');
    var btnCartDrawer       = $('#btn-cart-drawer');
    var list                = $('.list');
    var userID              = {{ Auth::id() }}
    $('.list .item-row .loadding-icon').hide();

    // Initial calculate total price
    __totalPriceCalculation();

    // if user is login then show drawer cart item
    if (userID) {
        drawerCartItemRender();
    }

    $(function() {
        // Change quantity
        $('.list').on('change', '.input-item-qty', function() {
            var itemID = $(this).data('item-id');
            var qty    = $(this).val();
            qty = +qty;

            h_addCartItem(itemID, qty);

            var unitPrice        = $(this).data('unit-price');
            var itemPackSize     = $(this).data('item-pack-size');
            var totalItemLabelID = $(this).data('total-item-price-label');
            var itemTotalPrice   = unitPrice * qty;
            itemTotalPrice       = itemTotalPrice.toFixed(2);
            $(`#${totalItemLabelID}`).text(itemTotalPrice);
        });

        // Delete item
        $('.list').on('click', '.delete-cart-item-btn-for-drawer', function() {
            var itemID = $(this).data('item-id');
            __removeCartItemFromDrawer(itemID, $(this));

        });

        // get cart items
        btnCartDrawer.click(function() {
            if (userID) {
                axios.get('/drawer/cart')
                .then(res => {
                    var data = res.data.result;
                    if (data) {
                        cartItemRender(data);
                        __totalPriceCalculation();
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            }
        });
    });

    function __removeCartItemFromDrawer(itemID, btn) {
        var loaderIcon = btn.find('.loadding-icon');
        var trashIcon = btn.find('.trash-icon');

        trashIcon.hide();
        loaderIcon.show();

        axios.post('/cart/item/remove', {
                item_id: itemID
            })
            .then(function (response) {
                btn.parent().parent().parent().remove();
                __cartItemCount();
                __totalPriceCalculation();
            })
            .catch(function (error) {
                console.log(error);
                trashIcon.show();
                loaderIcon.hide();
            });
    }

    // Add cart item
    function h_addCartItem(productID, productQty) {
        axios.post(cartAddItemEndPoint, {
            item_id: productID,
            item_quantity: productQty
        })
        .then((response) => {
            __totalPriceCalculation();
        })
        .catch((error) => {
            console.log(error);
        });
    }

    function drawerCartItemRender() {
        axios.get('/drawer/cart')
        .then(res => {
            var data = res.data.result;
            cartItemRender(data);
            __totalPriceCalculation();
        })
        .catch(error => {
            console.log(error);
        });
    }

    // Cart item render
    function cartItemRender(data) {
        list.html('');
        for (let index = 0 ; index < data.length; index++) {
            const product = data[index];

            var qtyHTML = '';
            var productNuberOfPack = product.num_of_pack;
            var packSize = product.pack_size;
            var uom = product.uom;
            if (!uom) {
                uom = ''
            }

            for(i = 1; i<= productNuberOfPack; i++) {
                var isSelected = i*packSize == product.pivot.quantity ? 'selected' : '';
                qtyHTML = `${qtyHTML}<option value="${i*packSize}" ${isSelected}>${i*packSize} ${uom}</option>`;
            }

            var itemHTML = `
                <div class="item-row flex space-x-2 border-b py-2">
                    <img class="w-20 h-20" src="${product.image_src}" alt="${product.name}">
                    <div class="flex-1 flex flex-col">
                        <div class="flex justify-between">
                            <a href="/products/${product.id}/${product.slug}" class="text-sm font-medium">${product.name}</a>
                            <div class="delete-cart-item-btn-for-drawer" data-item-id="${product.id}">
                                <button class="flex items-center justify-center w-8 h-8 rounded bg-red-500 hover:bg-red-700 text-white"">
                                    <i class="trash-icon text-sm text-white fa-regular fa-trash-can"></i>
                                    <i class="loadding-icon fa-solid fa-spinner fa-spin mr-2" style="display: none;"></i>
                                </button>
                            </div>

                        </div>
                        <div class="text-sm flex-1">
                            Price:
                            <span>Tk</span>
                            <span class="ml-1">${(product.pivot.price) ?? 0}</span>
                        </div>
                        <div class="flex justify-between flex-1">
                            <div>
                                <select class="input-item-qty text-xs rounded"
                                    data-item-id="${product.id}"
                                    data-unit-price="${product.pivot.price}"
                                    data-item-pack-size="${product.pack_size}"
                                    data-total-item-price-label="cd-total-price-${product.pivot.item_id}">
                                ${qtyHTML}
                                </select>
                                <span class="text-xs">
                                    x ${product.uom}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium">
                                    Tk
                                    <span id="cd-total-price-${product.pivot.item_id}" class="s-totalprice ml-1">
                                        <span id="price-show-${product.pivot.item_pack_id}">
                                            ${(product.pivot.item_price * product.pivot.quantity).toFixed(2)}
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `
            list.append(itemHTML);
        }
    }

    // Calculate total price
    function __totalPriceCalculation() {
        var total = 0;
        $(".s-totalprice").each(function() {
            total += parseFloat($(this).text());
        });
        total = total.toFixed(2);
        total = +total;
        var format = total.toLocaleString();
        totalPriceLabel.text(format);
        jQuery({ counter: 0 }).animate({ counter: total }, {
            duration: 1000,
            easing: 'swing',
            step: function () {
                $('#drawer-cart-item-price-label').text(Math.ceil(this.counter));
            }
        });
    }
</script>

{{-- Product thumb scripts --}}
<script>
    @auth
        var storageProductID = localStorage.getItem('product_id');
        if (storageProductID) {
            __addCartItemToCart(storageProductID, 1, null);
            localStorage.removeItem('product_id');
        }
    @endauth
    @guest
        var userID = null;
    @endguest

    var packQty             = 0;
    var cartAddItemEndPoint = '/cart/item/add';
    var selectedPack        = $('.selected-pack');
    var iconLoadding        = $('.loadding-icon');
    var iconAddToCart       = $('.add-to-cart-icon');

    iconAddToCart.show()
    iconLoadding.hide();

    $(function() {
        selectedPack.on('change', function() {
            packQty = $(this).val();
            var headerProductId = $(this).data('header-product-id');
            var headerProductMRP = $(this).data('header-product-mrp');
            var headerProductSellingPrice = parseFloat($(this).data('header-product-selling-price'));
            var headerProductPrice = headerProductSellingPrice > 0 ? headerProductSellingPrice : headerProductMRP;
            headerProductPrice = headerProductPrice * packQty;
            headerProductMRP = headerProductMRP * packQty;

            __checkProductOfferQty(headerProductId, packQty, headerProductMRP, headerProductSellingPrice);

            $(`.product-grid #header-product-price-label-${headerProductId}`).text(headerProductPrice.toFixed(2));
            if (headerProductSellingPrice) {
                $(`.product-grid #header-product-mrp-label-${headerProductId}`).text('Tk '+ headerProductMRP);
            }
        });

        // Add product to cart
        $('.product-grid').on('click', '.btn-add-to-cart', function () {
            var qtySelect = $(this).parent().parent().children().children('select');
            packQty = qtySelect.val();
            if (!userID) {
                var productID = $(this).data('product-id');
                localStorage.setItem('product_id', productID);
            } else {
                // Get product id from the hidden input
                var productID = $(this).data('product-id');
                if (packQty == 0) {
                    __showNotification('error', 'Please select quantity', setAlertTime);
                    return false;
                }
                if (productID != 0 && packQty != 0) {
                    __addCartItemToCart(productID, packQty, $(this));
                }
            }
        });
    });

    function __addCartItemToCart(productID, productQty, btn) {
        if (btn) {
            btn.prop("disabled", true);
            btn.find('.loadding-icon').show();
            btn.find('.add-to-cart-icon').hide();
        }

        axios.post(cartAddItemEndPoint, {
            item_id: productID,
            item_quantity: productQty
        })
        .then((response) => {
            if (response.data.res) {
                __cartItemCount();
                drawerCartItemRender();
            } else {
                __showNotification('error', response.data.message, setAlertTime);
                return false;
            }
            if (btn) {
                btn.prop("disabled", false);
                btn.find('.loadding-icon').hide();
                btn.find('.add-to-cart-icon').show();
            }
        })
        .catch((error) => {
            if (btn) {
                btn.prop("disabled", false);
                btn.find('.loadding-icon').hide();
                btn.find('.add-to-cart-icon').show();
            }
            __showNotification('error', response.data.message, setAlertTime);
            return false;
        });
    }

    // Check offer product quantity
    function __checkProductOfferQty(selectedProductId, selectedProductQty, productMRP = 0, productPrice = 0) {
        var checkOfferQtyEndpoint = '/api/check/offer/quantity';
        axios.get(checkOfferQtyEndpoint, {
                params: {
                    'product_id': selectedProductId,
                    'quantity': selectedProductQty
                }
            })
            .then(res => {
                if (res.data.success) {
                    var productOfferAmount = parseFloat(res.data.result);
                    productOfferAmount = (productOfferAmount * selectedProductQty).toFixed(2);
                    $(`.product-grid #header-product-price-label-${selectedProductId}`).text(productOfferAmount);
                    $(`.product-grid #header-product-mrp-label-${selectedProductId}`).text('Tk '+ productMRP);
                } else {
                    if (!productPrice) {
                        $(`.product-grid #header-product-mrp-label-${selectedProductId}`).text('');
                    }
                }
            })
            .catch(err => {
                console.log(err);
            });
    }
</script>
@endpush
