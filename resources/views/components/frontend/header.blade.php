<div class="header-wrapper">
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
                                    placeholder="Search for products.." autocomplete="off" />
                                <button type="button"
                                    class="rounded-r-full px-6 flex items-center justify-items-end text-gray-400 group-hover:text-primary">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                            <div
                                class="hidden search-box-result absolute bg-white top-full left-0 right-0 p-4 shadow rounded-md group-hover:rounded-t-none">
                                <div class="search-box-result-list flex flex-col max-h-64 overflow-y-auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-2">
                    <div class="actions">
                        <a href="{{ route('my.wishlist') }}" class="flex items-center space-x-2"
                            data-mc-on-previous-url="{{ route('my.wishlist') }}">
                            <div class="item relative" title="Wishlist">
                                <button class="block" type="button">
                                    <i class="icon text-primary fa-solid fa-heart hover:text-secondary"></i>
                                </button>
                            </div>
                        </a>

                        <a href="{{ route('cart.items') }}" class="flex items-center space-x-2" title="Cart"
                            data-mc-on-previous-url="{{ route('cart.items') }}">
                            <div class="item relative">
                                <button class="block" type="button">
                                    <i class="icon fa-solid fa-cart-shopping text-primary hover:text-secondary"></i>
                                </button>
                                <div
                                    class="cart-dev hidden absolute top-0 lg:-top-2 xl:top-0 lg:-right-2 xl:right-0 -mt-1 bg-[#ffc42d] rounded-full w-6 h-6 text-center">
                                    <span
                                        class="cart-count flex items-center justify-center h-full text-black text-xs font-medium">0</span>
                                </div>
                            </div>
                        </a>
                        {{-- ==========user profile menu======== --}}
                        @auth
                            <div class="group relative">
                                <a href="{{ route('my.dashboard') }}"
                                    class="user-profile group-hover:text-secondary bg-gray-50 h-12 flex items-center group-hover:rounded-b-none rounded-md shadow">
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
                                        @role('superadmin')
                                            <a href="/admin/dashboard" target="_blank"
                                                class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                                <i class="mr-3 text-xs fa-solid fa-user"></i>Admin Panel
                                            </a>
                                        @endrole
                                        <a href="{{ route('my.dashboard') }}"
                                            class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-xs fa-solid fa-gauge"></i>Dashboard
                                        </a>
                                        <a href="{{ route('my.order') }}"
                                            class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-xs fa-solid fa-list"></i>Orders
                                        </a>
                                        <a href="{{ route('my.address') }}"
                                            class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-sm fa-solid fa-location-dot"></i>Address
                                        </a>
                                        <a href="{{ route('my.profile') }}"
                                            class="border-b px-3 py-2 text-xs hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                            <i class="mr-3 text-sm fa-solid fa-user"></i>Profile
                                        </a>
                                        <a href="{{ route('logout') }}"
                                            class="text-xs px-3 py-2 hover:text-white hover:bg-secondary transition duration-150 ease-in-out rounded-b-lg">
                                            <i class="mr-3 text-xs fa-solid fa-arrow-right-from-bracket"></i>Logout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        @guest
                            <a href="{{ route('login.create') }}"
                                class="bg-gray-50 group-hover:text-secondary h-12 flex items-center rounded-md shadow"
                                data-mc-on-previous-url="{{ url()->current() }}">
                                <div class="flex items-center justify-center w-12 border-r">
                                    <i class="icon fa-regular fa-user"></i>
                                </div>
                                <div class="px-4">
                                    <span class="line-clamp-2 text-md font-medium">
                                        Login
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
                        <i class="text-base fa-solid fa-bars text-white"></i>
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
                        <div id="menu-profile" style="display: none"
                            class="profile-list hidden absolute top-full -right-12 z-20 group-hover:block">
                            <div class="flex flex-col bg-gray-50 rounded-lg rounded-t-none w-40 shadow-xl">
                                <a href="{{ route('my.dashboard') }}"
                                    class="border-b px-3 py-2 text-sm hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                    <i class="mr-2 fa-solid fa-chart-line"></i>Dashboard
                                </a>
                                <a href="{{ route('my.order') }}"
                                    class="border-b px-3 py-2 text-sm hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                    <i class="mr-2 text-xs fa-solid fa-list"></i></i>Orders
                                </a>
                                <a href="{{ route('my.address') }}"
                                    class="border-b px-3 py-2 text-sm hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                    <i class="mr-1 text-sm fa-solid fa-location-dot"></i>Address
                                </a>
                                <a href="{{ route('my.profile') }}"
                                    class="border-b px-3 py-2 text-sm hover:bg-secondary hover:text-white transition duration-150 ease-in-out">
                                    <i class="mr-1 text-sm fa-solid fa-location-dot"></i>Profile
                                </a>
                                <a href="{{ route('logout') }}"
                                    class="text-sm px-3 py-2 hover:text-white hover:bg-secondary transition duration-150 ease-in-out rounded-b-lg">
                                    <i class="mr-2 fa-solid fa-arrow-right-from-bracket"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                @endauth
                @guest
                    <a href="{{ route('login.create') }}" title="Login" class=""
                        data-mc-on-previous-url="{{ url()->current() }}">
                        <i class="text-lg text-secondary fa-solid fa-right-to-bracket"></i>
                    </a>
                @endguest
                <div class="pr-2">
                    <a href="{{ route('cart.items') }}" class="flex items-center space-x-2"
                        data-mc-on-previous-url="{{ route('cart.items') }}">
                        <div class="item relative">
                            <button class="block">
                                <i class="icon text-lg text-secondary fa-solid fa-cart-shopping"></i>
                            </button>
                            <div
                                class="cart-dev absolute -top-3 -right-3 bg-secondary rounded-full w-5 h-5 text-center flex items-center justify-center">
                                <span class="cart-count text-black font-normal text-xxs">0</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            {{-- ====search field & categories for mobile menu===== --}}
            <div class="flex space-x-2">
                <div class="relative">
                    <div class="bg-white rounded-sm">
                        <button type="button" id="category-menu" onclick="toogleOptionCategory()"
                            class="category-btn px-3 h-8 text-sm text-gray-500">
                            Select Menu<i class="ml-1 text-xs fa-solid fa-angle-down"></i>
                        </button>
                    </div>
                    <div class="absolute">
                        <div class="">
                            <div id="menu-item" style="display: none" class="category-list mobile-nav w-64">
                                <a class="mobile-nav-item" href="{{ route('products.index') }}">
                                    <img class="img-wrapper" src="{{ asset('images/icons/watch_icon.png') }}"> All
                                    Products
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Search bar for mobile --}}
                <div id="search-bar" class="search-box flex-1">
                    <div class="flex rounded-sm top-0 mb-2 h-8 border bg-white">
                        <button class="px-2.5 flex items-center">
                            <i class="text-xs fa-solid fa-magnifying-glass"></i>
                        </button>
                        <input
                            class="search-box-input text-xs placeholder:text-sm  py-1 w-full rounded focus:outline-none"
                            placeholder="Search here.">
                    </div>

                    <div
                        class="hidden search-box-result absolute bg-white top-full left-0 right-0 p-4 shadow rounded-md">
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
            <div class="flex items-center justify-around h-full">
                <div class="">
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
                            <a href="" target="_blank" class="icon-wrapper text-xl xl:text-2xl"><i class="icon fa-brands fa-google-play"></i></a>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
