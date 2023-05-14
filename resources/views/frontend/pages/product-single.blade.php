@extends('frontend.layouts.default')
@section('title', $product->name)
@section('content')

<section class="page-section page-top-gap">
    <div class="container mx-auto">
        {{-- Show notification --}}
        @if(Session::has('message'))
        <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif

        @if(Session::has('error'))
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
                                    <span class="pt-[2px] px-2 bg-red-500 text-white text-sm text-center inline-block align-middle rounded shadow-md">-
                                        {{ (number_format($product->offer_percent, 0)) }}
                                        <span>%</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{-- end --}}
                    </div>
                    <img id="img-single-product" class="w-full object-cover object-center rounded-md" src="{{ $product->image_src }}">
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
                                        {{ (number_format($product->offer_percent, 0)) }}
                                        <span>%</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{-- end --}}
                    </div>
                    <img class="w-full h-full p-10 object-cover object-center rounded-md" src="{{ $product->image_src }}">
               </div>
            </div>
            <div class="col-span-1 p-2 pr-20">
                <div class="flex justify-between">
                    <div class="">
                        <h1 class="text-lg lg:text-2xl font-medium text-primary-dark mb-2 mt-2">{{ $product->name }}</h1>
                        {{-- show brand form --}}
                        @if ($product->brand)
                            <a href="{{ route('brand.page', $product->brand_id) }}" class="text-base text-gray-500 block my-2">
                                {{ $product->brand->name }}
                            </a>
                        @endif
                        {{-- show category --}}
                        @if ($product->category_id)
                            <div class="text-sm text-gray-600">
                                <a href="{{ route('category.page', $product->category_id) }}">
                                    {{ $product->category->name }}
                                </a>
                            </div>
                        @endif

                       <div class="mt-1 pt-1 pb-1">
                            @if (count($productColors))
                                <div class="flex mb-2">
                                    <strong>Colors:&nbsp;</strong>&nbsp;
                                    @foreach ($productColors as $color)
                                        <div class="flex items-center mr-4">
                                            <input id="{{ $color->id }}" type="radio" value="{{ $color->id }}" name="color_id" class="w-4 h-4 bg-gray-100 border-gray-300 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="{{ $color->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $color->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if (count($productSizes))
                            <div class="flex">
                                <strong>Sizes:&nbsp;</strong>&nbsp;
                                @foreach ($productSizes as $size)
                                    <div class="flex items-center mr-4">
                                        <input id="{{ $size->id }}" type="radio" value="{{ $size->id }}" name="size_id" class="w-4 h-4 bg-gray-100 border-gray-300 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="{{ $size->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $size->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                       </div>
                    </div>
                </div>

                <div class="mt-1">
                    <div class="hidden">
                        <input type="hidden" value="{{ $product->id }}" id="product-id" style="display: none">
                        @if ($product->offer_price > 0)
                            @php
                                $sellPrice = $product->offer_price;
                            @endphp
                            <input type="hidden" value="{{ $sellPrice }}" id="input-price">
                        @else
                            <input type="hidden" value="{{ $product->price }}" id="input-price">
                        @endif
                        <input type="hidden" value="{{ $product->price }}" id="input-product-mrp">
                    </div>
                    <div class="prices flex space-x-2 items-center mb-1">
                        <span class="text-gray-500 text-sm"><strong>Best Price *</strong></span>
                        <span>
                            <span>{{ $currency }}&nbsp;</span>
                            @if ($product->offer_price > 0)
                                <span id="item-price-label" class="text-primary text-md font-medium">
                                    {{ number_format(($product->offer_price), 2) }}
                                </span>
                                <span id="item-mrp-label" class="line-through text-sm text-gray-500 self-end">
                                    {{ $product->price }}
                                </span>
                            @else
                                <span id="item-price-label" class="text-primary text-xl font-medium">
                                    {{ number_format(($product->price), 2) }}
                                </span>
                                <span id="item-mrp-label" class="line-through text-primary text-xl font-medium">
                                </span>
                            @endif
                        </span>
                    </div>
                    {{-- Extra information --}}
                    <div class="flex justify-between mb-3">
                        <div class="space-y-1">
                            <div class="text-sm text-gray-600">
                                <span class="font-bold">Warranty : </span>12 Months Official Warranty
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-bold">Emi Available : </span>3 Months
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col space-y-2">
                        <div class="flex space-x-4">
                            <select class="selected-pack-single w-32 rounded-md py-1.5 text-sm" id="input-qty">
                                @for ($i = 1 ; $i <= 5 ; $i++)
                                    <option value="{{ $i }}">{{ $i }} </option>
                                @endfor
                            </select>
                            <div class="flex space-x-4">
                                <button class="btn-add-to-car h-[36px] bg-[#00798c] text-sm whitespace-nowrap px-4 text-white rounded-md"
                                    data-mc-on-previous-url="{{ url()->current() }}"
                                    @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                                    <i class="loadding-icon text-sm fa-solid fa-spinner fa-spin"></i>
                                    <i id="add-to-cart-icon" class="fa-solid text-sm fa-cart-plus mr-1"></i>
                                    Add to cart
                                </button>
                                @if ($isWishListed)
                                    <button id="undo-wish-button" type="button" class="h-[36px] bg-white">
                                        <i class="text-4xl text-primary fa-solid fa-heart"></i>
                                    </button>
                                    <button id="wish-button" type="button" class="h-[36px] bg-white hidden"
                                        data-mc-on-previous-url="{{ route('products.show', [$product->id, $product->slug]) }}"
                                        @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                                        <i class="text-4xl text-primary fa-regular fa-heart"></i>
                                    </button>
                                @else
                                    <button id="undo-wish-button" type="button" class="h-[36px] bg-white hidden">
                                        <i class="text-4xl text-primary fa-solid fa-heart"></i>
                                    </button>
                                    <button id="wish-button" type="button" class="h-[36px] bg-white"
                                        data-mc-on-previous-url="{{ route('products.show', [$product->id, $product->slug]) }}"
                                        @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest>
                                        <i class="text-4xl text-primary fa-regular fa-heart"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-l col-span-1 sm:col-span-1 md:col-span-2 lg:col-span-1">
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
            </div>
        </div>

        <div class="grid grid-cols-6 gap-4 mt-10">
            {{-- Description --}}
            <div class="col-span-6 lg:col-span-6 xl:col-span-4">
                @if ($product->description)
                <div class="product-detail mt-3">
                    <div>
                        <div class="bg-primary h-10 flex items-center rounded-md">
                            <h1 class="text-base text-white pl-4">Description</h1>
                        </div>
                        <div class="bg-white mb-4 p-4 product-description">
                            <p class="text-sm">
                                {!! html_entity_decode($product->description) !!}
                            </p>
                            {{-- Rating form --}}
                            <div class="mt-5">
                                <form action="{{ route('ratings.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex flex-col">
                                        <div class="flex space-x-2 items-center justify-center">
                                            <div class="rate">
                                                <input class="ratings" type="radio" id="star5" name="rate" value="5" />
                                                <label for="star5" title="text">5 stars</label>
                                                <input class="ratings" type="radio" id="star4" name="rate" value="4" />
                                                <label for="star4" title="text">4 stars</label>
                                                <input class="ratings" type="radio" id="star3" name="rate" value="3" />
                                                <label for="star3" title="text">3 stars</label>
                                                <input class="ratings" type="radio" id="star2" name="rate" value="2" />
                                                <label for="star2" title="text">2 stars</label>
                                                <input class="ratings" type="radio" id="star1" name="rate" value="1" />
                                                <label for="star1" title="text">1 star</label>
                                            </div>
                                        </div>
                                        {{-- Hidden input product id --}}
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <label class="text-sm font-medium mt-2" for="">Write your product comment</label>
                                        <textarea id = "input-comment" name="comment" class="w-full mt-1 focus:outline-none focus:ring-0 text-sm text-gray-500 placeholder:text-gray-400 placeholder:text-sm border-gray-500 rounded"></textarea>
                                        @error('comment')
                                            <span class="text-xs text-red-500">{{ $message }}</span>
                                        @enderror
                                        <label class="text-sm w-full font-medium mt-2" for="">Select your product images</label>
                                        <input name="files[]" multiple type="file"
                                            class="mt-2 block w-full text-sm text-slate-500
                                            focus:outline-none focus:ring-0
                                            file:mr-4 file:py-2 file:px-8
                                            file:rounded file:border
                                            file:border-primary
                                            file:text-sm file:font-medium
                                            file:bg-violet-50 file:text-primary
                                            hover:file:bg-violet-100"
                                            accept="image/png, image/jpg, image/jpeg"
                                        />
                                        <div class="mt-3 w-full">
                                            <button id="btn-rating-submit" type="button" class="btn btn-block btn-primary">
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
                @endif
            </div>
            <div class="col-span-6 lg:col-span-6 xl:col-span-2">
                <h1 class="text-xl font-medium">Ratings & Reviews</h1>
                <div class="overflow-auto h-[384px] p-2">
                    <div class="border-b last:border-b-0">
                        <div class="flex">
                            <div class="w-20 h-5 p-2 mt-2 items-center justify-items-center">
                                <div> <span class="text-xl font-bold">{{ number_format($ratingValue, 1) }}</span> <span
                                        class="text-sm">/5</span></div>
                                <div class="text-xs">{{ number_format($ratingPercent, 0) }} % Rating</div>
                            </div>
                            <div class="content px-3 py-2 flex-1 space-y-2">
                                <div class="space-x-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
                                    @endfor
                                    <span>{{ $ratingReport->five_star }}</span>
                                </div>
                                <div class="space-x-1">
                                    @for ($i = 1; $i <= 4; $i++)
                                        <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
                                    @endfor
                                        <i class="fa-solid fa-star text-xs"></i>
                                    <span>{{ $ratingReport->four_star }}</span>
                                </div>
                                <div class="space-x-1">
                                    @for ($i = 1; $i <= 3; $i++)
                                        <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
                                    @endfor
                                    @for ($j = 1; $j <= 2; $j++)
                                        <i class="fa-solid fa-star text-xs"></i>
                                    @endfor
                                    <span>{{ $ratingReport->three_star }}</span>
                                </div>
                                <div class="space-x-1">
                                    @for ($i = 1; $i <= 2; $i++)
                                        <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
                                    @endfor
                                    @for ($j = 1; $j <= 3; $j++)
                                        <i class="fa-solid fa-star text-xs"></i>
                                    @endfor
                                    <span>{{ $ratingReport->two_star }}</span>
                                </div>
                                <div class="space-x-1">
                                    <i class="fa-solid fa-star text-yellow-500 text-xs"></i>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <i class="fa-solid fa-star text-xs"></i>
                                    @endfor
                                    <span>{{ $ratingReport->one_star }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
{{-- jquery image zoom plugin --}}
<script type="text/javascript" src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script>

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

    var aleartTime          = {{ config("crud.alear_time") }};
    var cartAddItemEndPoint = '/cart/item/add';
    var btnAddToCart        = $('.btn-add-to-car');
    var productID           = $('#product-id').val();
    var selectedPackSingle  = $('.selected-pack-single');
    var priceLabel          = $('#item-price-label');
    var itemMRPLabel        = $('#item-mrp-label');
    var inputPrice          = $('#input-price');
    var inputProductMRP     = $('#input-product-mrp');
    var inputQty            = $('#input-qty');
    var iconLoadding        = $('.loadding-icon');
    var iconAddToCart       = $('#add-to-cart-icon');
    var wishButton          = $('#wish-button');
    var undoWishButton      = $('#undo-wish-button');
    var packQtyLavel        = $('#pack-quantity-label');
    var sUserID             = "{{ Auth::id() }}";
    var productColorsCount  = {{ count($productColors) }};
    var productSizesCount   = {{ count($productSizes) }};
    var productStock        = "{{ $product->current_stock }}";

    if (productStock == 0) {
        btnAddToCart.prop("disabled",true);
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
        sUserID = null;
    @endguest

    // initially hide loading icon
    iconLoadding.hide();

    $(function() {
        selectedPackSingle.on('change', function() {
            var productQty        = inputQty.val();
            var productPrice      = inputPrice.val();
            var productMRP        = inputProductMRP.val();
            var totalPrice        = 0;
            var totalMRP          = 0;

            totalPrice = parseFloat(productQty * productPrice);
            totalMRP   = parseFloat(productQty * productMRP);

            if (totalPrice) {
                var packNameLavel = inputQty.find(":selected").text();
                packQtyLavel.text(packNameLavel);
                priceLabel.text(totalPrice.toFixed(2));
            }
            if (totalMRP !== totalPrice) {
                itemMRPLabel.text(totalMRP.toFixed(2));
            }
        });

        // Add product to cart
        btnAddToCart.click(function () {
            var productQty = inputQty.val();
            var colorId    = $('input[name="color_id"]:checked').val();
            var sizeId     = $('input[name="size_id"]:checked').val();

            if (productColorsCount > 0 && !colorId) {
                __showNotification('error', 'Please select color', aleartTime);
                return false;
            }

            if (productSizesCount > 0 && !sizeId) {
                __showNotification('error', 'Please select size', aleartTime);
                return false;
            }

            if (productID != 0 && productQty != 0) {
                addCartItem(productID, productQty, colorId, sizeId, $(this));
            }
        });

        // Add event with wishlist button
        wishButton.click(function () {
            if (!sUserID) {
                localStorage.setItem('wish_product_id', productID);
            } else {
                addWishlist(productID);
            }
        });

        undoWishButton.click(function () {
            if (sUserID) {
                undoWishList(productID);
            }
        });
    });

    function addCartItem(productID, productQty, colorId = null, sizeId = null, btn = null) {
        if (btn) {
            btn.prop("disabled", true);
        }
        iconLoadding.show();
        iconAddToCart.hide();

        axios.post(cartAddItemEndPoint, {
            item_id: productID,
            quantity: productQty,
            color_id: colorId,
            size_id: sizeId,
        })
        .then((response) => {
            if (response.data.res) {
                // __totalPriceCalculation();
            } else {
                __showNotification('error', response.data.message, 1000);
                iconLoadding.hide();
                iconAddToCart.show();
                if (btn) {
                    btn.prop("disabled", false);
                }
                return false;
            }
            iconLoadding.hide();
            if (btn) {
                btn.prop("disabled", false);
            }
            __cartItemCount();
        })
        .catch((error) => {
            if (btn) {
                btn.prop("disabled", false);
            }
            iconLoadding.hide();
            console.log(error);
        });
    }

    function addWishlist(productID) {
        axios.post('/my/wishlist', {
            product_id: productID
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
                product_id: productID
            }
        })
        .then(function (response) {
            wishButton.show();
            undoWishButton.hide();
        })
        .catch(function (error) {
            console.log(error);
        });
    }
</script>

{{-- Order ratting script --}}
<script>
    var btnRatingSubmit = $('#btn-rating-submit');
    var ratings = $('.ratings');
    var ratingsCount = 0;

    // Set time to flash message
    setTimeout(function(){
        $("div.alert").remove();
    }, 4000 );

    $(() => {
        // Event with change starts
        ratings.change(function(e1) {
            var ratings  =  $(e1.target).val();
            ratingsCount = ratings;
        });

        btnRatingSubmit.click(function() {
            var comment = $("#input-comment").val();

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
