@extends('frontend.layouts.default')
@section('title', $product->name)
@section('content')

<section class="page-section page-top-gap">
    <div class="container mx-auto">
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
                    <div class="prices flex space-x-2 items-center mb-2">
                        <span class="text-gray-500 text-sm"><strong>Best Price *</strong></span>
                        <span>
                            <span>{{ $currency }}&nbsp;</span>
                            @if ($product->offer_price > 0)
                                <span id="item-price-label" class="text-primary text-xl font-medium">
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
                    <div class="flex flex-col space-y-2">
                        <div class="flex space-x-4">
                            <select class="selected-pack-single w-32 rounded-md py-1.5 text-sm" id="input-qty">
                                @for ($i = 1 ; $i <= 5 ; $i++)
                                    <option value="{{ $i }}">{{ $i }} </option>
                                @endfor
                            </select>
                            <div class="flex space-x-4">
                                <button class="btn-add-to-car-single h-[36px] bg-[#00798c] text-sm whitespace-nowrap px-4 text-white rounded-md"
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
                <h1 class="text-primary-dark text-lg font-medium p-4">Alternative Product</h1>
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
                <h1 class="text-lg">More Information About - <span class="font-semibold">{{ $product->name }}</span></h1>
                @if ($product->description)
                    <div class="product-detail mt-3">
                        <div>
                            <div class="bg-primary h-10 flex items-center rounded-t-md">
                                <h1 class="text-base text-white pl-4">Description</h1>
                            </div>
                            <div class="bg-white mb-4 p-4 product-description">
                                <p>
                                    {!! html_entity_decode($product->description) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- ===========Disclaimer============= --}}
                {{-- <div class="col-span-3 mt-3">
                    <div>
                        <div class="bg-gradient-to-t to-gray-200 from-gray-100 h-10 flex items-center rounded-t-md">
                            <h1 class="text-base text-red-500 font-medium pl-4"><i class="mr-3 fa-solid fa-bookmark"></i>Disclaimer</h1>
                        </div>
                        <div class=" mb-4 p-4 bg-white">
                            <p class="text-sm text-gray-600">The information provided herein are for informational purposes only and not intended to be a substitute for professional medical advice, diagnosis, or treatment. Please note that this information should not be treated as a replacement for physical medical consultation or advice. Great effort has been placed to provide accurate and comprehensive data. However, Medicart along with its authors and editors make no representations or warranties and specifically disclaim all liability for any medical information provided on the site. The absence of any information and/or warning to any drug shall not be considered and assumed as an implied assurance of the Company.</p>
                        </div>
                    </div>
                </div> --}}
            </div>
            {{-- <div class="col-span-6 lg:col-span-6 xl:col-span-2">
                <h1 class="text-xl font-medium">Others Product</h1>
                <div class="mt-3 product-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-2 gap-2">
                    @foreach ($otherProducts as $oProduct)
                    <div>
                        <x-frontend.product-thumb type="default" :product="$oProduct" />
                    </div>
                    @endforeach
                </div>
            </div> --}}
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
    var btnAddToCartSingle  = $('.btn-add-to-car-single');
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
    var sUserID             = {{ Auth::id() }};
    var productColorsCount  = {{ count($productColors) }};
    var productSizesCount   = {{ count($productSizes) }};

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
        btnAddToCartSingle.click(function () {
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
@endpush
