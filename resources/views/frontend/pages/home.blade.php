@extends('frontend.layouts.default')
@section('title', 'Home')

@section('content')
    {{-- ==============Banner Slider========================= --}}
    <section class="mt-[140px] sm:mt-[140px] md:mt-[140px] lg:mt-44">
        <div id="carouselExampleIndicators" class="carousel slide relative" data-bs-ride="carousel">
            <div class="carousel-indicators absolute right-0 bottom-0 left-0 flex justify-center p-0 mb-0 md:mb-4">
                <button
                    type="button"
                    data-bs-target="#carouselExampleIndicators"
                    data-bs-slide-to="0"
                    class="active"
                    aria-current="true">
                </button>
                @for ($i=1; $i<count($sliderBanners); $i++)
                    <button
                        type="button"
                        data-bs-target="#carouselExampleIndicators"
                        class=""
                        data-bs-slide-to="{{ $i }}">
                    </button>
                @endfor
            </div>
            @if(count($sliderBanners) > 0)
            <div class="carousel-inner relative w-full overflow-hidden">
                <div class="carousel-item active float-left w-full">
                    <img
                        src="{{ $sliderBanners[0]->img_src }}"
                        class="hidden sm:hidden md:block w-full"
                        alt="Medicart Banner"
                    />
                    <img
                        src="{{ $sliderBanners[0]->mobile_img_src }}"
                        class="w-full block sm:block md:hidden"
                        alt="Medicart Banner"
                    />
                </div>
                @for ($i=1; $i<count($sliderBanners); $i++)
                    <div class="carousel-item float-left w-full">
                            <img
                                src="{{ $sliderBanners[$i]->img_src }}"
                                class="hidden sm:hidden md:block w-full"
                                alt="Medicart Banner"
                            />
                            <img
                                src="{{ $sliderBanners[$i]->mobile_img_src }}"
                                class="block sm:block md:hidden w-full"
                                alt="Medicart Banner"
                            />
                    </div>
                @endfor
            </div>
            @endif
            <button
                class="carousel-control-prev absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline left-0"
                type="button"
                data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev"
            >
                <span class="carousel-control-prev-icon inline-block bg-no-repeat" aria-hidden="false"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button
                class="carousel-control-next absolute top-0 bottom-0 flex items-center justify-center p-0 text-center border-0 hover:outline-none hover:no-underline focus:outline-none focus:no-underline right-0"
                type="button"
                data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next"
            >
                <span class="carousel-control-next-icon inline-block bg-no-repeat" aria-hidden="false"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    {{-- ==============Brand Section=================== --}}
    <section class="brand-section pt-4 pb-4 hidden sm:hidden md:hidden lg:block xl:block 2xl:block">
        <div class="container">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4 sm:gap-4 md:gap-4 lg:gap-4 xl:gap-8 2xl:gap-8">
                @foreach ($brands as $brand)
                    <x-frontend.banner-box
                        type="brand"
                        :bg-color="'#fff'"
                        pre-title=""
                        :title="$brand->name"
                        :img-src="$brand->img_src"
                        post-title="Buy Now"
                        :post-title-link="route('brand.page', [$brand->id, $brand->slug])"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==============Brand Section for mobile=================== --}}
    <section class="brand-section pt-4 pb-4 block sm:block md:block lg:hidden xl:hidden 2xl:hidden">
        <div class="container">
            <div class="grid grid-cols-3 gap-1 sm:gap-1 md:gap-2 lg:gap-4 xl:gap-8 2xl:gap-8 ">
                 @foreach ($brands as $brand)
                    <x-frontend.banner-box
                        type="brand-card"
                        :bg-color="'#fff'"
                        pre-title=""
                        :title="$brand->name"
                        :img-src="$brand->img_src"
                        post-title="Buy Now"
                        :post-title-link="route('brand.page', [$brand->id, $brand->slug])"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================Top Products================== --}}
    @if ($topProducts)
        <section class="page-section">
            <div class="container">
                <div class="text-center">
                    <h1 class="section-title mb-10">{{ $topProducts->title }}</h1> 
                </div>
                <div class="product-grid grid gap-2 grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-5 2xl:grid-cols-6">
                    @foreach ($topProducts->products as $product)
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

    {{-- ==============Symptoms Section=================== --}}
    {{-- <section class="symptoms-section page-section bg-gray-100">
        <div class="container">
            <div class="headline text-center">
                <h1 class="section-title"> All Category</h1>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-1 sm:gap-1 md:gap-2 lg:gap-4 xl:gap-4 2xl:gap-4 mt-10">
                @foreach ( $categories as $category)
                    <a href="{{ route('category.page', [$category->id, $category->slug]) }}" class="img-wrapper">
                        <img class="img" src="{{ $category->img_src }}">
                    </a>
                @endforeach
            </div>
        </div>
    </section> --}}

    <section class="page-section bg-gray-100">
        <div class="container">
            <div class="text-center">
                <h1 class="section-title mb-10">All Category</h1>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 xl:grid-cols-6 2xl:grid-cols-6 gap-2 sm:gap-2 md:gap-2 lg:gap-4 xl:gap-4 2xl:gap-4">
                @foreach ($categories as $category)
                    <x-frontend.banner-box
                        type="categories-banner"
                        :bg-color="'#fff'"
                        pre-title=""
                        :title="$category->name"
                        link-title=""
                        :post-title-link="route('category.page', [$category->id, $category->slug])"
                        :img-src="$category->img_src"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================Medical Devices================== --}}
    <section class="page-section">
        <div class="container">
            <div class="text-center">
                <h1 class="section-title mb-10">{{ $medicalProducts->title ?? '' }}</h1>
            </div>
            <div class="product-grid grid gap-2 grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-6">
                @foreach ($medicalProducts->products as $product)
                    <div data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                        <x-frontend.product-thumb type="default" :product="$product" />
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('category.page', ['medical-devices']) }}" class="btn btn-md btn-primary">Browse All Products</a>
            </div>
        </div>
    </section>

    {{-- ==================Hot Sale=============== --}}
    <section class="page-section bg-gray-100">
        <div class="container">
            <div class="headline text-center">
                <h1 class="section-title">Offers</h1>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 sm:gap-2 md:gap-4 lg:gap-4 xl:gap-4 2xl:gap-8 mt-10">
                @foreach ($hotSales as $hotSale)
                <div class="">
                    <x-frontend.banner-box
                        type="default"
                        :bg-color="$hotSale->bg_color"
                        pre-title=""
                        :title="$hotSale->title"
                        :link-title="$hotSale->post_title"
                        :link="$hotSale->box_link"
                        :img-src="$hotSale->img_src"
                    />
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- =======================Top Categories========================== --}}
    <section class="page-section bg-gray-100">
        <div class="container">
            <div class="text-center">
                <h1 class="section-title mb-10">Top Categories</h1>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 xl:grid-cols-6 2xl:grid-cols-6 gap-2 sm:gap-2 md:gap-2 lg:gap-4 xl:gap-4 2xl:gap-4">
                @foreach ($topCategories as $tCategory)
                    <x-frontend.banner-box
                        type="categories-banner"
                        :bg-color="'#fff'"
                        pre-title=""
                        :title="$tCategory->name"
                        link-title=""
                        :post-title-link="route('category.page', [$tCategory->id, $tCategory->slug])"
                        :img-src="$tCategory->img_src"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- =======================Top Brands========================== --}}
    {{-- <section class="page-section">
        <div class="container">
            <div class="text-center">
                <h1 class="section-title mb-10">Top Brands</h1>
            </div>
            <div class="flex flex-row items-center justify-center flex-wrap gap-2 sm:gap-2 md:gap-4">
                @foreach ($brands as $brand)
                    <x-frontend.banner-box
                        type="brands-banner"
                        :bg-color="'#fff'"
                        pre-title=""
                        title=""
                        link-title=""
                        :link="$brand->box_link"
                        :img-src="$brand->img_src"
                    />
                @endforeach
            </div>
        </div>
    </section> --}}

    {{-- ==================Features================== --}}
    {{-- <section class="page-section bg-gray-100">
        <div class="container">
            <div class="grid gap-4 grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="">
                        <div class="flex space-x-4 items-center justify-center">
                            <div class="">
                                <i class="text-3xl sm:text-3xl md:text-5xl lg:text-5xl xl:text-5xl 2xl:text-5xl text-primary-dark fa-solid {{ $feature['icon'] }}"></i>
                            </div>
                            <div class="self-center">
                                <h1 class="text-lg sm:tex-lg md:text-xl lg:text-xl xl:text-xl 2xl:text-xl font-medium text-gray-900">{{ $feature['title'] }}</h1>
                                <div class="text-gray-800">{{ $feature['postTitle'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section> --}}

@endsection
@push('scripts')
<script>
    AOS.init();
    // Category Menu for Medicine Corner
    function toggleCategory() {
        var categoryList = document.getElementById('category-list');
        if(categoryList.style.display == "none") { // if is menuBox displayed, hide it
            categoryList.style.display = "block";
        }
        else { // if is menuBox hidden, display it
            categoryList.style.display = "none";
        }
    }
</script>
@endpush
