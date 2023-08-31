@extends('frontend.layouts.default')

<style>
    .slider-container {
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 10px 12px 10px;
        border-radius: 4px;
        height: 285px;
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
        position: relative;
    }

    .read-more-link {
        color: darkblue;
        font-weight: bold;
    }

    .read-less-link {
        color: darkblue;
        font-weight: bold;
    }
</style>

@section('title', $product->name)
@section('content')

    <section class="page-section page-top-gap">
        <div class="container mx-auto">
            {{-- Show notification --}}
            @if (Session::has('message'))
                <div class="alert mb-8 success">{{ Session::get('message') }}</div>
            @endif

            @if (Session::has('error'))
                <div class="alert mb-8 error">{{ Session::get('error') }}</div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 bg-white">
                <div class="col-span-1 p-2">
                    <div class="hidden md:block aspect-w-1 aspect-h-1 w-full border rounded-md">
                        <div class="absolute top-0 right-0 p-2 z-20">
                            {{-- offer --}}
                            <div class="flex justify-between">
                                <div class="">
                                    @if ($product->offer_price > 0)
                                        <span
                                            class="pt-[2px] px-2 bg-red-500 text-white text-sm text-center inline-block align-middle rounded shadow-md">-
                                            {{ number_format($product->offer_percent, 0) }}
                                            <span>%</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            {{-- end --}}
                        </div>
                        <img id="img-single-product" class="w-full object-cover object-center rounded-md"
                            src="{{ $product->img_src }}">
                    </div>
                    {{-- ======================product single image for mobile============================ --}}
                    <div class="block md:hidden aspect-w-1 aspect-h-1 border rounded-md">
                        <div class="absolute top-0 right-0 p-2 z-20">
                            {{-- offer --}}
                            <div class="flex justify-between">
                                <div class="">
                                    @if ($product->offer_price > 0)
                                        <span
                                            class="pt-[2px] px-2 bg-red-500 text-white text-sm text-center inline-block align-middle rounded shadow-md">-
                                            {{ number_format($product->offer_percent, 0) }}
                                            <span>%</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            {{-- end --}}
                        </div>
                        <img class="w-full h-full p-10 object-cover object-center rounded-md" src="{{ $product->img_src }}">
                    </div>
                </div>
                <div class="col-span-1 p-2 pr-20">
                    <div class="flex justify-between">
                        <div class="">
                            <h1 class="text-lg lg:text-2xl font-medium text-primary-dark mb-2 mt-2">{{ $product->name }}
                            </h1>
                            {{-- show brand form --}}
                            @if ($product->brand)
                                <a href="{{ route('brand.page', $product->brand_id) }}"
                                    class="text-base text-gray-500 block my-2">
                                    {{ $product->brand->name }}
                                </a>
                            @endif
                            {{-- show category --}}
                            {{-- @if ($product->category_id)
                            <div class="text-sm text-gray-600">
                                <a href="{{ route('category.page', $product->category_id) }}">
                                    {{ $product->category->name }}
                                </a>
                            </div>
                        @endif --}}

                            <div class="mt-1 pt-1 pb-1">
                                @if (count($productColors))
                                    <div class="flex mb-2">
                                        <strong>Colors:&nbsp;</strong>&nbsp;
                                        @foreach ($productColors as $color)
                                            <div class="flex items-center mr-4">
                                                <input id="{{ $color->id }}" type="radio" value="{{ $color->id }}"
                                                    name="color_id"
                                                    class="w-4 h-4 bg-gray-100 border-gray-300 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="{{ $color->id }}"
                                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $color->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @if (count($productSizes))
                                    <div class="flex">
                                        <strong>Sizes:&nbsp;</strong>&nbsp;
                                        @foreach ($productSizes as $size)
                                            <div class="flex items-center mr-4">
                                                <input id="{{ $size->id }}" type="radio" value="{{ $size->id }}"
                                                    name="size_id"
                                                    class="w-4 h-4 bg-gray-100 border-gray-300 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="{{ $size->id }}"
                                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $size->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-1">
                        <input type="hidden" value="{{ $product->id }}" id="product-id" style="display: none">
                        <div class="prices flex space-x-2 items-center mb-1">
                            <span class="text-gray-500 text-sm"><strong>Best Price *</strong></span>
                            <span>
                                @if ($product->offer_price > 0)
                                    <span class="text-primary text-xl font-medium">
                                        {{ number_format($product->offer_price, 2) }}
                                    </span>
                                    <span class="line-through text-lg text-gray-500 self-end">
                                        {{ $product->mrp }}
                                    </span>
                                @else
                                    <span class="text-primary text-xl font-medium">
                                        {{ number_format($product->mrp, 2) }}
                                    </span>
                                @endif
                                <span class="ml-1">{{ $currency }}&nbsp;</span>
                            </span>
                        </div>
                        {{-- Extra information --}}
                        <div class="flex justify-between mb-3">
                            <div class="space-y-1">
                                <div class="text-sm text-gray-600">
                                    <span class="font-bold">Warranty : </span>{{ $product->warranty }}
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <div class="flex space-x-4">
                                <div class="flex items-center border rounded border-gray-300" style="height: 32px">
                                    <button id="btn-input-minus" class="w-8 h-8 border-r border-gray-300">
                                        <i class="fa-solid fa-minus text-gray-500"></i>
                                    </button>
                                    <div>
                                        <input id="input-quantity"
                                            class="text-center text-gray-500 border-none focus:outline-none focus:ring-0"
                                            style="width: 45px; height:28px" type="text" name="" value="1"
                                            min="1">
                                    </div>
                                    <button id="btn-input-plush" class="w-8 h-8 border-l border-gray-300">
                                        <i class="fa-solid fa-plus text-gray-500"></i>
                                    </button>
                                </div>

                                <div class="flex space-x-4">
                                    @if ($isWishListed)
                                        <button id="undo-wish-button" type="button" class="h-[36px] bg-white">
                                            <i class="text-4xl text-primary fa-solid fa-heart"></i>
                                        </button>
                                        <button id="wish-button" type="button" class="h-[36px] bg-white hidden"
                                            data-mc-on-previous-url="{{ route('products.show', [$product->id, $product->slug]) }}">
                                            <i class="text-4xl text-primary fa-regular fa-heart"></i>
                                        </button>
                                    @else
                                        <button id="undo-wish-button" type="button" class="h-[36px] bg-white hidden">
                                            <i class="text-4xl text-primary fa-solid fa-heart"></i>
                                        </button>
                                        <button id="wish-button" type="button" class="h-[36px] bg-white"
                                            data-mc-on-previous-url="{{ route('products.show', [$product->id, $product->slug]) }}">
                                            <i class="text-4xl text-primary fa-regular fa-heart"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-2">
                            <div class="flex space-x-4">
                                <div class="flex space-x-4 mt-1">
                                    <button
                                        class="btn-add-to-car h-[36px] bg-[#00798c] text-sm whitespace-nowrap px-4 text-white rounded-md"
                                        data-mc-on-previous-url="{{ url()->current() }}">
                                        <i class="loadding-icon text-sm fa-solid fa-spinner fa-spin"></i>
                                        <i id="add-to-cart-icon" class="fa-solid text-sm fa-cart-plus mr-1"></i>
                                        Add to cart
                                    </button>
                                    <button id="btn-buy-now"
                                        class="h-[36px] bg-[#ffc42d] text-sm whitespace-nowrap px-4 text-white rounded-md"
                                        data-mc-on-previous-url="{{ url()->current() }}">
                                        <i class="loadding-icon text-sm fa-solid fa-spinner fa-spin"></i>
                                        Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                {{-- <div class="border-l col-span-1 sm:col-span-1 md:col-span-2 lg:col-span-1">
                    <h1 class="text-primary-dark text-lg font-medium p-4">Related Product</h1>
                    <hr>
                    <div class="overflow-auto h-[384px] p-2">
                        <div class="">
                            @foreach ($relatedProducts as $rProduct)
                                <div>
                                    <x-frontend.product-thumb type="list" :product="$rProduct" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div> --}}


            </div>

            <div class="grid grid-cols-6 gap-4 mt-10">
                {{-- Description --}}
                <div class="col-span-6 lg:col-span-6 xl:col-span-4">
                    <div class="product-detail mt-3">
                        <div>
                            @if ($product->description)
                                <div class="bg-primary h-10 flex items-center rounded-md">
                                    <h1 class="text-base text-white pl-4">Description</h1>
                                </div>
                            @endif
                            <div class="bg-white mb-4 pt-2 product-description">

                                {{-- if words more than 30,then read more functionalities --}}
                                <div class="description-words-count">
                                    <p class="text-sm text-justify custom-description">
                                        {{-- This code working locally
                                        {!! html_entity_decode($product->description) !!} --}}
                                        {{-- Live Server Code --}}
                                        {{ strip_tags($product->description) }}
                                    </p>
                                </div>

                                {{-- Rating form --}}
                                <div class="mt-5">
                                    <form action="{{ route('ratings.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="flex flex-col">
                                            <div class="flex space-x-2 items-center justify-center">
                                                <div class="rate">
                                                    <input class="ratings" type="radio" id="star5" name="rate"
                                                        value="5" />
                                                    <label for="star5" title="text">5 stars</label>
                                                    <input class="ratings" type="radio" id="star4" name="rate"
                                                        value="4" />
                                                    <label for="star4" title="text">4 stars</label>
                                                    <input class="ratings" type="radio" id="star3" name="rate"
                                                        value="3" />
                                                    <label for="star3" title="text">3 stars</label>
                                                    <input class="ratings" type="radio" id="star2" name="rate"
                                                        value="2" />
                                                    <label for="star2" title="text">2 stars</label>
                                                    <input class="ratings" type="radio" id="star1" name="rate"
                                                        value="1" />
                                                    <label for="star1" title="text">1 star</label>
                                                </div>
                                            </div>
                                            {{-- Hidden input product id --}}
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                                            <label class="text-sm font-medium mt-2" for="">Write your product
                                                comment</label>
                                            <textarea id="input-comment" name="comment"
                                                class="w-full mt-1 focus:outline-none focus:ring-0 text-sm text-gray-500 placeholder:text-gray-400 placeholder:text-sm border-gray-500 rounded"></textarea>
                                            @error('comment')
                                                <span class="text-xs text-red-500">{{ $message }}</span>
                                            @enderror
                                            <label class="text-sm w-full font-medium mt-2" for="">Select your
                                                product images</label>
                                            <input name="files[]" multiple type="file"
                                                class="mt-2 block w-full text-sm text-slate-500
                                            focus:outline-none focus:ring-0
                                            file:mr-4 file:py-2 file:px-8
                                            file:rounded file:border
                                            file:border-primary
                                            file:text-sm file:font-medium
                                            file:bg-violet-50 file:text-primary
                                            hover:file:bg-violet-100"
                                                accept="image/png, image/jpg, image/jpeg" />
                                            <div class="mt-3 w-[33%] md:w-[20%] lg:w-[20%]">
                                                <button id="btn-rating-submit" type="button"
                                                    class="btn btn-block btn-primary">
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                {{-- Show rating --}}
                                @foreach ($ratings as $rating)
                                    <div class="bg-gray-100 mt-5 p-2 rounded">
                                        <div class="w-40 flex justify-between text-md text-base italic">
                                            <span class="text-sm italic">{{ $rating->user->name ?? 'NA' }}</span>
                                            <span class="flex w-3 h-3 space-x-.5 ml-1">
                                                @for ($i = 1; $i <= $rating->rate; $i++)
                                                    <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
                                                @endfor
                                                @for ($j = 5; $j > $rating->rate; $j--)
                                                    <i class="fa-solid fa-star text-xs"></i>
                                                @endfor
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-600 mt-1 mb-1">
                                            {{ $rating->comment }}
                                        </div>
                                        @if (count($rating->ratingImages))
                                            <span class="flex w-14 h-14 space-x-4">
                                                @foreach ($rating->ratingImages as $rImage)
                                                    <img src="{{ $rImage->img_src }}" />
                                                @endforeach
                                            </span>
                                        @endif
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $rating->created_at->format('d/M/Y') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 lg:col-span-6 xl:col-span-2">
                    <h1 class="text-xl font-medium">Ratings & Reviews</h1>
                    <div class="overflow-auto h-[384px] p-2">
                        <div class="border-b last:border-b-0">
                            <div class="flex">
                                <div class="w-20 h-5 p-2 mt-2 items-center justify-items-center">
                                    <div> <span class="text-xl font-bold">{{ number_format($ratingValue, 1) }}</span>
                                        <span class="text-sm">/5</span>
                                    </div>
                                    <div class="text-xs">{{ number_format($ratingPercent, 0) }} % Rating</div>
                                </div>
                                <div class="content px-3 py-2 flex-1 space-y-2">
                                    <div class="space-x-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
                                        @endfor
                                        <span>({{ $ratingReport->five_star ?? 0 }})</span>
                                    </div>
                                    <div class="space-x-1">
                                        @for ($i = 1; $i <= 4; $i++)
                                            <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
                                        @endfor
                                        <i class="fa-regular fa-star text-xs"></i>
                                        <span>({{ $ratingReport->four_star ?? 0 }})</span>
                                    </div>
                                    <div class="space-x-1">
                                        @for ($i = 1; $i <= 3; $i++)
                                            <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
                                        @endfor
                                        @for ($j = 1; $j <= 2; $j++)
                                            <i class="fa-regular fa-star text-xs"></i>
                                        @endfor
                                        <span>({{ $ratingReport->three_star ?? 0 }})</span>
                                    </div>
                                    <div class="space-x-1">
                                        @for ($i = 1; $i <= 2; $i++)
                                            <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
                                        @endfor
                                        @for ($j = 1; $j <= 3; $j++)
                                            <i class="fa-regular fa-star text-xs"></i>
                                        @endfor
                                        <span>({{ $ratingReport->two_star ?? 0 }})</span>
                                    </div>
                                    <div class="space-x-1">
                                        <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
                                        @for ($i = 1; $i <= 4; $i++)
                                            <i class="fa-regular fa-star text-xs"></i>
                                        @endfor
                                        <span>({{ $ratingReport->one_star ?? 0 }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Related Products Section --}}
    <section class="page-section">
        <div class="container relative">
            <div class="text-center">
                <h1 class="section-title mb-5">Related Product</h1>
            </div>

            @if (count($relatedProducts) > 5)
                <div class="slider-container">

                    @foreach ($relatedProducts as $rProduct)
                        <div style="margin: 5px 5px 5px;">
                            <a href="{{ route('products.show', [$rProduct->id, $rProduct->slug]) }}">
                                <img class="w-full h-[136px]" src="{{ $rProduct->img_src }}" alt="no images">
                            </a>

                            <div class="p-2 h-[120px]" style="background-color: #F9FAFB;">
                                <div class="w-12 rounded" style="background-color: #DCFCE7;color:#58C55E">
                                    <span style="font-size: 10px;">In Stock</span>
                                </div>
                                <p style="color:#00798C;"
                                    class="text-[12px] font-semibold mt-1 text-left md:text-[12px] lg:text-[12px] 2xl:text-lg">

                                    @if ($rProduct->name)
                                        <a href="{{ route('products.show', [$rProduct->id, $rProduct->slug]) }}">
                                            {{ $rProduct->name }}
                                        </a>
                                    @else
                                        <div class="h-5"></div>
                                    @endif
                                </p>

                                <p class="text-left text-[11px] md:text-[12px] lg:text-[12px] 2xl:text-lg">
                                    <a
                                        href="{{ route('category.page', [$product->category_id, $product->category->slug ?? '']) }}">
                                        {{ $rProduct->category->name ?? '' }}
                                    </a>
                                </p>

                                <div class="flex mt-1">
                                    @if ($rProduct->offer_price > 0)
                                        <p
                                            class="text-orange-500 text-[12px] text-left sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                            TK : {{ $rProduct->offer_price }}
                                        </p>
                                        <p
                                            class="ml-4 line-through text-[12px] sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                            TK : <span>{{ $rProduct->mrp }}</span>
                                        </p>
                                    @else
                                        <p class="text-[12px] sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                            TK : <span>{{ $rProduct->mrp }}</span>
                                        </p>
                                    @endif

                                </div>

                                @if ($rProduct->offer_price > 0)
                                    <p class="ofText">
                                        {{ $rProduct->offer_percent }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Add more slides as needed -->

                </div>

                <button
                    style="top: 55%;background-color: #333;color: #fff;padding: 7px 15px;transition: background-color 0.3s;"
                    class="absolute left-2 border-0 rounded cursor-pointer md:left-12 lg:left-16 prev-button2">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <button
                    style="top: 55%;background-color: #333;color: #fff;padding: 7px 15px;transition: background-color 0.3s;"
                    class="absolute right-0 border-0 rounded cursor-pointer md:right-12 lg:right-16 next-button2">
                    <i class="fa-solid fa-arrow-right-long"></i>
                </button>
            @else
                <div class="flex justify-around flex-wrap">
                    @foreach ($relatedProducts as $rProduct)
                        <div class="w-[150px] m-2 shadow-md relative md:w-[250px] lg:w-[250px] 2xl:w-[250px]">
                            <a href="{{ route('products.show', [$rProduct->id, $rProduct->slug]) }}">
                                <img class="w-full h-[150px] md:h-[205px] lg:h-[205px]" src="{{ $rProduct->img_src }}"
                                    alt="no images">
                            </a>

                            <div class="p-2 h-[120px]" style="background-color: #F9FAFB;">
                                <div class="w-12 rounded" style="background-color: #DCFCE7;color:#58C55E">
                                    <span style="font-size: 10px;">In Stock</span>
                                </div>
                                <p style="color:#00798C;"
                                    class="text-[12px] font-semibold mt-1 text-left capitalize md:text-[12px] lg:text-[12px] 2xl:text-lg">
                                    @if ($rProduct->name)
                                        <a href="{{ route('products.show', [$rProduct->id, $rProduct->slug]) }}">
                                            {{ $rProduct->name }}
                                        </a>
                                    @else
                                        <div class="h-5">Unnamed</div>
                                    @endif
                                </p>

                                <p class="text-left text-[11px] capitalize md:text-[12px] lg:text-[12px] 2xl:text-lg">
                                    <a
                                        href="{{ route('category.page', [$product->category_id, $product->category->slug ?? '']) }}">
                                        {{ $rProduct->category->name ?? '' }}
                                    </a>
                                </p>

                                <div class="flex mt-1">
                                    @if ($rProduct->offer_price > 0)
                                        <p
                                            class="text-orange-500 text-[12px] text-left sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                            TK : {{ $rProduct->offer_price }}
                                        </p>
                                        <p
                                            class="ml-4 line-through text-[12px] sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                            TK : <span>{{ $rProduct->mrp }}</span>
                                        </p>
                                    @else
                                        <p class="text-[12px] sm:text-[10px] md:text-sm lg:text-sm 2xl:text-lg">
                                            TK : <span>{{ $rProduct->mrp }}</span>
                                        </p>
                                    @endif

                                </div>

                                @if ($rProduct->offer_price > 0)
                                    <p class="ofText">
                                        10.00
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif



        </div>
    </section>
@endsection

@push('scripts')
    {{-- jquery image zoom plugin --}}
    <script type="text/javascript" src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js">
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <!-- Include Slick Slider Theme CSS (optional) -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- Include Slick Slider JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.slider-container').slick({
                slidesToShow: 5, // Display three slides at a time
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

    {{-- Description words more 30,then the function will be call --}}
    <script>
        $(document).ready(function() {
            var descriptionWordCount = $('.description-words-count');
            var description = descriptionWordCount.find('.custom-description');
            var fullDescription = description.html().trim();

            var maxWords = 30;

            function updateDescription() {
                var words = fullDescription.split(/\s+/);

                if (words.length > maxWords) {
                    var shortDescription = words.slice(0, maxWords).join(' ');
                    var remainingWords = words.slice(maxWords).join(' ');

                    var content = shortDescription + ' ... ';
                    var readMoreLink = $('<a href="#" class="read-more-link">Read more</a>');

                    description.html(content).append(readMoreLink);

                    readMoreLink.on('click', function(e) {
                        e.preventDefault();
                        description.html(fullDescription +
                            ' <a href="#" class="read-less-link">...Read less</a>');
                    });
                }
            }

            updateDescription();

            descriptionWordCount.on('click', '.read-less-link', function(e) {
                e.preventDefault();
                updateDescription();
            });
        });
    </script>

    <script>
        // jquery image zoom plugin id
        $("#img-single-product").ezPlus({
            borderSize: 1,
            borderColour: '#e5e7eb',
            scrollZoom: true,
            tint: true,
            tintColour: '#EBECF0',
            tintOpacity: 0.5,
            cursor: 'crosshair',
            easing: true,
        });

        var cartAddItemEndPoint = '/cart/items/add';
        var btnAddToCart = $('.btn-add-to-car');
        var btnBuyNow = $('#btn-buy-now');
        var productId = $('#product-id').val();
        var inputQuantity = $('#input-quantity');
        var iconLoadding = $('.loadding-icon').hide();
        var iconAddToCart = $('#add-to-cart-icon');
        var wishButton = $('#wish-button');
        var undoWishButton = $('#undo-wish-button');
        var authUserId = "{{ Auth::id() }}";
        var productColorsCount = {{ count($productColors) }};
        var productSizesCount = {{ count($productSizes) }};
        var productCurrentStock = "{{ $product->current_stock }}";

        if (productCurrentStock == 0) {
            btnAddToCart.prop("disabled", true);
            btnAddToCart.addClass('disabled:opacity-50');
            btnAddToCart.text('Out of Stock');
        }

        @auth
        // Automatically product added to wishcart if local storage have wish_product_id
        var wishStorageProductID = localStorage.getItem('wish_product_id');
        if (wishStorageProductID) {
            addWishlist(wishStorageProductID);
            localStorage.removeItem('wish_product_id');
        }
        @endauth

        @guest
        authUserId = null;
        @endguest

        $(function() {
            // Add product to cart
            btnAddToCart.click(function() {
                if (!authUserId) {
                    __showNotification('error', 'Please login to continue');
                    return false;
                }

                var quantity = inputQuantity.val();
                var colorId = $('input[name="color_id"]:checked').val();
                var sizeId = $('input[name="size_id"]:checked').val();

                if (productColorsCount > 0 && !colorId) {
                    __showNotification('error', 'Please select color');
                    return false;
                }

                if (productSizesCount > 0 && !sizeId) {
                    __showNotification('error', 'Please select size');
                    return false;
                }

                if (productId != 0 && quantity != 0) {
                    addCartItem(productId, quantity, colorId, sizeId, $(this));
                }
            });

            $('#btn-buy-now').click(function() {
                if (!authUserId) {
                    __showNotification('error', 'Please login to continue');
                    return false;
                }

                var quantity = inputQuantity.val();
                var colorId = $('input[name="color_id"]:checked').val();
                var sizeId = $('input[name="size_id"]:checked').val();

                if (productColorsCount > 0 && !colorId) {
                    __showNotification('error', 'Please select color');
                    return false;
                }

                if (productSizesCount > 0 && !sizeId) {
                    __showNotification('error', 'Please select size');
                    return false;
                }

                if (productId != 0 && quantity != 0) {
                    addCartItem(productId, quantity, colorId, sizeId, $(this));
                }

                // Redirect checkout page
                window.location.href = "/checkout";
            });

            // Add event with wishlist button
            wishButton.click(function() {
                if (!authUserId) {
                    localStorage.setItem('wish_product_id', productId);
                } else {
                    addWishlist(productId);
                }
            });

            undoWishButton.click(function() {
                if (authUserId) {
                    undoWishList(productId);
                }
            });
        });

        function addCartItem(productId, productQty, colorId = null, sizeId = null, btn = null) {
            if (btn) {
                btn.prop("disabled", true);
            }
            // iconLoadding.show();
            // iconAddToCart.hide();

            btn.find(iconLoadding).show();
            btn.find(iconAddToCart).hide();

            axios.post(cartAddItemEndPoint, {
                    item_id: productId,
                    quantity: productQty,
                    color_id: colorId,
                    size_id: sizeId,
                })
                .then((response) => {
                    if (response.data.success) {
                        btn.find(iconLoadding).hide();
                        if (btn) {
                            btn.prop("disabled", false);
                        }
                        __cartItemCount();
                    } else {
                        __showNotification('error', response.data.msg);
                        // iconLoadding.hide();
                        // iconAddToCart.show();
                        btn.find(iconLoadding).hide();
                        btn.find(iconAddToCart).show();
                        if (btn) {
                            btn.prop("disabled", false);
                        }
                        return false;
                    }
                })
                .catch((error) => {
                    if (btn) {
                        btn.prop("disabled", false);
                    }
                    // iconLoadding.hide();
                    btn.find(iconLoadding).hide();
                    console.log(error);
                });
        }

        function addWishlist(productId) {
            axios.post('/my/wishlist', {
                    product_id: productId
                })
                .then((response) => {
                    wishButton.hide();
                    undoWishButton.show();
                })
                .catch((error) => {

                });
        }

        function undoWishList(productId) {
            axios.get('/my/wishlist/undo', {
                    params: {
                        product_id: productId
                    }
                })
                .then(function(response) {
                    wishButton.show();
                    undoWishButton.hide();
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    </script>

    {{-- input quantity script --}}
    <script>
        var btnInputPlush = $('#btn-input-plush');
        var btnInputMinus = $('#btn-input-minus');

        $(function() {
            btnInputPlush.click(function() {
                var quantity = inputQuantity.val();
                quantity++;
                inputQuantity.val(quantity)
            });

            btnInputMinus.click(function() {
                var quantity = inputQuantity.val();
                if (quantity > 1) {
                    quantity--;
                    inputQuantity.val(quantity)
                }
            });
        })
    </script>

    {{-- Order ratting script --}}
    <script>
        var btnRatingSubmit = $('#btn-rating-submit');
        var ratings = $('.ratings');
        var ratingsCount = 0;

        // Set time to flash message
        setTimeout(function() {
            $("div.alert").remove();
        }, 4000);

        $(() => {
            // Event with change starts
            ratings.change(function(e1) {
                var ratings = $(e1.target).val();
                ratingsCount = ratings;
            });

            btnRatingSubmit.click(function() {
                var productId = $("input[name=product_id]").val();
                var comment = $("#input-comment").val();
                var imagefile = document.querySelector('#files');

                if (ratingsCount == 0) {
                    __showNotification('error', 'please select star', 3000);
                    return false;
                }

                if (!comment) {
                    __showNotification('error', 'please write your comment', 3000);
                    return false;
                }

                $('form').submit();
            });
        });
    </script>
@endpush
