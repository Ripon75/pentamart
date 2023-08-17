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

    .slider-container1 {
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

    .slick-slide {
        margin: 10px;
        padding: 0%;
    }

    .slick-list {
        height: 240px;
    }


    .prev-button1:hover,
    .next-button1:hover {
        background-color: #555;
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

    {{-- Subsidaries --}}
    <section class="page-section">
        <div style="position: relative;" class="container">
            <div class="text-center">
                <h1 class="section-title mb-5">Our Subsidaries</h1>
            </div>

            <div class="slider-container1">

                <div class="relative slider-item w-full sm:w-full md:w-40">
                    <div class="slide-content">
                        <img class="w-full h-[133px]"
                            src="https://images.unsplash.com/photo-1524592094714-0f0654e20314?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8d29tZW5zJTIwd2F0Y2h8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                            alt="no images">
                    </div>
                    <div class="p-2" style="background-color: #F9FAFB;">
                        <div class="w-16" style="background-color: #DCFCE7;color:#58C55E">
                            <span style="font-size: 13px;">In Stock</span>
                        </div>
                        <p style="color:#00798C;"
                            class="text-[12px] font-semibold mt-1 text-left md:text-sm lg:text-sm 2xl:text-lg">
                            Premium Roles Watch
                        </p>

                        <p style="font-size:13px;" class="text-left">
                            Category-1
                        </p>

                        <div class="flex mt-1">
                            <p
                                class="text-orange-500 text-[12px] text-left sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : 194.69
                            </p>
                            <p class="ml-4 line-through text-[12px] sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : <span>754.00</span>
                            </p>
                        </div>
                    </div>
                    <p class="ofText">
                        -10 %
                    </p>
                </div>

                <div class="relative slider-item w-full sm:w-full md:w-40">
                    <div class="slide-content">
                        <img class="w-full h-[133px]"
                            src="https://images.unsplash.com/photo-1584208123923-cc027813cbcb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8d29tZW5zJTIwd2F0Y2h8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                            alt="no images">
                    </div>
                    <div class="p-2" style="background-color: #F9FAFB;">
                        <div class="w-16" style="background-color: #DCFCE7;color:#58C55E">
                            <span style="font-size: 13px;">In Stock</span>
                        </div>
                        <p style="color:#00798C;"
                            class="text-xs font-semibold mt-1 text-left md:text-sm lg:text-sm 2xl:text-lg">
                            Premium Roles Watch
                        </p>

                        <p style="font-size:13px;" class="text-left">
                            Category-1
                        </p>

                        <div class="flex mt-1">
                            <p class="text-orange-500 text-xs text-left sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : 19.69
                            </p>
                            <p class="ml-4 line-through text-xs sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : <span>75.00</span>
                            </p>
                        </div>
                    </div>
                    <p class="ofText">
                        -10 %
                    </p>
                </div>

                <div class="relative slider-item w-full sm:w-full md:w-40">
                    <div class="slide-content">
                        <img class="w-full h-[133px]"
                            src="data:image/jpeg;base64,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"
                            alt="no images">
                    </div>
                    <div class="p-2" style="background-color: #F9FAFB;">
                        <div class="w-16" style="background-color: #DCFCE7;color:#58C55E">
                            <span style="font-size: 13px;">In Stock</span>
                        </div>
                        <p style="color:#00798C;"
                            class="text-xs font-semibold mt-1 text-left md:text-sm lg:text-sm 2xl:text-lg">
                            Premium Roles Watch
                        </p>

                        <p style="font-size:13px;" class="text-left">
                            Category-1
                        </p>

                        <div class="flex mt-1">
                            <p class="text-orange-500 text-xs text-left sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : 19.69
                            </p>
                            <p class="ml-4 line-through text-xs sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : <span>75.00</span>
                            </p>
                        </div>
                    </div>
                    <p class="ofText">
                        -10 %
                    </p>
                </div>

                <div class="relative slider-item w-full sm:w-full md:w-40">
                    <div class="slide-content">
                        <img class="w-full h-[133px]" src="{{ asset('images/images.png') }}" alt="no images">
                    </div>
                    <div class="p-2" style="background-color: #F9FAFB;">
                        <div class="w-16" style="background-color: #DCFCE7;color:#58C55E">
                            <span style="font-size: 13px;">In Stock</span>
                        </div>
                        <p style="color:#00798C;"
                            class="text-xs font-semibold mt-1 text-left md:text-sm lg:text-sm 2xl:text-lg">
                            Premium Roles Watch
                        </p>

                        <p style="font-size:13px;" class="text-left">
                            Category-1
                        </p>

                        <div class="flex mt-1">
                            <p class="text-orange-500 text-xs text-left sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : 19.69
                            </p>
                            <p class="ml-4 line-through text-xs sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : <span>75.00</span>
                            </p>
                        </div>
                    </div>
                    <p class="ofText">
                        -10 %
                    </p>
                </div>

                <div class="relative slider-item w-full sm:w-full md:w-40">
                    <div class="slide-content">
                        <img class="w-full h-[133px]" src="{{ asset('images/images.png') }}" alt="no images">
                    </div>
                    <div class="p-2" style="background-color: #F9FAFB;">
                        <div class="w-16" style="background-color: #DCFCE7;color:#58C55E">
                            <span style="font-size: 13px;">In Stock</span>
                        </div>
                        <p style="color:#00798C;"
                            class="text-xs font-semibold mt-1 text-left md:text-sm lg:text-sm 2xl:text-lg">
                            Premium Roles Watch
                        </p>

                        <p style="font-size:13px;" class="text-left">
                            Category-1
                        </p>

                        <div class="flex mt-1">
                            <p class="text-orange-500 text-xs text-left sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : 19.69
                            </p>
                            <p class="ml-4 line-through text-xs sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : <span>75.00</span>
                            </p>
                        </div>
                    </div>
                    <p class="ofText">
                        -10 %
                    </p>
                </div>

                <!-- Add more slides as needed -->
            </div>

            <button
                style="top: 55%;background-color: #333;color: #fff;padding: 7px 15px;transition: background-color 0.3s;"
                class="absolute left-2 border-0 rounded cursor-pointer md:left-16 lg:left-16 prev-button2">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <button
                style="top: 55%;background-color: #333;color: #fff;padding: 7px 15px;transition: background-color 0.3s;"
                class="absolute right-0 border-0 rounded cursor-pointer md:right-16 lg:right-16 next-button2">
                <i class="fa-solid fa-arrow-right-long"></i>
            </button>
        </div>
    </section>

    {{-- New Arrivals --}}
    <section class="page-section">
        <div style="position: relative;" class="container">
            <div class="text-center">
                <h1 class="section-title mb-5">New Arrivals</h1>
            </div>

            <div class="slider-container">

                <div class="relative slider-item w-full sm:w-full md:w-40">
                    <div class="slide-content">
                        <img class="w-full h-[133px]"
                            src="https://images.unsplash.com/photo-1524592094714-0f0654e20314?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8d29tZW5zJTIwd2F0Y2h8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                            alt="no images">
                    </div>
                    <div class="p-2" style="background-color: #F9FAFB;">
                        <div class="w-16" style="background-color: #DCFCE7;color:#58C55E">
                            <span style="font-size: 13px;">In Stock</span>
                        </div>
                        <p style="color:#00798C;"
                            class="text-[12px] font-semibold mt-1 text-left md:text-sm lg:text-sm 2xl:text-lg">
                            Premium Roles Watch
                        </p>

                        <p style="font-size:13px;" class="text-left">
                            Category-1
                        </p>

                        <div class="flex mt-1">
                            <p
                                class="text-orange-500 text-[12px] text-left sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : 194.69
                            </p>
                            <p class="ml-4 line-through text-[12px] sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : <span>754.00</span>
                            </p>
                        </div>
                    </div>
                    <p class="ofText">
                        -10 %
                    </p>
                </div>

                <div class="relative slider-item w-full sm:w-full md:w-40">
                    <div class="slide-content">
                        <img class="w-full h-[133px]"
                            src="https://images.unsplash.com/photo-1584208123923-cc027813cbcb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8d29tZW5zJTIwd2F0Y2h8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                            alt="no images">
                    </div>
                    <div class="p-2" style="background-color: #F9FAFB;">
                        <div class="w-16" style="background-color: #DCFCE7;color:#58C55E">
                            <span style="font-size: 13px;">In Stock</span>
                        </div>
                        <p style="color:#00798C;"
                            class="text-xs font-semibold mt-1 text-left md:text-sm lg:text-sm 2xl:text-lg">
                            Premium Roles Watch
                        </p>

                        <p style="font-size:13px;" class="text-left">
                            Category-1
                        </p>

                        <div class="flex mt-1">
                            <p class="text-orange-500 text-xs text-left sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : 19.69
                            </p>
                            <p class="ml-4 line-through text-xs sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : <span>75.00</span>
                            </p>
                        </div>
                    </div>
                    <p class="ofText">
                        -10 %
                    </p>
                </div>

                <div class="relative slider-item w-full sm:w-full md:w-40">
                    <div class="slide-content">
                        <img class="w-full h-[133px]"
                            src="data:image/jpeg;base64,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"
                            alt="no images">
                    </div>
                    <div class="p-2" style="background-color: #F9FAFB;">
                        <div class="w-16" style="background-color: #DCFCE7;color:#58C55E">
                            <span style="font-size: 13px;">In Stock</span>
                        </div>
                        <p style="color:#00798C;"
                            class="text-xs font-semibold mt-1 text-left md:text-sm lg:text-sm 2xl:text-lg">
                            Premium Roles Watch
                        </p>

                        <p style="font-size:13px;" class="text-left">
                            Category-1
                        </p>

                        <div class="flex mt-1">
                            <p class="text-orange-500 text-xs text-left sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : 19.69
                            </p>
                            <p class="ml-4 line-through text-xs sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : <span>75.00</span>
                            </p>
                        </div>
                    </div>
                    <p class="ofText">
                        -10 %
                    </p>
                </div>

                <div class="relative slider-item w-full sm:w-full md:w-40">
                    <div class="slide-content">
                        <img class="w-full h-[133px]" src="{{ asset('images/images.png') }}" alt="no images">
                    </div>
                    <div class="p-2" style="background-color: #F9FAFB;">
                        <div class="w-16" style="background-color: #DCFCE7;color:#58C55E">
                            <span style="font-size: 13px;">In Stock</span>
                        </div>
                        <p style="color:#00798C;"
                            class="text-xs font-semibold mt-1 text-left md:text-sm lg:text-sm 2xl:text-lg">
                            Premium Roles Watch
                        </p>

                        <p style="font-size:13px;" class="text-left">
                            Category-1
                        </p>

                        <div class="flex mt-1">
                            <p class="text-orange-500 text-xs text-left sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : 19.69
                            </p>
                            <p class="ml-4 line-through text-xs sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : <span>75.00</span>
                            </p>
                        </div>
                    </div>
                    <p class="ofText">
                        -10 %
                    </p>
                </div>

                <div class="relative slider-item w-full sm:w-full md:w-40">
                    <div class="slide-content">
                        <img class="w-full h-[133px]" src="{{ asset('images/images.png') }}" alt="no images">
                    </div>
                    <div class="p-2" style="background-color: #F9FAFB;">
                        <div class="w-16" style="background-color: #DCFCE7;color:#58C55E">
                            <span style="font-size: 13px;">In Stock</span>
                        </div>
                        <p style="color:#00798C;"
                            class="text-xs font-semibold mt-1 text-left md:text-sm lg:text-sm 2xl:text-lg">
                            Premium Roles Watch
                        </p>

                        <p style="font-size:13px;" class="text-left">
                            Category-1
                        </p>

                        <div class="flex mt-1">
                            <p class="text-orange-500 text-xs text-left sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : 19.69
                            </p>
                            <p class="ml-4 line-through text-xs sm:text-sm md:text-sm lg:text-sm 2xl:text-lg">
                                Tk : <span>75.00</span>
                            </p>
                        </div>
                    </div>
                    <p class="ofText">
                        -10 %
                    </p>
                </div>

                <!-- Add more slides as needed -->
            </div>

            <button
                style="top: 55%;background-color: #333;color: #fff;padding: 7px 15px;transition: background-color 0.3s;"
                class="absolute left-2 border-0 rounded cursor-pointer md:left-16 lg:left-16 prev-button1">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <button
                style="top: 55%;background-color: #333;color: #fff;padding: 7px 15px;transition: background-color 0.3s;"
                class="absolute right-0 border-0 rounded cursor-pointer md:right-16 lg:right-16 next-button1">
                <i class="fa-solid fa-arrow-right-long"></i>
            </button>
        </div>
    </section>

    {{-- ==============Service Section=================== --}}
    <section class="service-section pt-4 pb-4 hidden sm:hidden md:hidden lg:block xl:block 2xl:block">
        <div class="container">
            <div
                class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4 sm:gap-4 md:gap-4 lg:gap-4 xl:gap-8 2xl:gap-8">
                @foreach ($topBrands as $topBrand)
                    <x-frontend.banner-box type="service" :bg-color="'#fff'" pre-title="" title=""
                        :img-src="$topBrand->img_src" post-title="Shop Now" :post-title-link="route('brand.page', [$topBrand->id, $topBrand->slug])" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==============Service Section for mobile=================== --}}
    <section class="service-section pt-2 pb-2 block sm:block md:block lg:hidden xl:hidden 2xl:hidden">
        <div class="container">
            <div class="grid grid-cols-3 gap-1 sm:gap-1 md:gap-2 lg:gap-4 xl:gap-8 2xl:gap-8 ">
                @foreach ($topBrands as $topBrand)
                    <x-frontend.banner-box type="service" :bg-color="'#fff'" pre-title="" title=""
                        :img-src="$topBrand->img_src" post-title="Shop Now" :post-title-link="route('brand.page', [$topBrand->id, $topBrand->slug])" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================Top Categories============== --}}
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


    {{-- Offers --}}
    <section class="page-section">
        <div class="container">
            <div class="text-center">
                <h1 class="section-title mb-5">Special Offers</h1>
            </div>
            <div class="flex justify-center items-center flex-wrap sm:flex-wrap md:flex-wrap lg:flex-wrap 2xl:flex-wrap">

                <div style="background-color: #00798C"
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
                </div>

                <div style="background-color: #00798C"
                    class="w-32 h-auto m-1 md:w-64 lg:w-64 2xl:w-64 hover:scale-105 transition duration-300 ease-in-out rounded">
                    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-lg">
                        <img class="w-full h-40 object-cover"
                            src="https://images.unsplash.com/photo-1517329782449-810562a4ec2f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8aW1hZ2V8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                            alt="Offer Image">
                        <div class="p-4">
                            <h2 class="text-sm font-semibold text-gray-800 md:text-xl lg:text-xl">Samsaung Galaxy S35</h2>
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
                </div>

                <div style="background-color: #00798C"
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
                </div>

                <div style="background-color: #00798C"
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

                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.slider-container').slick({
                slidesToShow: 4, // Display three slides at a time
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
