@extends('frontend.layouts.default')

<style>
    .slider-container {
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 10px 12px 10px;
        border-radius: 4px;
        height: 305px;
    }


    .slider-container1 {
        margin: 0 auto;
        /* Center the slider container */
        /* max-width: 800px; */
        width: 100%;
        /* Set a maximum width for the slider */
        height: 250px;
        margin: 5px 5px 5px 0px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .slick-slide {
        position: relative;
    }

    .ofText {
        position: absolute;
        top: 5%;
        background-color: #EF4444;
        right: 5%;
        padding: 2px;
        width: 50px;
        border-radius: 4px;
        color: #fff;
        font-size: 13px;
    }

    .prev-button1:hover,
    .next-button1:hover {
        background-color: #555;
    }
</style>

@section('title', 'Home')

@section('content')
    {{-- ==============Banner Slider========================= --}}
    <section class="mt-[100px] sm:mt-[100px] md:mt-[120px] lg:mt44">
        <div id="carouselExampleIndicators" class="carousel slide relative" data-bs-ride="carousel">
            <div class="carousel-indicators absolute right-0 bottom-0 left-0 flex justify-center p-0 mb-0 md:mb-4">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true">
                </button>
                @for ($i = 1; $i < count($sliders); $i++)
                    <button type="button" data-bs-target="#carouselExampleIndicators" class=""
                        data-bs-slide-to="{{ $i }}">
                    </button>
                @endfor
            </div>
            @if (count($sliders) > 0)
                <div class="carousel-inner relative w-full overflow-hidden">
                    <div class="carousel-item active float-left w-full">
                        <img src="{{ $sliders[0]->web_img_src }}" class="hidden sm:hidden md:block w-full" alt="" />
                        <img src="{{ $sliders[0]->mobile_img_src }}" class="w-full block sm:block md:hidden"
                            alt="" />
                    </div>

                    @for ($i = 1; $i < count($sliders); $i++)
                        <div class="carousel-item float-left w-full">
                            <img src="{{ $sliders[$i]->web_img_src }}" class="hidden sm:hidden md:block w-full"
                                alt="" />
                            <img src="{{ $sliders[$i]->mobile_img_src }}" class="block sm:block md:hidden w-full"
                                alt="" />
                        </div>
                    @endfor
                </div>
            @endif
            <button
                class="carousel-control-prev absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline left-0"
                type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon inline-block bg-no-repeat" aria-hidden="false"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button
                class="carousel-control-next absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline right-0"
                type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon inline-block bg-no-repeat" aria-hidden="false"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    {{-- Subsidaries --}}
    <section class="page-section">
        <div style="position: relative;" class="container">
            <div class="text-center">
                <h1 class="section-title mb-5">Our Subsidaries</h1>
            </div>

            <div class="slider-container1">

                @foreach ($topBrands as $brand)
                    <div>
                        <img style="width:85%;" class="h-[195px] block mx-auto rounded" src="{{ $brand->img_src }}"
                            alt="no images">
                        <div class="mt-3 w-[90px] mx-auto">
                            <a href="{{ route('brand.page', [$brand->id, $brand->slug]) }}"
                                class="btn btn-sm btn-primary rounded text-sm">Shop Now</a>
                        </div>
                    </div>
                @endforeach
                <!-- Add more slides as needed -->
            </div>

            <button style="top: 55%;background-color: #333;color: #fff;padding: 7px 15px;transition: background-color 0.3s;"
                class="absolute left-2 border-0 rounded cursor-pointer md:left-16 lg:left-16 prev-button2">
                <i class="fa-solid fa-arrow-left-long"></i>
            </button>
            <button style="top: 55%;background-color: #333;color: #fff;padding: 7px 15px;transition: background-color 0.3s;"
                class="absolute right-2 border-0 rounded cursor-pointer md:right-16 lg:right-16 next-button2">
                <i class="fa-solid fa-arrow-right-long"></i>
            </button>
        </div>
    </section>

    {{-- New Arrivals --}}
    @if (count($newArrival->products) > 0)
        <section class="page-section">
            <div style="position: relative;" class="container">
                <div class="text-center">
                    <h1 class="section-title mb-5">{{ $newArrival->title }}</h1>
                </div>

                <div class="slider-container">

                    @foreach ($newArrival->products as $product)
                        <div
                            style="height:275px;margin: 5px 5px 5px; box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;">
                            <a href="{{ route('products.show', [$product->id, $product->slug]) }}">
                                <img class="w-full h-[136px]" src="{{ $product->img_src }}" alt="no images">
                            </a>
                            <div class="p-2" style="background-color: #F9FAFB; height:138px;">
                                <div class="w-12 rounded" style="background-color: #DCFCE7;color:#58C55E">
                                    <span style="font-size: 11px;">In Stock</span>
                                </div>

                                <p style="color:#00798C;"
                                    class="text-[14px] font-semibold mt-1 text-left md:text-[14px] lg:text-[14px] 2xl:text-2xl">
                                    <a href="{{ route('products.show', [$product->id, $product->slug]) }}">
                                        {{ $product->name }}
                                    </a>
                                </p>

                                <p class="text-left text-[11px] md:text-[12px] lg:text-[12px] 2xl:text-lg">
                                    <a
                                        href="{{ route('category.page', [$product->category_id, $product->category->slug ?? '']) }}">
                                        {{ $product->category->name ?? '' }}
                                    </a>

                                </p>

                                <div class="flex mt-1 justify-between">
                                    @if ($product->offer_price > 0)
                                        <p
                                            class="text-orange-500 text-[12px] text-left sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                            TK : {{ $product->offer_price }}
                                        </p>
                                        <p
                                            class="line-through text-[12px] sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                            TK : <span>{{ $product->mrp }}</span>
                                        </p>
                                    @else
                                        <p class="text-[12px] sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                            TK : <span>{{ $product->mrp }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            @if ($product->offer_price > 0)
                                <p class="ofText">
                                    {{ $product->offer_percent }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                    <!-- Add more slides as needed -->
                </div>

                <button
                    style="top: 55%;background-color: #333;color: #fff;padding: 7px 15px;transition: background-color 0.3s;"
                    class="absolute left-2 border-0 rounded cursor-pointer md:left-12 lg:left-16 prev-button1">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </button>
                <button
                    style="top: 55%;background-color: #333;color: #fff;padding: 7px 15px;transition: background-color 0.3s;"
                    class="absolute right-2 border-0 rounded cursor-pointer md:right-12 lg:right-16 next-button1">
                    <i class="fa-solid fa-arrow-right-long"></i>
                </button>
            </div>
        </section>
    @endif

    {{-- ==============Service Section=================== --}}
    {{-- <section class="service-section pt-4 pb-4 hidden sm:hidden md:hidden lg:block xl:block 2xl:block">
        <div class="container">
            <div
                class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4 sm:gap-4 md:gap-4 lg:gap-4 xl:gap-8 2xl:gap-8">
                @foreach ($topBrands as $topBrand)
                    <x-frontend.banner-box type="service" :bg-color="'#fff'" pre-title="" title=""
                        :img-src="$topBrand->img_src" post-title="Shop Now" :post-title-link="route('brand.page', [$topBrand->id, $topBrand->slug])" />
                @endforeach
            </div>
        </div>
    </section> --}}

    {{-- ==============Service Section for mobile=================== --}}
    {{-- <section class="service-section pt-2 pb-2 block sm:block md:block lg:hidden xl:hidden 2xl:hidden">
        <div class="container">
            <div class="grid grid-cols-3 gap-1 sm:gap-1 md:gap-2 lg:gap-4 xl:gap-8 2xl:gap-8 ">
                @foreach ($topBrands as $topBrand)
                    <x-frontend.banner-box type="service" :bg-color="'#fff'" pre-title="" title=""
                        :img-src="$topBrand->img_src" post-title="Shop Now" :post-title-link="route('brand.page', [$topBrand->id, $topBrand->slug])" />
                @endforeach
            </div>
        </div>
    </section> --}}

    {{-- ================Top Categories============== --}}
    <section class="symptoms-section page-section">
        <div class="container">
            <div class="headline text-center">
                <h1 class="section-title">Top Categories</h1>
            </div>
            <div
                class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-1 sm:gap-1 md:gap-2 lg:gap-4 xl:gap-4 2xl:gap-4 mt-10">
                @foreach ($topCategories as $tCategory)
                    <div class="w-[155px] m-2 bg-white shadow-md md:w-[230px] lg:w-[230px] 2xl:w-[230px]">
                        <a href="{{ route('category.page', [$tCategory->id, $tCategory->slug]) }}" class="img-wrapper">
                            <img class="h-[150px] w-[100%] rounded" src="{{ $tCategory->img_src }}">
                            <div style="background-color: #fff;" class="">
                                <p style="color:#102967;" class="text-center p-3 font-semibold">{{ $tCategory->name }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    {{-- ==================Top Products================== --}}
    @if ($topProduct)
        <section class="page-section">
            <div class="container">
                <div class="text-center">
                    <h1 class="section-title mb-2">Best Selling Products</h1>
                </div>
                <div
                    class="product-grid grid gap-2 grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-5 2xl:grid-cols-6">
                    @foreach ($topProduct->products as $product)
                        <div data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                            <x-frontend.product-thumb type="default" :product="$product" />
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('products.index') }}" class="btn btn-md btn-primary">Browse All Products</a>
                </div>
            </div>
        </section>
    @endif

    {{-- ===========Watch===================== --}}
    {{-- ==================Medical Devices================== --}}
    {{-- @if (count($otherProduct->products))
        <section class="page-section">
            <div class="container">
                <div class="text-center">
                    <h1 class="section-title mb-5">{{ $otherProduct->title }}</h1>
                </div>
                <div
                    class="product-grid grid gap-2 grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-6">
                    @foreach ($otherProduct->products as $product)
                        <div data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                            <x-frontend.product-thumb type="default" :product="$product" />
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('products.index') }}" class="btn btn-md btn-primary">Browse All Products</a>
                </div>
            </div>
        </section>
    @endif --}}


    {{-- Offers --}}
    <section class="page-section">
        <div class="container">
            <div class="text-center">
                <h1 class="section-title mb-5">Special Offers</h1>
            </div>
            <div class="flex justify-center items-center flex-wrap sm:flex-wrap md:flex-wrap lg:flex-wrap 2xl:flex-wrap">

                {{-- <div style="background-color: #00798C"
                    class="w-32 h-auto m-1 md:w-64 lg:w-64 2xl:w-64 hover:scale-105 transition duration-300 ease-in-out rounded">
                    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-lg">
                        <img class="w-full h-40 object-cover"
                            src="https://dfstudio-d420.kxcdn.com/wordpress/wp-content/uploads/2019/06/digital_camera_photo-1080x675.jpg"
                            alt="Offer Image">
                        <div class="p-4">
                            <h2 class="text-sm font-semibold text-gray-800 md:text-xl lg:text-xl">Canon D Camera</h2>
                            <p class="text-sm text-gray-600 mt-2 md:text-lg lg:text-lg">
                                <span class="text-white-500 bg-clip-text"
                                    style="background-image: linear-gradient(to right, #ff00cc, #6600ff);">Get 20%
                                    off
                                </span>
                            </p>
                            <button
                                class="text-sm mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full">Shop
                                Now</button>
                        </div>
                    </div>
                </div> --}}

                @foreach ($offers as $offer)
                    <div style="background-color: #00798C"
                        class="w-32 h-auto m-1 md:w-64 lg:w-64 2xl:w-64 hover:scale-105 transition duration-300 ease-in-out rounded">
                        <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-lg">
                            <a href="">
                                <img class="w-full h-40 object-cover" src="{{ $offer->img_src }}" alt="Offer Image">
                            </a>
                            <div class="p-4">
                                <h2 class="text-sm font-semibold text-gray-800 md:text-xl lg:text-xl">{{ $offer->title }}
                                </h2>
                                <p class="text-gray-600 mt-2">
                                    <span class="text-white-500 bg-clip-text"
                                        style="background-image: linear-gradient(to right, #ff00cc, #6600ff);">Get
                                        {{ $offer->offer_percent }}%
                                        off
                                    </span>
                                </p>
                                <p class="mt-[15px]">
                                    <a href="{{ route('offers.products', $offer->offer_percent) }}"
                                        class="text-sm mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full">
                                        Shop Now
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- <div style="background-color: #00798C"
                    class="w-32 h-auto m-1 md:w-64 lg:w-64 2xl:w-64 hover:scale-105 transition duration-300 ease-in-out rounded">
                    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-lg">
                        <img class="w-full h-40 object-cover"
                            src="https://brotherselectronicsbd.com/image/cache/catalog/demo/Accessories/Huawei/Watch%203%20Pro/Brothers-Huawei%20Watch%203%20Pro%20(1)-800x800.jpg"
                            alt="Offer Image">
                        <div class="p-4">
                            <h2 class="text-sm font-semibold text-gray-800 md:text-xl lg:text-xl">Apple Smart Watch</h2>
                            <p class="text-gray-600 mt-2">
                                <span class="text-white-500 bg-clip-text"
                                    style="background-image: linear-gradient(to right, #ff00cc, #6600ff);">Get 20%
                                    off
                                </span>
                            </p>
                            <button
                                class="text-sm mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full">Shop
                                Now</button>
                        </div>
                    </div>
                </div> --}}

                {{-- <div style="background-color: #00798C"
                    class="w-32 h-auto m-1 md:w-64 lg:w-64 2xl:w-64 hover:scale-105 transition duration-300 ease-in-out rounded">
                    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-lg">
                        <img class="w-full h-40 object-cover"
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-6gpSFfSouDX2HmBIUJkM4gWvPc6CrFY1HA&usqp=CAU"
                            alt="Offer Image">
                        <div class="p-4">
                            <h2 class="text-sm font-semibold text-gray-800 md:text-xl lg:text-xl">RAY-BAN sunglass</h2>
                            <p class="text-gray-600 mt-2 ">
                                <span class="text-white-500 bg-clip-text"
                                    style="background-image: linear-gradient(to right, #ff00cc, #6600ff);">Get 20%
                                    off
                                </span>
                            </p>
                            <button
                                class="text-sm mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full">Shop
                                Now</button>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </section>

    {{-- Offers END --}}

    {{-- ==================Features================== --}}
    <section class="page-section">
        <div class="container">
            <div class="grid gap-4 grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                @foreach ($features as $feature)
                    <div
                        class="flex items-center justify-center shadow-xl ring-2 ring-gray-400 ring-opacity-50 p-6 rounded">
                        <div class="flex flex-col items-center">
                            <img style="width: 20%;" src="{{ asset($feature['imgSrc']) }}" alt="Image">
                            <h1
                                class="mt-4 text-lg sm:text-lg md:text-lg lg:text-lg xl:text-lg 2xl:text-lg font-medium text-gray-900">
                                {{ $feature['title'] }}
                            </h1>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>




@endsection

@push('scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- Include Slick Slider Theme CSS (optional) -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- Include jQuery (required for Slick Slider) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Slick Slider JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.slider-container1').slick({
                slidesToShow: 4, // Display three slides at a time
                slidesToScroll: 1, // Change one slide at a time
                prevArrow: $('.prev-button2'), // Use prev button for navigation
                nextArrow: $('.next-button2'), // Use next button for navigation
                responsive: [{
                        breakpoint: 320, // Adjust the breakpoint as needed
                        settings: {
                            slidesToShow: 2, // Display four slides at a time for larger screens
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 480, // Adjust the breakpoint as needed
                        settings: {
                            slidesToShow: 2, // Display four slides at a time for larger screens
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 768, // Adjust the breakpoint as needed
                        settings: {
                            slidesToShow: 3, // Display four slides at a time for larger screens
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 1024, // Adjust the breakpoint as needed
                        settings: {
                            slidesToShow: 3, // Display four slides at a time for larger screens
                            slidesToScroll: 1,
                        }
                    },
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.slider-container').slick({
                slidesToShow: 5, // Display three slides at a time
                slidesToScroll: 1, // Change one slide at a time
                prevArrow: $('.prev-button1'), // Use prev button for navigation
                nextArrow: $('.next-button1'), // Use next button for navigation
                responsive: [{
                        breakpoint: 320, // Adjust the breakpoint as needed
                        settings: {
                            slidesToShow: 2, // Display four slides at a time for larger screens
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 480, // Adjust the breakpoint as needed
                        settings: {
                            slidesToShow: 2, // Display four slides at a time for larger screens
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 768, // Adjust the breakpoint as needed
                        settings: {
                            slidesToShow: 3, // Display four slides at a time for larger screens
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 1024, // Adjust the breakpoint as needed
                        settings: {
                            slidesToShow: 3, // Display four slides at a time for larger screens
                            slidesToScroll: 1,
                        }
                    },
                ]
            });
        });
    </script>


    <script>
        AOS.init();
        // Category Menu for Medicine Corner
        function toggleCategory() {
            var categoryList = document.getElementById('category-list');
            if (categoryList.style.display == "none") { // if is menuBox displayed, hide it
                categoryList.style.display = "block";
            } else { // if is menuBox hidden, display it
                categoryList.style.display = "none";
            }
        }
    </script>
@endpush
