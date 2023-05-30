@extends('frontend.layouts.default')
@section('title', 'Cart')
@section('content')
    @if (count($products))
        <section class="container page-section page-top-gap">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3 last:gap-8">
                <div class="col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-2 xl:col-span-2 2xl:col-span-2">
                    <div>
                        <div class="overflow-auto">
                            <table class="table-auto w-full bg-white">
                                <thead class="border bg-secondary">
                                    <tr class="text-sm sm:text-sm md:text-sm lg:text-base">
                                        <th class="hidden sm:hidden md:block text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r">
                                            Image
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r text-left pl-2">
                                            Product
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r text-left pl-2">
                                            Color
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r text-left pl-2">
                                            Size
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r text-right pr-0 sm:pr-0 md:pr-2">
                                            Price
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 text-center border-r">
                                            Qty
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 text-right border-r pr-0 sm:pr-0 md:pr-2">
                                            Discount
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r text-right pr-0 sm:pr-0 md:pr-2">
                                            Item total
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="">
                                    @php $subTotal = 0; @endphp
                                    @foreach ($products as $key => $product)
                                        <tr class="item-row border">
                                            <input type="hidden" value="{{ $product->counter_type }}" class="input-counter-type">
                                            <td class="hidden sm:hidden md:block p-1 w-14 h-14 mx-auto">
                                                <div class="">
                                                    <img class="" src="{{ $product->image_src }}" alt="Product Image">
                                                </div>
                                            </td>
                                            <td class="border text-left pl-1 sm:pl-1 md:pl-2">
                                                @if ($product->name)
                                                <a href="{{ route('products.show', [$product->id, $product->slug]) }}" class="block text-primary text-xs sm:text-xs md:text-base font-medium" title="{{ $product->name }}">
                                                    {{ $product->name }}
                                                </a>
                                                @endif
                                            </td>
                                            <td class="text-xs md:text-sm lg:text-base border text-primary font-medium text-center sm:text-center md:text-right lg:text-right xl:text-right 2xl:text-right pr-1 sm:pr-1 md:pr-2">
                                                @if ($product->pivot->color_id)
                                                    <span class="ml-1">
                                                        {{ $product->colors[$product->pivot->color_id - 1]->name ?? '' }}
                                                    </span>
                                                @else
                                                    <span class="ml-1">
                                                        N/A
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-xs md:text-sm lg:text-base border text-primary font-medium text-center sm:text-center md:text-right lg:text-right xl:text-right 2xl:text-right pr-1 sm:pr-1 md:pr-2">
                                                @if ($product->pivot->size_id)
                                                        <span class="ml-1">
                                                        {{ $product->sizes[$product->pivot->size_id - 1]->name ?? '' }}
                                                    </span>
                                                @else
                                                    <span class="ml-1">
                                                        N/A
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-xs md:text-sm lg:text-base border text-primary font-medium text-center sm:text-center md:text-right lg:text-right xl:text-right 2xl:text-right pr-1 sm:pr-1 md:pr-2">
                                                <span class="ml-1">
                                                    {{ $product->pivot->item_price }}
                                                </span>
                                            </td>
                                            <td width="70px" class="text-xs md:text-sm lg:text-base text-center border px-2">
                                                <select class="cart-input-item-qty rounded text-xs md:text-sm lg:text-base py-1" name=""
                                                    data-item-id="{{ $product->id }}"
                                                    data-unit-sell-price="{{ $product->offer_price }}"
                                                    data-total-item-sell-price-label="total-sell-price-{{ $product->pivot->item_id }}"
                                                    data-total-item-price-label="total-price-{{ $product->pivot->item_id }}"
                                                    data-item-discount="{{ $product->discount }}"
                                                    data-total-item-discount-label="total-discount-{{ $product->pivot->item_id }}"
                                                    data-unit-price="{{ $product->price }}"
                                                    data-color-id="{{ $product->pivot->color_id }}"
                                                    data-size-id="{{ $product->pivot->size_id }}">

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <option value="{{ $i }}" {{ $product->pivot->quantity == $i ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td class="text-xs sm:text-xs md:text-sm lg:text-base border text-primary font-medium text-right pr-1 sm:pr-1 md:pr-2">
                                                @php
                                                    $itemTotalDiscount = $product->pivot->item_discount * $product->pivot->quantity;
                                                    $itemTotalDiscount = number_format((float)$itemTotalDiscount, 2);
                                                @endphp
                                                <span id="total-discount-{{ $product->pivot->item_id }}" class="sub-total-discount ml-1">
                                                    <span id="discount-show-{{ $product->pivot->item_id}}">
                                                        {{ $itemTotalDiscount }}
                                                    </span>
                                                </span>
                                            </td>

                                            <td class="text-xs sm:text-xs md:text-sm lg:text-base border text-primary font-medium text-right pr-1 sm:pr-1 md:pr-2">
                                                @php
                                                    $itemTotalSellPrice = $product->pivot->sell_price * $product->pivot->quantity;
                                                    $itemTotalSellPrice = number_format((float)$itemTotalSellPrice, 2);
                                                @endphp
                                                <span id="total-sell-price-{{ $product->pivot->item_id }}" class="sub-total-sell-price ml-1">
                                                    <span id="price-show-{{ $product->pivot->item_id}}">
                                                        {{ ($itemTotalSellPrice) }}
                                                    </span>
                                                </span>
                                            </td>

                                            <td class="hidden text-xs sm:text-xs md:text-sm lg:text-text-base xl:text-base 2xl:text-base border text-primary font-medium text-right pr-1 sm:pr-1 md:pr-2">
                                                @php
                                                    $itemTotalPrice = $product->pivot->item_price * $product->pivot->quantity;
                                                @endphp
                                                <span id="total-price-{{ $product->pivot->item_id }}" class="sub-total-price ml-1">
                                                    <span id="mrp-show-{{ $product->pivot->item_id}}">
                                                        {{ ($itemTotalPrice) }}
                                                    </span>
                                                </span>
                                            </td>

                                            <td class="text-xs sm:text-xs md:text-sm lg:text-text-base xl:text-base 2xl:text-base border text-center">
                                                <button class="delete-cart-item-btn btn btn-sm btn-icon-only bg-red-500 hover:bg-red-700 text-white"
                                                    data-item-id="{{ $product->id }}"
                                                    data-color-id="{{ $product->pivot->color_id }}"
                                                    data-size-id="{{ $product->pivot->size_id }}">
                                                    <i class="loadding-icon fa-solid fa-spinner fa-spin mr-2"></i>
                                                    <i class="trash-icon text-sm sm:text-sm md:text-base lg:text-base xl:text-base 2xl:text-base text-white fa-regular fa-trash-can"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-between sm:justify-between md:justify-between lg:justify-end xl:justify-end 2xl:justify-end space-x-6 mt-4">
                            <div class="">
                                <button id="btn-shopping-continue" class="btn btn-md btn-primary">
                                    <a class="hover:text-white" href="{{ route('products.index') }}">
                                        Continue shopping
                                        <i id="continue-cart-icon" class="ml-2 fa-solid fa-cart-plus"></i></a>
                                        <i class="loadding-icon fa-solid fa-spinner fa-spin mr-2"></i>
                                </button>
                            </div>
                            <div class="">
                                <button id="empty-cart" class="btn btn-md btn-danger">
                                    Clear cart
                                    <i class="ml-2 trash-icon text-white fa-regular fa-trash-can"></i>
                                    <i class="loadding-icon fa-solid fa-spinner fa-spin mr-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-1">
                    <section class="card border-2">
                        <div class="flex flex-col space-y-1 p-2 border rounded-t font-medium text-sm sm:text-sm md:text-base">
                            <div class="flex justify-between">
                                <span>Total Price</span>
                                <span>{{ $currency }}
                                    <span id="sub-total-price-label" class="ml-1"></span>
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span>Discount (-)</span>
                                <span>{{ $currency }}
                                    <input id="input-items-discount" type="hidden" value="">
                                    <span id="items-total-discount-label" class="ml-1"></span>
                                </span>
                            </div>
                            <div id="coupon-discount-div" class="hidden">
                                <div class="flex justify-between">
                                    <span>Coupon Discount (-)</span>
                                    <span>{{ $currency }}
                                        <input type="hidden" value="">
                                        <span id="coupon-discount-label" class="ml-1">0.00</span>
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <span>Total Price(-Discount)</span>
                                <span>{{ $currency }}
                                    <span id="sub-total-sell-price-label" class="ml-1"></span>
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span>Delivery Charge (+)</span>
                                <span>{{ $currency }}
                                    <span id="delivery-charge-lavel" class="ml-1"></span>
                                    <input id="input-delivery-charge" type="hidden" value="{{ $deliveryGateways[0]->price }}">
                                </span>
                            </div>
                        </div>
                        <div class="bg-[#00798c] p-2 rounded-b">
                            <div class="flex justify-between text-white font-medium">
                                <span class="text-base sm:text-base md:text-lg">Total</span>
                                <span class="text-base sm:text-base md:text-lg font-medium">
                                    <span>{{ $currency }}
                                        <span id="cart-total-price-label" class="ml-1">
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </section>
                    <form action="{{ route('my.order.store') }}" method="POST" id="form-checkout">
                        @csrf
                        {{-- ========Choose Delivery Type===== --}}
                        <section class="mt-4">
                            <div class="card border-2">
                                {{-- <div class="header">
                                    <h1 class="title">Choose Delivery Type <i class="ml-3 fa-solid fa-truck-fast"></i></h1>
                                </div> --}}
                                <div class="p-2 space-x-2 first:space-x-0 hidden">
                                    <input type="hidden" id="input-delivery-gateway-id" value="">
                                    @for ($i=0 ; $i < count($deliveryGateways) ; $i++)
                                        <button
                                            type="button"
                                            data-delivery-gateway-price="{{ $deliveryGateways[$i]->price }}"
                                            data-delivery-gateway-id="{{ $deliveryGateways[$i]->id }}"
                                            class="btn-delivery-gateway
                                            {{ $i === 0 ? 'active' : '' }}">
                                            <span class="text-sm tracking-wide font-bold">{{ $deliveryGateways[$i]->name }}</span>
                                            <span class="text-xs">
                                                {{ $deliveryGateways[$i]->min_delivery_time }} to {{ $deliveryGateways[$i]->max_delivery_time }}
                                                &nbsp;{{ $deliveryGateways[$i]->delivery_time_unit }}
                                            </span>
                                        </button>
                                    @endfor
                                </div>
                                <div class="p-2">
                                    <div class="flex justify-between items-center">
                                        <div class="flex space-x-2 items-center">
                                            <div class="h-8 w-8 border rounded flex items-center justify-center">
                                                <i class="text-lg text-gray-500 fa-solid fa-location-dot"></i>
                                            </div>
                                            <div class="">
                                                <div class="text-sm sm:text-sm md:text-sm font-semibold">
                                                    Select Address
                                                    <span class="text-red-500 ml-1">*</span>
                                                </div>
                                                <input type="hidden" class="shipping-address-id" name="address_id"
                                                    value="{{ ($cart->address->id) ?? null }}">
                                                <div id="" class="shipping-address-label text-sm text-gray-500">
                                                    {{ ($cart->address->title) ?? null }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <button id="btn-address-change" type="button" class="ml-2 btn btn-sm sm:btn-sm md:btn-md btn-primary"
                                            data-bs-toggle="modal" @auth data-bs-target="#address-modal" @endauth
                                            @guest data-bs-target="#loginModalCenter" @endguest>Choose</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- =========Choose Payment Method======= --}}
                        {{-- <section class="mt-4">
                            <div class="card border-2">
                                <div class="header">
                                    <h1 class="title">Choose Payment Method <i class="ml-3 fa-solid fa-wallet"></i></h1>
                                </div>
                                <div class="flex p-2 space-x-2">
                                    <input type="hidden" name="pg_id" id="input-payment-method-id" value="">
                                    @for ($i=0 ; $i < count($paymentGateways) ; $i++)
                                        <button
                                            type="button"
                                            data-payment-method-id="{{ $paymentGateways[$i]->id }}"
                                            class="btn-payment-method {{ $i === 0 ? 'active' : '' }}">
                                            @if ($paymentGateways[$i]->img_src)
                                                <div class="icon text-xl">
                                                    <img src="{{ $paymentGateways[$i]->img_src }}" class="w-6" alt="PG">
                                                </div>
                                            @else
                                                <div class="icon text-xl">
                                                    <i class="{{ $paymentGateways[$i]->icon }}"></i>
                                                </div>
                                            @endif
                                            <div class="title text-sm">{{ $paymentGateways[$i]->name }}</div>
                                        </button>
                                    @endfor
                                </div>
                            </div>
                        </section> --}}
                        {{-- ===========Use coupon==================== --}}
                        <section class="mt-4">
                            <div class="card border-2">
                                <div class="header">
                                    <h1 class="title">Have a coupon code? <i class="ml-3 fa-solid fa-tag"></i></h1>
                                </div>
                                <div class="px-2 sm:px-2 md:px-2 xl:px-4 py-4">
                                    <div id="apply-coupon-box">
                                        <div class="flex space-x-2">
                                            <div class="flex-1">
                                                <input id="input-coupon-code-id" type="hidden" value="" name="coupon_id">
                                                <input id="input-coupon-code" class="w-full focus:outline-none focus:ring-0 focus:border-primary-light text-gray-500 border-gray-500 p-1.5 px-4 rounded border placeholder:text-sm m-0" placeholder="Enter coupon code" >
                                            </div>
                                            <button id="btn-check-coupon" type="button" class="btn btn-md btn-primary">Apply</button>
                                        </div>
                                    </div>
                                    <div id="active-coupon-box" class="hidden">
                                        <div class="bg-green-100 rounded-md p-1 border border-green-600 text-green-600 flex justify-between items-center">
                                            <span class="text-sm">
                                                <span class="label-coupon-code font-medium ml-2 uppercase">FREE10</span>
                                                &nbsp;Applied
                                            </span>
                                            <button type="button" id="btn-remove-coupon-code" class="p-1 text-red-600 text-sm" title="Remove coupon">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        {{-- ===============Checkout================== --}}
                        <section class="mt-4">
                            <div class="card border-2">
                                <div class="px-4 py-2">
                                    <div class="mt-4">
                                        <label class="text-sm" for="">Write note here</label><br>
                                        <textarea name="note" class="w-full mt-1 focus:outline-none focus:ring-0 text-sm text-gray-500 placeholder:text-gray-400 placeholder:text-sm border-gray-500 rounded"></textarea>
                                    </div>
                                    <div class="flex space-x-2 mt-2">
                                        <input id="terms-and-conditons" class="focus:ring-0" type="checkbox" value="1" name="terms_and_conditons">
                                        <span class="text-gray-500 text-xs">
                                            I agree with
                                            <a href="{{ route('terms.and.condition') }}" class="text-primary">Terms and Conditions</a>,
                                        </span>
                                    </div>
                                    <div class="mt-4">
                                        <button type="button" id="btn-order-submit" class="btn btn-md btn-block btn-primary">
                                            <i class="loadding-icon fa-solid fa-spinner fa-spin mr-2"></i>
                                            SUBMIT ORDER
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </section>
    @else
        <section class="container page-section page-top-gap">
            <div class="card p-8">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-60">
                        <img class="max-w-full h-auto" src="/images/sample/emptycart.png">
                    </div>
                    <div class="mt-8 text-center">
                        <h1 class="text-2xl sm:text-2xl md:text-3xl lg:text-4xl font-medium tracking-wide text-primary">Your cart is empty</h1>
                    </div>
                    <div class="text-center mt-2 sm:mt-2 md:mt-4 text-sm sm:text-sm md:text-base">
                        <h6 class="text-gray-600">No items in your shopping cart.</h6>
                    </div>
                    <a href="{{ route('products.index') }}" class="mt-4 sm:mt-4 md:mt-6">
                        <button class="btn btn-sm sm:btn-sm md:btn-md btn-primary">Shop Now</button>
                    </a>
                </div>
            </div>
        </section>
    @endif

@endsection

@push('scripts')
    <script>
        var aleartTime                = '{{ config('crud.alear_time') }}';
        var cartAddItemEndPoint       = '/cart/items/add';
        var cartAddMetaDataEndPoint   = '/cart/meta/add';
        var deleteCartItemBtn         = $('.delete-cart-item-btn');
        var iconLoadding              = $('.loadding-icon');
        var iconTrash                 = $('.trash-icon');
        var continueCartIcon          = $('#continue-cart-icon');
        var emptyCart                 = $('#empty-cart');
        var cartInputItemQty          = $('.cart-input-item-qty');
        var btnDeliveryGateway        = $('.btn-delivery-gateway');
        var btnPaymentMethod          = $('.btn-payment-method');
        var inputDeliveryGateway      = $('#input-delivery-gateway-id');
        var inputPaymentMethod        = $('#input-payment-method-id');
        var btnOrderSubmit            = $('#btn-order-submit');
        var formCheckOut              = $('#form-checkout');
        var subTotalPriceLabel        = $('#sub-total-price-label');
        var cartTotalPriceLabel       = $('#cart-total-price-label');
        var deliveryGatewayPriceLabel = $('#delivery-charge-lavel');
        var inputDelivaryCharge       = $('#input-delivery-charge');
        // For address create
        var addressModal         = $('#address-modal');
        var btnAddressChangeCart = $('#btn-address-change');
        var btnContinueShopping  = $('#btn-shopping-continue');
        // Coupon code
        var inputCouponCode         = $('#input-coupon-code');
        var btnApplyCoupon          = $('#btn-check-coupon');
        var applyCouponBox          = $('#apply-coupon-box');
        var activeCouponBox         = $('#active-coupon-box');
        var labelCouponCode         = $('.label-coupon-code');
        var btnRemoveCouponCode     = $('#btn-remove-coupon-code');
        var inputCouponCodeId       = $('#input-coupon-code-id');
        var itemsTotalDiscountLabel = $('#items-total-discount-label');
        var subTotalSellPriceLabel  = $('#sub-total-sell-price-label');
        var inputItemsDiscount      = $('#input-items-discount');
        // disable order submit button
        btnOrderSubmit.prop("disabled", true);
        btnOrderSubmit.addClass('disabled:opacity-50');
        // Trash and loading icon
        iconTrash.show();
        iconLoadding.hide();

        cartTotalPriceCalculation();

        $(function() {
            // Remove cart drawer & button
            $('#btn-cart-drawer').remove();
            $('#drawerCart').remove();

            // Delete item
            deleteCartItemBtn.click(function() {
                var itemId = $(this).data('item-id');
                var colorId = $(this).data('color-id');
                var sizeId = $(this).data('size-id');

                removeCartItem(itemId, colorId, sizeId, $(this));
            });

            // Empty item
            emptyCart.click(function() {
                $(this).find(iconTrash).hide()
                $(this).find(iconLoadding).show();
                emptyCart();
            });

            // Event with pack size
            cartInputItemQty.change(function() {
                var quantity = $(this).val();
                var itemId   = $(this).data('item-id');
                var colorId  = $(this).data('color-id');
                var sizeId   = $(this).data('size-id');

                addCartItem(itemId, quantity, colorId, sizeId);

                var itemTotalSellPrice        = 0;
                var itemTotalPrice            = 0;
                var itemTotalDiscount         = 0;
                var unitSellPrice             = $(this).data('unit-sell-price');
                var unitPrice                 = $(this).data('unit-price');
                var totalItemSellPriceLabelID = $(this).data('total-item-sell-price-label');
                var totalItemPriceLabelID     = $(this).data('total-item-price-label');
                var itemDiscount              = $(this).data('item-discount');
                var totalDiscountLabelID      = $(this).data('total-item-discount-label');

                itemTotalSellPrice = parseFloat(unitSellPrice * quantity);
                itemTotalPrice     = parseFloat(unitPrice * quantity);
                itemTotalDiscount  = parseFloat(itemDiscount * quantity);

                itemTotalSellPrice = itemTotalSellPrice ? itemTotalSellPrice : itemTotalPrice;

                itemTotalDiscount  = itemTotalDiscount.toFixed(2);
                itemTotalSellPrice = itemTotalSellPrice.toFixed(2);
                $(`#${totalItemSellPriceLabelID}`).text(itemTotalSellPrice);
                $(`#${totalDiscountLabelID}`).text(itemTotalDiscount);
                $(`#${totalItemPriceLabelID}`).text(itemTotalPrice);

                removedCouponCode();
            });

            // On Choose Delivery Type item
            btnDeliveryGateway.click(function() {
                btnDeliveryGateway.removeClass('active');
                $(this).addClass('active');

                var gatewayID    = $(this).data('delivery-gateway-id');
                var gatewayPrice = $(this).data('delivery-gateway-price');
                inputDelivaryCharge.val(gatewayPrice);
                deliveryGatewayPriceLabel.text(gatewayPrice);
                inputDeliveryGateway.val(gatewayID);

                cartTotalPriceCalculation();
                addCartMetaData('delevery_type_id', gatewayID);
            });

            // On choose payment method
            btnPaymentMethod.click(function() {
                btnPaymentMethod.removeClass('active');
                $(this).addClass('active');

                var paymentID = $(this).data('payment-method-id');
                inputPaymentMethod.val(paymentID);
                addCartMetaData('pg_id', paymentID);
            });

            btnAddressChangeCart.click(function () {
                addressModal.show();
            });

            btnOrderSubmit.click(function () {
                var addressID = $('.header-shipping-address').find(":selected").val();
                if (addressID) {
                    var checked = $('input[name=terms_and_conditons]:checked').val();
                    if (checked == 1) {
                        formCheckOut.submit();
                    } else {
                        __showNotification('error', 'Please checked terms and conditons', aleartTime);
                        return false;
                    }
                } else {
                    __showNotification('error', 'Please select shipping address to continue', aleartTime);
                    return false;
                }
                $(this).find(iconLoadding).show();
            });

            inputCouponCode.on("keypress", function(e) {
                if (e.keyCode == 13) {
                    btnApplyCoupon.click();
                    return false; // prevent the button click from happening
                }
            });

            // Check coupon code
            btnApplyCoupon.click(function() {
                var couponCode = inputCouponCode.val();
                applyCouponCode(couponCode);
            });

            // On remove coupon code
            btnRemoveCouponCode.click(function() {
                removedCouponCode();
                cartTotalPriceCalculation();
            });

            $('#terms-and-conditons').click(function() {
                var checked = $('input[name=terms_and_conditons]:checked').val();
                var addressID = inputShippingAddress.find(":selected").val();
                checked   = checked ? checked : null;
                addressID = addressID ? addressID : null;
                if (checked && addressID) {
                    btnOrderSubmit.prop("disabled", false);
                    btnOrderSubmit.removeClass('disabled:opacity-50');
                } else {
                    btnOrderSubmit.prop("disabled", true);
                    btnOrderSubmit.addClass('disabled:opacity-50');
                }
            });

            inputShippingAddress.change(function() {
                var checked = $('input[name=terms_and_conditons]:checked').val();
                var addressID = inputShippingAddress.find(":selected").val();
                checked   = checked ? checked : null;
                addressID = addressID ? addressID : null;
                if (checked && addressID) {
                    btnOrderSubmit.prop("disabled", false);
                    btnOrderSubmit.removeClass('disabled:opacity-50');
                } else {
                    btnOrderSubmit.prop("disabled", true);
                    btnOrderSubmit.addClass('disabled:opacity-50');
                }
            });

            btnContinueShopping.click( function() {
                $(this).find(iconLoadding).show();
                continueCartIcon.hide();
            });
        });

        // Check coupon code function
        function applyCouponCode(couponCode) {
            var endpoint = "{{ route('coupon.check') }}";
            axios.post(endpoint, {
                coupon_code: couponCode
            })
            .then((response) => {
                if (response.data.error) {
                    inputCouponCode.val('');
                    __showNotification('error', response.data.message, aleartTime);
                    return false;
                } else {
                    var coupon = response.data

                    if (coupon.applicable_on === 'delivery_fee') {
                        couponCodeOnDelivery(coupon);
                    }

                    if (coupon.applicable_on === 'cart') {
                        couponCodeOnCart(coupon);
                    }
                }
            })
            .catch((error) => {
                console.log(error);
            });
        }

        // Remove single cart item
        function removeCartItem(itemId, colorId, sizeId, btn) {
            btn.find(iconLoadding).show();
            btn.find(iconTrash).hide();

            axios.post('/cart/items/remove', {
                item_id: itemId,
                color_id: colorId,
                size_id: sizeId,
            })
            .then(function (response) {
                btn.parent().parent().remove();
                removedCouponCode();
                cartTotalPriceCalculation();
                __cartItemCount();
            })
            .catch(function (error) {
                btn.find(iconLoadding).hide();
                btn.find(iconTrash).show();
            });
        }

         // Empty cart
        function emptyCart(){
            axios.get('/cart/items/empty')
            .then(function (response) {
                // handle success
                location.reload();
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        }

        // Add cart item
        function addCartItem(productID, productQty, colorId, sizeId) {
            axios.post(cartAddItemEndPoint, {
                item_id: productID,
                quantity: productQty,
                color_id: colorId,
                size_id: sizeId,
                is_update: true
            })
            .then((response) => {
                cartTotalPriceCalculation();
            })
            .catch((error) => {
                console.log(error);
            });
        }

        // Add cart meta data
        function addCartMetaData(inputName, value) {
            var data = {};

            if (inputName === 'delevery_type_id') {
                data = {
                    'delevery_type_id': value
                };
            }

            if (inputName === 'pg_id') {
                data = {
                    'pg_id': value
                };
            }

            axios.post(cartAddMetaDataEndPoint, data)
            .then((response) => {
            })
            .catch((error) => {
                __showNotification('error', response.data.message, aleartTime);
                return false;
            });
        }

        // Calculate total price
        function cartTotalPriceCalculation() {
            var itemsTotalPrice         = 0;
            var itemTotalDiscount       = 0;
            var deliveryCharge          = 0;
            var totalWithDeliveryCharge = 0;
            $(".sub-total-price").each(function() {
                var itemPrice = parseFloat($(this).text());
                itemsTotalPrice = itemsTotalPrice + itemPrice;
            });

            $(".sub-total-discount").each(function() {
                itemTotalDiscount = +itemTotalDiscount;
                var subDiscount = parseFloat($(this).text());
                itemTotalDiscount = itemTotalDiscount + subDiscount;
            });


            // Get seltected delivery charge text
            deliveryCharge = parseFloat(inputDelivaryCharge.val());
            deliveryGatewayPriceLabel.text(deliveryCharge.toFixed(2));

            // get coupon discount
            couponDiscount = inputItemsDiscount.val();
            couponDiscount = +couponDiscount;

            // Items total sell price
            var itemsTotalSellPrice = itemsTotalPrice - (itemTotalDiscount + couponDiscount);

            itemsTotalDiscountLabel.text(itemTotalDiscount.toFixed(2));
            subTotalSellPriceLabel.text(itemsTotalSellPrice.toFixed(2));

            totalWithDeliveryCharge = (itemsTotalPrice + deliveryCharge) - (itemTotalDiscount + couponDiscount);

            itemsTotalPrice         = itemsTotalPrice.toFixed(2);
            totalWithDeliveryCharge = totalWithDeliveryCharge.toFixed(2);
            subTotalPriceLabel.text(itemsTotalPrice);
            cartTotalPriceLabel.text(totalWithDeliveryCharge);
        }

        function removedCouponCode() {
            var deliveryGatewayPrice = btnDeliveryGateway.data('delivery-gateway-price');
            applyCouponBox.show();
            activeCouponBox.hide();
            inputCouponCodeId.val('');
            inputCouponCode.val('');
            discountLabel.text('0.00');
            inputItemsDiscount.val(0);
            $('#coupon-discount-div').hide();
        }

        function couponCodeOnDelivery(coupon) {
            var couponAmount = coupon.discount_amount;
            var deliveryGatewayPrice = btnDeliveryGateway.data('delivery-gateway-price');
            deliveryGatewayPrice = deliveryGatewayPrice - couponAmount;
            applyCouponBox.hide();
            activeCouponBox.show();
            labelCouponCode.text(coupon.code);
            inputCouponCodeId.val(coupon.id);
            discountLabel.text(couponAmount);
            inputItemsDiscount.val(couponAmount)
            var couponCode = coupon.code;
            couponCode     = couponCode.toUpperCase();
            deliveryGatewayPriceLabel.text(deliveryGatewayPrice.toFixed(2));
            discountLabel.text(0.0);
            inputItemsDiscount.val(0.0);
            inputDelivaryCharge.val(deliveryGatewayPrice);
            cartTotalPriceCalculation();
        }

        function couponCodeOnCart(coupon) {
            var total        = 0;
            var couponAmount = 0;
            if (coupon.discount_type == 'fixed') {
                couponAmount = coupon.discount_amount;
            } else {
                var couponPercent = coupon.discount_amount;
                $(".sub-total-sell-price").each(function() {
                    var st = parseFloat($(this).text());
                    total = total + st;
                });
                couponAmount = (total * couponPercent)/100;
            }
            couponAmount = parseFloat(couponAmount);
            applyCouponBox.hide();
            activeCouponBox.show();
            labelCouponCode.text(coupon.code);
            inputCouponCodeId.val(coupon.id);
            // discountLabel.text(couponAmount.toFixed(2));
            inputItemsDiscount.val(couponAmount)
            var couponCode = coupon.code;
            couponCode     = couponCode.toUpperCase();
            $('#coupon-discount-div').show();
            $('#coupon-discount-label').text(couponAmount.toFixed(2));
            cartTotalPriceCalculation();
        }
    </script>
@endpush