</div>

{{-- =========mobile drawer menu========= --}}
<section class="">
    <div id="menu-box" class="sidebar-menu fixed top-0 left-0 bottom-0 right-0 z-50 bg-black/30"
        style="display: none">
        <div class="w-36 h-full bg-white">
            <div class="header h-14 flex space-x-4 items-center bg-primary shadow">
                <a href="{{ route('home') }}" class="flex-1">
                    <img class="w-[8.375rem] pl-4" src="/images/logos/logo.png">
                </a>
                <div class=""id="menu" onclick="toggleMenu()">
                    <button class="rounded px-4 py-2"><i class="text-lg fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="menu">
                <div class="flex flex-col">
                    <a href="{{ route('products.index') }}"
                        class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out">
                        <i class="pr-3 fa-solid fa-list"></i>
                        Products
                    </a>
                    <a href="{{ route('my.wishlist') }}"
                        class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out"
                        data-mc-on-previous-url="{{ route('my.wishlist') }}">
                        <i class="pr-3 fa-solid fa-heart"></i>
                        Wishcart
                    </a>
                    <a href="{{ route('my.address') }}"
                        class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out"
                        data-mc-on-previous-url="{{ route('my.address') }}">
                        <i class="pr-3 fa-solid fa-location-dot"></i>
                        Address
                    </a>

                    <a href="{{ route('my.order') }}"
                        class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out"
                        data-mc-on-previous-url="{{ route('my.order') }}">
                        <i class="pr-3 fa-solid fa-cart-shopping"></i>
                        My Order
                    </a>

                    <a href=""
                        class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out"
                        data-mc-on-previous-url="{{ route('my.address') }}">
                        <i class="pr-3 fa-solid fa-layer-group"></i>
                        Category
                    </a>

                    <a href=""
                        class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out"
                        data-mc-on-previous-url="{{ route('my.address') }}">
                        <i class="pr-3 fa-regular fa-address-card"></i>
                        About
                    </a>

                    <a href=""
                        class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out"
                        data-mc-on-previous-url="{{ route('my.address') }}">
                        <i class="pr-3 fa-regular fa-address-book"></i>
                        Contact
                    </a>

                    @auth
                        <a href="{{ route('logout') }}"
                            class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out">
                            <i class="pr-3 fa-solid fa-arrow-right-from-bracket"></i>
                            Logout
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('login.create') }}"
                            class="text-base font-medium border-b rounded-b hover:bg-primary hover:text-white py-3 px-4 transition duration-300 ease-in-out"
                            data-mc-on-previous-url="{{ url()->current() }}">
                            <i class="pr-3 fa-solid fa-right-to-bracket"></i>
                            Login
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

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
        var profileList = $('.profile-list');

        //==========Mobile Navigation menu==========
        function toggleMenu() {
            var menuBox = document.getElementById('menu-box');
            if (menuBox.style.display == "none") {
                menuBox.style.display = "block";
            } else { // if is menuBox hidden, display it
                menuBox.style.display = "none";
            }
        }
        //==========./Mobile Navigation menu==========

        // =================dropdown category=====================
        // Select categories header menu
        function toogleOptionCategory() {
            var categoryList = document.getElementById('menu-item');
            if (categoryList.style.display == "none") {
                categoryList.style.display = "block";
            } else { // if is menuBox hidden, display it
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
            if (categoryList.style.display == "none") {
                categoryList.style.display = "block";
            } else { // if is menuBox hidden, display it
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
        $(function() {
            var lastScrollTop = 0,
                delta = 15;
            $(window).scroll(function(event) {
                var st = $(this).scrollTop();

                if (Math.abs(lastScrollTop - st) <= delta) {
                    return;
                }
                if ((st > lastScrollTop) && (lastScrollTop > 0)) {
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
        var cartCount = $('.cart-count');
        var searchInput = $('.search-box-input');
        var searchResult = $('.search-box-result');
        var searchResultList = $('.search-box-result-list');

        @auth
        __cartItemCount();
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
            }, 750));
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
                    var offerPrice = product.offer_price;
                    var productPrice = product.mrp;
                    var isPriceHidden = '';
                    var isofferPriceHidden = 'hidden';
                    if (offerPrice > 0) {
                        isPriceHidden = 'line-through';
                        isofferPriceHidden = '';
                    }
                    var itemHTML = `
                    <a href="/products/${product.id}/${product.slug}" class="hover:bg-gray-200 transition duration-150 ease-in-out border-b border-dashed flex space-x-2 py-2 pr-3 items-center" data-product-id="${product.id}">
                        <div class="w-14 h-14">
                            <img class="w-full h-full" src="${product.img_src}" alt="">
                        </div>
                        <div class="flex-1 flex flex-col">
                            <h4 class="text-xs text-gray-500">${product.brand?.name}</h4>
                            <h2 class="text-base text-primary">${product.name}</h2>
                            <span class="text-xxs text-gray-500">${product.category?.name}</span>
                        </div>
                        <div class="flex justify-center items-center text-sm ${isPriceHidden}">
                            <span class="text-gray-500">${productPrice} tk</span>
                        </div>
                        <div class="flex justify-center items-center text-sm ${isofferPriceHidden}">
                            <span class="text-gray-500">${offerPrice} tk</span>
                        </div>
                    </a>`;

                    searchResultList.append(itemHTML);
                }
            } else {
                searchResultList.html(`<strong>No product found by "${keywords}"</strong>`);
            }
            searchResult.show();
        }
    </script>
@endpush
