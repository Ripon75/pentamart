@extends('frontend.layouts.default')

<style>
    /* Styling the slider container */
    .slider-container {
        margin: 0 auto;
        /* Center the slider container */
        /* max-width: 800px; */
        width: 100%;
        /* Set a maximum width for the slider */
        height: 250px;
        margin: 5px 5px 5px 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Styling each slide */
    .slider-item {
        padding: 20px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-align: center;
    }

    .slick-slide {
        margin: 10px;
        padding: 0%;
    }

    .slick-list {
        height: 240px;
    }

    /* Styling the navigation buttons */
    .prev-button1 {
        background-color: #333;
        color: #fff;
        border: none;
        padding: 10px 20px;
        position: absolute;
        left: 5%;
        top: 50%;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .next-button1 {
        background-color: #333;
        color: #fff;
        border: none;
        padding: 10px 20px;
        position: absolute;
        right: 5%;
        top: 50%;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .prev-button1:hover,
    .next-button1:hover {
        background-color: #555;
    }

    .prev-button1 {
        float: left;
        margin-right: 10px;
    }

    .next-button1 {
        float: right;
        margin-left: 10px;
    }
</style>

@section('title', 'Home')

@section('content')
    {{-- ==============Banner Slider========================= --}}
    <section class="mt-[120px] sm:mt-[120px] md:mt-[120px] lg:mt44">
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

    {{-- ==============Service Section=================== --}}
    <section class="service-section pt-4 pb-4 hidden sm:hidden md:hidden lg:block xl:block 2xl:block">
        <div class="container">
            <div
                class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4 sm:gap-4 md:gap-4 lg:gap-4 xl:gap-8 2xl:gap-8">
                @foreach ($topBrands as $topBrand)
                    <x-frontend.banner-box type="service" :bg-color="'#fff'" pre-title="" title="" :img-src="$topBrand->img_src"
                        post-title="Shop Now" :post-title-link="route('brand.page', [$topBrand->id, $topBrand->slug])" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==============Service Section for mobile=================== --}}
    <section class="service-section pt-2 pb-2 block sm:block md:block lg:hidden xl:hidden 2xl:hidden">
        <div class="container">
            <div class="grid grid-cols-3 gap-1 sm:gap-1 md:gap-2 lg:gap-4 xl:gap-8 2xl:gap-8 ">
                @foreach ($topBrands as $topBrand)
                    <x-frontend.banner-box type="service" :bg-color="'#fff'" pre-title="" title="" :img-src="$topBrand->img_src"
                        post-title="Shop Now" :post-title-link="route('brand.page', [$topBrand->id, $topBrand->slug])" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================Top Products================== --}}
    @if ($topProduct)
        <section class="page-section">
            <div class="container">
                <div class="text-center">
                    <h1 class="section-title mb-2">{{ $topProduct->title }}</h1>
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

    <section class="symptoms-section page-section bg-gray-100">
        <div class="container">
            <div class="headline text-center">
                <h1 class="section-title">Top Categories</h1>
            </div>
            <div
                class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-1 sm:gap-1 md:gap-2 lg:gap-4 xl:gap-4 2xl:gap-4 mt-10">
                @foreach ($topCategories as $tCategory)
                    <a href="{{ route('category.page', [$tCategory->id, $tCategory->slug]) }}" class="img-wrapper">
                        <img class="img" src="{{ $tCategory->img_src }}">
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================Medical Devices================== --}}
    @if (count($otherProduct->products))
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
    @endif



    <section class="page-section">
        <div style="position: relative;" class="container">
            <div class="text-center">
                <h1 class="section-title mb-5">New Arrivals</h1>
            </div>

            <div class="slider-container">
                <div class="slider-item">
                    <div class="slide-content">
                        <img style="width:100%;height:150px;" class="" src="{{ asset('images/ss.jpg') }}"
                            alt="no images">
                    </div>
                    <div class="p-2">
                        <p style="text-align: left;">
                            Premium Roles Watch
                        </p>

                        <p style="text-align: left;" class="text-sm">
                            Smart Watch
                        </p>

                        <p style="text-align: left;" class="text-orange-500">
                            Tk : 1969
                        </p>
                    </div>
                </div>

                <div class="slider-item">
                    <img style="width:100%;height:150px;" class="" src="{{ asset('images/images.jpeg') }}"
                        alt="no images">
                    <div class="p-2">
                        <p style="text-align: left;">
                            Premium Roles Watch
                        </p>

                        <p style="text-align: left;" class="text-sm">
                            Smart Watch
                        </p>

                        <p style="text-align: left;" class="text-orange-500">
                            Tk : 1969
                        </p>
                    </div>
                </div>

                <div class="slider-item">
                    <img style="width:100%;height:150px;" src="{{ asset('images/Untitled.jpeg') }}" alt="no images">

                    <div class="p-2">
                        <p style="text-align: left;">
                            Premium Roles Watch
                        </p>

                        <p style="text-align: left;" class="text-sm">
                            Smart Watch
                        </p>

                        <p style="text-align: left;" class="text-orange-500">
                            Tk : 1969
                        </p>
                    </div>
                </div>
                <div class="slider-item">
                    <img style="width:100%;height:150px;"
                        class="
                        src="{{ asset('images/ss.jpg') }}" alt="no images">
                    <div class="p-2">
                        <p style="text-align: left;">
                            Premium Roles Watch
                        </p>

                        <p style="text-align: left;" class="text-sm">
                            Smart Watch
                        </p>

                        <p style="text-align: left;" class="text-orange-500">
                            Tk : 1969
                        </p>
                    </div>
                </div>

                <div class="slider-item">
                    <img style="width:100%;height:150px;" class="" src="{{ asset('images/images.png') }}"
                        alt="no images">
                    <div class="p-2">
                        <p style="text-align: left;">
                            Premium Roles Watch
                        </p>

                        <p style="text-align: left;" class="text-sm">
                            Smart Watch
                        </p>

                        <p style="text-align: left;" class="text-orange-500">
                            Tk : 1969
                        </p>
                    </div>
                </div>

                <div class="slider-item">
                    <img style="width:100%;height:150px;" class="" src="{{ asset('images/images.png') }}"
                        alt="no images">
                    <div class="p-2">
                        <p style="text-align: left;">
                            Premium Roles Watch
                        </p>

                        <p style="text-align: left;" class="text-sm">
                            Smart Watch
                        </p>

                        <p style="text-align: left;" class="text-orange-500">
                            Tk : 1969
                        </p>
                    </div>
                </div>

                <div class="slider-item">
                    <img style="width:100%;height:150px;" class="" src="{{ asset('images/ss.jpg') }}"
                        alt="no images">
                    <div class="p-2">
                        <p style="text-align: left;">
                            Premium Roles Watch
                        </p>

                        <p style="text-align: left;" class="text-sm">
                            Smart Watch
                        </p>

                        <p style="text-align: left;" class="text-orange-500">
                            Tk : 1969
                        </p>
                    </div>
                </div>

                <!-- Add more slides as needed -->
            </div>

            <button class="prev-button1"><i class="fa-solid fa-arrow-left"></i></button>
            <button class="next-button1"><i class="fa-solid fa-arrow-right-long"></i></button>
        </div>
    </section>




    {{-- Offers --}}
    <section class="page-section">
        <div class="container">
            <div class="text-center">
                <h1 class="section-title mb-5">Special Offers</h1>
            </div>
            <div class="flex justify-center items-center flex-wrap sm:flex-wrap md:flex-wrap lg:flex-wrap 2xl:flex-wrap">
                <div style="background-color: #00798C"
                    class="w-32 h-auto m-1 md:w-64 lg:w-64 2xl:w-64 hover:scale-105 transition duration-300 ease-in-out rounded">

                    <div class="">
                        <img class="w-full h-28 md:h-56 lg:h-56 2xl:h-56" src="{{ asset('images/ss.jpg') }}"
                            alt="no images">
                    </div>

                    <div class="m-1">
                        <p class="text-sm text-center text-primaryError-light md:text-lg lg:text-lg 2xl:text-lg">
                            METER SYSTEM HOT SALE
                        </p>
                        <h2
                            class="text-sm text-white font-mono mt-1 mb-1 font-semibold md:text-2xl m-1 p-1 lg:text-2xl 2xl:text-2xl">
                            Save Upto 16%
                        </h2>
                        <a class="text-sm md:text-lg lg:text-lg 2xl:text-lg" href="">Buy Now <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <div style="background-color: #00798C"
                    class="w-32 h-auto m-1 md:w-64 lg:w-64 2xl:w-64 hover:scale-105 transition duration-300 ease-in-out rounded">

                    <div class="">
                        <img class="w-full h-28 md:h-56 lg:h-56 2xl:h-56" src="{{ asset('images/images.jpeg') }}"
                            alt="no images">
                    </div>

                    <div class="m-1">
                        <p class="text-sm text-center text-primaryError-light md:text-lg lg:text-lg 2xl:text-lg">SMART
                            WATCH SALE</p>
                        <h2
                            class="text-sm text-white font-mono mt-1 mb-1 font-semibold md:text-2xl m-1 p-1 lg:text-2xl 2xl:text-2xl">
                            Save Upto 16%
                        </h2>
                        <a class="text-sm md:text-lg lg:text-lg 2xl:text-lg" href="">Buy Now <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <div style="background-color: #00798C"
                    class="w-32 h-auto m-1 md:w-64 lg:w-64 2xl:w-64 hover:scale-105 transition duration-300 ease-in-out rounded">

                    <div class="">
                        <img class="w-full h-28 md:h-56 lg:h-56 2xl:h-56" src="{{ asset('images/Untitled.jpeg') }}"
                            alt="no images">
                    </div>

                    <div class="m-1">
                        <p class="text-sm text-center text-primaryError-light md:text-lg lg:text-lg 2xl:text-lg">METER
                            SYSTEM HOT SALE</p>
                        <h2
                            class="text-sm text-white font-mono mt-1 mb-1 font-semibold md:text-2xl m-1 p-1 lg:text-2xl 2xl:text-2xl">
                            Save Upto 16%
                        </h2>
                        <a class="text-sm md:text-lg lg:text-lg 2xl:text-lg" href="">Buy Now <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <div style="background-color: #00798C"
                    class="w-32 h-auto m-1 w- md:w-64 lg:w-64 2xl:w-64 hover:scale-105 transition duration-300 ease-in-out rounded">

                    <div class="">
                        <img class="w-full h-28 md:h-56 lg:h-56 2xl:h-56" src="{{ asset('images/images.png') }}"
                            alt="no images">
                    </div>

                    <div class="m-1">
                        <p class="text-sm text-center text-primaryError-light md:text-lg lg:text-lg 2xl:text-lg">METER
                            SYSTEM HOT SALE</p>
                        <h2
                            class="text-sm text-white font-mono mt-1 mb-1 font-semibold md:text-2xl m-1 p-1 lg:text-2xl 2xl:text-2xl">
                            Save Upto 16%
                        </h2>
                        <a class="text-sm md:text-lg lg:text-lg 2xl:text-lg" href="">Buy Now <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Offers END --}}

    {{-- ==================Features================== --}}
    <section class="page-section bg-gray-100">
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
            $('.slider-container').slick({
                slidesToShow: 3, // Display three slides at a time
                slidesToScroll: 1, // Change one slide at a time
                prevArrow: $('.prev-button1'), // Use prev button for navigation
                nextArrow: $('.next-button1'), // Use next button for navigation
                // Other Slick options can be added here
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
