<div class="header-wrapper">
    {{-- ============Top header==================== --}}
    <div class="top-header-bar">
        <div class="bg-[#ffc42d] h-8 sm:h-8 md:h-10">
            <div class="container flex flex-row space-x-4 items-center justify-between sm:justify-between text-black h-full">
                <div class="address flex-1 hidden sm:hidden md:block">
                    <span class="text-xs font-normal">DELIVER TO : </span>
                    <span id="show-address-top-nav" class="text-xs font-normal"></span>
                    <span class="ml-2 sm:ml-2 lg:ml-4">
                        <button id="btn-address-change" type="button" class="border border-black py-1 px-2 sm:px-2 lg:px-3 rounded text-xxs font-normal hover:text-white"
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
                            <a href="#" class="p-2"><i class="text-sm sm:text-sm lg:text-base hover:text-white fa-brands fa-facebook"></i></a>
                            <a href="" class="p-2"><i class="text-sm sm:text-sm lg:text-base hover:text-white fa-brands fa-instagram"></i></a>
                            <a href="#" class="p-2"><i class="text-sm sm:text-sm lg:text-base hover:text-white fa-brands fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="border-b bg-[#00798c]">
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
                                        <i class="icon text-primary fa-solid fa-heart"></i>
                                    </button>
                                @else
                                    <button class="block" type="button">
                                        <i class="icon text-primary fa-regular fa-heart"></i>
                                    </button>
                                @endif
                            </div>
                        </a>

                        <a href="{{ route('checkout') }}" class="flex items-center space-x-2" title="Cart"
                            data-mc-on-previous-url="{{ route('checkout') }}"
                            @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                            <div class="item relative">
                                <button class="block" type="button">
                                    <i class="icon fa-solid fa-cart-shopping text-primary"></i>
                                </button>
                                <div class="cart-dev hidden absolute top-0 lg:-top-2 xl:top-0 lg:-right-2 xl:right-0 -mt-1 bg-[#ffc42d] rounded-full w-6 h-6 text-center">
                                    <span class="cart-count flex items-center justify-center h-full text-black text-xs font-medium">0</span>
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
                                        @role('superadministrator')
                                            <a href="/admin/dashboard" class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                                <i class="mr-3 text-xs fa-solid fa-user"></i>Admin Panel
                                            </a>
                                        @endrole
                                        <a href="{{ route('my.dashboard') }}" class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-xs fa-solid fa-gauge"></i>My Dashboard
                                        </a>
                                        <a href="{{ route('my.profile') }}" class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-xs fa-solid fa-user"></i>My Profile
                                        </a>
                                        <a href="{{ route('my.order') }}" class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-xs fa-solid fa-cart-shopping"></i>My Orders
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
                            <div class="cart-dev absolute -top-3 -right-3 bg-secondary rounded-full w-5 h-5 text-center flex items-center justify-center">
                                <span class="cart-count text-black font-normal text-xxs">0</span>
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
                        Products
                    </a>
                    {{-- <a href="{{ route('offers.products') }}" class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out">
                        <i class="pr-3 fa-solid fa-percent"></i>
                        Offers
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
                                <option value="{{ $address->id }}" {{ $cart->address_id == $address->id ? "selected" : '' }}>
                                    {{ $address->title }}
                                </option>
                            @endforeach
                        </select>
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
    //Default selected shipping address id
    var inputShippingId = inputShippingAddress.val();
    // address create
    var addressCreateBtn = $('#addredd-create-btn');
    var addressTitle     = $('#address-title');
    var addressLine      = $('#address-line');
    var contactNumber    = $('#contact-person-number');
    var headerAreaId     = $('#header-area-id');
    var loaddingIcon     = $('.loadding-icon').hide();

    @auth
        __cartItemCount();
        __getShippingAddress(inputShippingId);
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
            __addShippingAddress(addressId);
            __getShippingAddress(addressId);
        });

        // create user address
        addressCreateBtn.click(function() {
            __addressCreate();
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
            address_id: addressId
        })
        .then((response) => {
        })
        .catch((error) => {
            console.log(error);
        });
    }

    function __getShippingAddress(addressId) {
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
            // show address title in cart page
            $('.shipping-address-label').text(title);
            // show address in top nav
            $('#show-address-top-nav').text(address);
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
            addressTitle.focus();
            return false;
        }
        if (!address) {
            __showNotification('error', 'Please enter address', setAlertTime);
            addressLine.focus();
            return false;
        }
        if (!area) {
            __showNotification('error', 'Please select area', setAlertTime);
            headerAreaId.focus();
            return false;
        }


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
                loaddingIcon.show();
                location.reload(true);
            }
        })
        .catch(function (error) {
            console.log(error);
        });
    }
</script>
@endpush
