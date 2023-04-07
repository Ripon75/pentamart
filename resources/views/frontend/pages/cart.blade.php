@extends('frontend.layouts.default')
@section('title', 'Cart')
@section('content')

    @if (count($products))
    <!--========Cart page Banner========-->
    <section class="page-top-gap">
        <x-frontend.header-title
            type="default"
            height="250px"
            bgColor="linear-gradient( #112f7a, rgba(111, 111, 211, 0.52))"
            bgImageSrc="/images/banners/cart-banner.png"
            title="Shopping Cart"
        />
    </section>
    <section class="container page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3 last:gap-8">
            <div class="col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-2 xl:col-span-2 2xl:col-span-2">
                <div>
                    <div class="overflow-auto">
                        <table class="table-auto w-full bg-white">
                            <thead class="border bg-gray-300">
                                <tr class="text-sm sm:text-sm md:text-sm lg:text-base">
                                    <th class="hidden sm:hidden md:block text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r">
                                        Image
                                    </th>
                                    <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r text-left pl-2">
                                        Product
                                    </th>
                                    <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r text-right pr-0 sm:pr-0 md:pr-2">
                                        Unit MRP
                                    </th>
                                    <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 text-center border-r">
                                        Qty
                                    </th>
                                    <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 text-right border-r pr-0 sm:pr-0 md:pr-2">
                                        Discount
                                    </th>
                                    <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r text-right pr-0 sm:pr-0 md:pr-2">
                                        Subtotal
                                    </th>
                                    <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="">
                                @php $subTotal = 0; @endphp
                                @foreach ($products as $product)
                                    <tr class="item-row border">
                                        <input type="hidden" value="{{ $product->counter_type }}" class="input-counter-type">
                                        <td class="hidden sm:hidden md:block p-1 w-14 h-14 mx-auto">
                                            <div class="">
                                                <img class="" src="{{ $product->image_src }}" alt="Product Image">
                                            </div>
                                        </td>
                                        <td class="border text-left pl-1 sm:pl-1 md:pl-2">
                                            <div class="flex space-x-2">
                                                @if ($product->dosageForm)
                                                    <a href="{{ route('dosage-forms.show', $product->dosageForm->slug) }}" class="block pt-1 text-xs text-gray-500">{{ $product->dosageForm->name }}</a>
                                                @endif
                                                @if ($product->counter_type === 'prescribed')
                                                    <span class="text-secondary text-xs pt-1">Prescription required</span>
                                                @endif
                                            </div>
                                            @if ($product->name)
                                            <a href="{{ route('products.show', [$product->id, $product->slug]) }}" class="block text-primary text-xs sm:text-xs md:text-base font-medium" title="{{ $product->name }}">
                                                {{ $product->name }}
                                            </a>
                                            @endif
                                            @if ($product->company_id)
                                                <a href="{{ route('companies.show', $product->company->slug) }}" class="block text-gray-600 text-xs font-medium italic" title="{{ $product->company->name }}">
                                                    {{ $product->company->name }}
                                                </a>
                                            @else
                                                @if ($product->brand && $product->brand->company)
                                                    <a href="{{ route('companies.show', $product->brand->company->slug) }}" class="text-gray-600 text-sm italic">
                                                        {{ $product->brand->company->name }}
                                                    </a>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-xs md:text-sm lg:text-base border text-primary font-medium text-center sm:text-center md:text-right lg:text-right xl:text-right 2xl:text-right pr-1 sm:pr-1 md:pr-2">
                                            <span>{{ $currency }}</span>
                                            <span class="ml-1">
                                                {{ $product->pivot->item_mrp }}
                                            </span>
                                        </td>
                                        <td width="70px" class="text-xs md:text-sm lg:text-base text-center border px-2">
                                            @php
                                                $itemDiscountCalculate = 0;
                                                if ($product->selling_price > 0) {
                                                    $itemDiscountCalculate = $product->mrp - $product->selling_price;
                                                }
                                            @endphp
                                            <select class="cart-input-item-qty rounded text-xs md:text-sm lg:text-base py-1" name=""
                                                data-item-id="{{ $product->id }}"
                                                data-unit-price="{{ $product->selling_price }}"
                                                data-item-pack-size="{{ $product->pack_size }}"
                                                data-total-item-price-label="total-price-{{ $product->pivot->item_id }}"
                                                data-total-item-mrp-label="total-mrp-{{ $product->pivot->item_id }}"
                                                data-item-discount="{{ $itemDiscountCalculate }}"
                                                data-total-item-discount-label="total-discount-{{ $product->pivot->item_id }}"
                                                data-unit-mrp="{{ $product->mrp }}">

                                                @if ($product->is_single_sell_allow)
                                                    @for ($i = 1; $i <= $product->num_of_pack; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $i == $product->pivot->quantity ? 'selected' : '' }}>
                                                            {{ $i }} {{ $product->uom }}
                                                        </option>
                                                    @endfor
                                                @else
                                                    @for ($i = 1; $i <= $product->num_of_pack; $i++)
                                                        <option value="{{ $product->pack_size * $i }}"
                                                            {{ ($product->pack_size * $i) == $product->pivot->quantity ? 'selected' : '' }}>
                                                            {{ $product->pack_size * $i }} {{ $product->uom }}
                                                        </option>
                                                    @endfor
                                                @endif
                                            </select>
                                        </td>
                                        <td class="text-xs sm:text-xs md:text-sm lg:text-base border text-primary font-medium text-right pr-1 sm:pr-1 md:pr-2"
                                            >{{ $currency }}
                                            @php
                                                $productDiscount = 0;
                                                $itemDiscount    = $product->pivot->discount * $product->pivot->quantity;
                                                $productDiscount = ($product->pivot->discount * 100) / $product->pivot->item_mrp;
                                                $itemDiscount    = number_format( (float) $itemDiscount, 2, '.', '');
                                            @endphp
                                            <span id="total-discount-{{ $product->pivot->item_id }}" class="s-totalDiscount ml-1">
                                                <span id="discount-show-{{ $product->pivot->item_id}}">
                                                    {{ $itemDiscount }}
                                                </span>
                                            </span>
                                            <span
                                                id="product-discount-percent-id-{{ $product->id }}"
                                                class="product-discount-percent hidden"
                                                data-product-mrp="{{ $product->pivot->item_mrp }}"
                                                data-product-quantity="{{ $product->pivot->quantity }}">
                                                {{ $productDiscount }}
                                            </span>
                                        </td>

                                        <td class="text-xs sm:text-xs md:text-sm lg:text-base border text-primary font-medium text-right pr-1 sm:pr-1 md:pr-2"
                                            >{{ $currency }}
                                            @php
                                                $itemTotalPrice = $product->pivot->price * $product->pivot->quantity;
                                                $itemTotalPrice = number_format( (float) $itemTotalPrice, 2, '.', '');
                                            @endphp
                                            <span id="total-price-{{ $product->pivot->item_id }}" class="s-cart-total-price ml-1">
                                                <span id="price-show-{{ $product->pivot->item_id}}">
                                                    {{ ($itemTotalPrice) }}
                                                </span>
                                            </span>
                                        </td>

                                        <td class="hidden text-xs sm:text-xs md:text-sm lg:text-text-base xl:text-base 2xl:text-base border text-primary font-medium text-right pr-1 sm:pr-1 md:pr-2"
                                            >{{ $currency }}
                                            @php
                                                $itemTotalMRP = $product->pivot->item_mrp * $product->pivot->quantity;
                                            @endphp
                                            <span id="total-mrp-{{ $product->pivot->item_id }}" class="s-cart-total-mrp ml-1">
                                                <span id="mrp-show-{{ $product->pivot->item_id}}">
                                                    {{ ($itemTotalMRP) }}
                                                </span>
                                            </span>
                                        </td>

                                        <td class="text-xs sm:text-xs md:text-sm lg:text-text-base xl:text-base 2xl:text-base border text-center">
                                            <button class="delete-cart-item-btn btn btn-sm btn-icon-only bg-red-500 hover:bg-red-700 text-white"
                                                data-item-id="{{ $product->id }}">
                                                <i class="loadding-icon fa-solid fa-spinner fa-spin mr-2"></i>
                                                <i class="trash-icon text-sm sm:text-sm md:text-base lg:text-base xl:text-base 2xl:text-base text-white fa-regular fa-trash-can"></i>
                                            </button>
                                        </td>
                                        @php
                                            $subTotal += $product->pivot->price * $product->pivot->quantity;
                                        @endphp
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
                            <span>Sub Total Cost ({{ count($products) }} Items)</span>
                            <span>{{ $currency }}
                                <span id="sub-total-price-label" class="ml-1">{{ $subTotal }}
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Delivery Charge (+)</span>
                            <span>{{ $currency }}
                                <span id="delivery-charge-lavel" class="ml-1">{{ $deliveryGateways[0]->price }}</span>
                                <input id="input-delivery-charge" type="hidden" value="{{ $deliveryGateways[0]->price }}">
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Discount (-)</span>
                            <span>{{ $currency }}
                                <input id="m-input-discount" type="hidden" value="">
                                <span id="discount-label" class="ml-1">0.00</span>
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
                            <span>VAT 0% (+)</span>
                            {{-- @php
                                $vat = ($total*2)/100
                            @endphp --}}
                            <span>{{ $currency }} 0.00</span>
                        </div>
                    </div>
                    <div class="bg-secondary p-2 rounded-b">
                        <div class="flex justify-between text-primary font-medium">
                            <span class="text-base sm:text-base md:text-lg">Total</span>
                            <span class="text-base sm:text-base md:text-lg font-medium">
                                @php
                                    $total = $subTotal + $deliveryGateways[0]->price;
                                @endphp
                                <span>{{ $currency }}
                                    <span id="cart-total-price-label" class="ml-1">
                                        {{ $total }}
                                    </span>
                                </span>
                            </span>
                        </div>
                    </div>
                </section>
                <form action="{{ route('my.order.store') }}" method="POST" enctype="multipart/form-data" id="form-checkout">
                    @csrf
                    {{-- ========Choose Delivery Type===== --}}
                    <section class="mt-4">
                        <div class="card border-2">
                            <div class="header">
                                <h1 class="title">Choose Delivery Type <i class="ml-3 fa-solid fa-truck-fast"></i></h1>
                            </div>
                            <div class="p-2 flex space-x-2 first:space-x-0">
                                <input type="hidden" id="input-delivery-gateway-id" value="{{ $deliveryGateways[0]->id }}">
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
                                                Select Shipping Address
                                                <span class="text-red-500 ml-1">*</span>
                                            </div>
                                            <input type="hidden" class="shipping-address-id" name="shipping_address_id"
                                                value="{{ ($cart->userAddress->id) ?? null }}">
                                            <div id="" class="shipping-address-label text-sm text-gray-500">
                                                {{ ($cart->userAddress->title) ?? null }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <button id="btn-address-change" type="button" class="ml-2 btn btn-sm sm:btn-sm md:btn-md btn-secondary"
                                        data-bs-toggle="modal" @auth data-bs-target="#address-modal" @endauth
                                        @guest data-bs-target="#loginModalCenter" @endguest>Choose</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    {{-- =========Choose Payment Method======= --}}
                    <section class="mt-4">
                        <div class="card border-2">
                            <div class="header">
                                <h1 class="title">Choose Payment Method <i class="ml-3 fa-solid fa-wallet"></i></h1>
                            </div>
                            <div class="flex p-2 space-x-2">
                                <input type="hidden" name="payment_method_id" id="input-payment-method-id" value="{{ $paymentGateways[0]->id }}">
                                @for ($i=0 ; $i < count($paymentGateways) ; $i++)
                                    <button
                                        type="button"
                                        data-payment-method-id="{{ $paymentGateways[$i]->id }}"
                                        class="btn-payment-method {{ $i === 0 ? 'active' : '' }}">
                                        @if ($paymentGateways[$i]->img_src)
                                            <div class="icon text-xl">
                                                {{-- <i class="{{ $paymentGateways[$i]->icon }}"></i> --}}
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
                    </section>
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
                                            <input id="input-coupon-code-id" type="hidden" value="" name="coupon_code_id">
                                            <input id="input-coupon-code" class="w-full focus:outline-none focus:ring-0 focus:border-primary-light text-gray-500 border-gray-500 p-1.5 px-4 rounded border placeholder:text-sm m-0" placeholder="Enter coupon code" >
                                        </div>
                                        <button id="btn-check-coupon" type="button" class="btn btn-md btn-secondary">Apply</button>
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
                            <div class="header">
                                <h1 class="title">Upload prescriptions<i class="ml-3 fa-solid fa-file-arrow-up"></i></h1>
                            </div>
                            <div class="px-4 py-2">
                                <div class="mt-4">
                                    <input id="input-cart-prescription-id" name="files[]" multiple type="file"
                                        class="block w-full text-sm text-slate-500
                                        focus:outline-none focus:ring-0
                                        file:mr-4 file:py-2 file:px-8
                                        file:rounded file:border
                                        file:border-primary
                                        file:text-sm file:font-medium
                                        file:bg-violet-50 file:text-primary
                                        hover:file:bg-violet-100
                                    "/>
                                </div>
                                <div class="flex space-x-2 mt-2">
                                    <input id="input-prescription-checkbox" class="focus:ring-0" type="checkbox" value="">
                                    <span class="text-primary text-xs">
                                        I will give prescription at time of delivery
                                    </span>
                                </div>
                                <div class="mt-4">
                                    <label class="text-sm" for="">Write note here</label><br>
                                    <textarea name="note" class="w-full mt-1 focus:outline-none focus:ring-0 text-sm text-gray-500 placeholder:text-gray-400 placeholder:text-sm border-gray-500 rounded"></textarea>
                                </div>
                                <div class="flex space-x-2 mt-2">
                                    <input id="terms-and-conditons" class="focus:ring-0" type="checkbox" value="1" name="terms_and_conditons">
                                    <span class="text-gray-500 text-xs">
                                        I agree with
                                        <a href="/terms-and-conditions" class="text-primary">Terms and Conditions</a>,
                                        <a href="/privacy-policy" class="text-primary">Privacy Policy</a>,
                                        <a href="{{ route('return-policy') }}" class="text-primary">Return & Refund</a>
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
                    <h6 class="text-gray-600">You have no items in your shopping cart.</h6>
                    <h6 class="text-gray-600">Let's go buy something!</h6>
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
        // End point
        var cartAddItemEndPoint     = '/cart/item/add';
        var cartAddMetaDataEndPoint = '/cart/meta/add';
        // For cart page
        var aleartTime                = '{{ config('crud.alear_time') }}';
        var freeDeliveryCartAmount    = '{{ config('crud.free_delivery_cart_amount') }}';
        var deleteCartItemBtn         = $('.delete-cart-item-btn');
        // icon
        var iconLoadding              = $('.loadding-icon');
        var iconTrash                 = $('.trash-icon');
        var continueCartIcon          = $('#continue-cart-icon');
        //end icon
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
        var inputCouponCode     = $('#input-coupon-code');
        var btnApplyCoupon      = $('#btn-check-coupon');
        var applyCouponBox      = $('#apply-coupon-box');
        var activeCouponBox     = $('#active-coupon-box');
        var labelCouponCode     = $('.label-coupon-code');
        var btnRemoveCouponCode = $('#btn-remove-coupon-code');
        var inputCouponCodeId   = $('#input-coupon-code-id');
        // Discount label
        var discountLabel  = $('#discount-label');
        var mInputDiscount = $('#m-input-discount');
        // disable order submit button
        btnOrderSubmit.prop("disabled", true);
        btnOrderSubmit.addClass('disabled:opacity-50');
        // Trash and loading icon
        iconTrash.show();
        iconLoadding.hide();

        // For prescription
        var isPrescriptionNedded = false;
        var inputPrescriptionCheckbox = $("#input-prescription-checkbox");
        var inputCartPrescriptionId = $('#input-cart-prescription-id');
        __checkPrescribeProduct();

        // Check first order
        var userOrderCount = {{ count(Auth::user()->orders) }};
        if (!userOrderCount) {
            inputDelivaryCharge.val(0);
            deliveryGatewayPriceLabel.text('0.00');
        }

        cart__totalPriceCalculation();

        $(function() {
            // Remove cart drawer & button
            $('#btn-cart-drawer').remove();
            $('#drawerCart').remove();

            // Delete item
            deleteCartItemBtn.click(function() {
                var itemID = $(this).data('item-id');

                __removeCartItem(itemID, $(this));
            });

            // Empty item
            emptyCart.click(function() {
                $(this).find(iconTrash).hide()
                $(this).find(iconLoadding).show();
                __emptyCart();
            });

            // Event with pack size
            cartInputItemQty.change(function() {
                var qty    = $(this).val();
                var itemID = $(this).data('item-id');
                qty = +qty;

                __addCartItem(itemID, qty);

                // Update product discount percent quantity
                $(`#product-discount-percent-id-${itemID}`).data('product-quantity', qty);

                var itemTotalPrice       = 0;
                var itemTotalMRP         = 0;
                var itemTotalDiscount    = 0;
                var unitPrice            = $(this).data('unit-price');
                var unitMRP              = $(this).data('unit-mrp');
                var itemPackSize         = $(this).data('item-pack-size');
                var totalItemLabelID     = $(this).data('total-item-price-label');
                var totalItemMRPLabelID  = $(this).data('total-item-mrp-label');
                var itemDiscount         = $(this).data('item-discount');
                var totalDiscountLabelID = $(this).data('total-item-discount-label');

                __cartCheckProductOfferQty(itemID, qty).then(res => {
                    var productOfferQtyPrice = 0;
                    if (res.data.success) {
                        productOfferQtyPrice = res.data.result;
                    } else {
                        productOfferQtyPrice = 0;
                    }
                    productOfferQtyPrice = parseFloat(productOfferQtyPrice);

                    unitPrice = productOfferQtyPrice > 0 ? productOfferQtyPrice : unitPrice;
                    itemDiscount = productOfferQtyPrice > 0 ? (unitMRP - productOfferQtyPrice) : itemDiscount;

                    // Check single sell allow or not
                    itemTotalPrice       = parseFloat(unitPrice * qty);
                    itemTotalMRP         = parseFloat(unitMRP * qty);
                    itemTotalDiscount    = parseFloat(itemDiscount * qty);

                    itemTotalPrice = itemTotalPrice ? itemTotalPrice : itemTotalMRP;
    
                    itemTotalDiscount        = itemTotalDiscount.toFixed(2);
                    itemTotalPrice           = itemTotalPrice.toFixed(2);
                    $(`#${totalItemLabelID}`).text(itemTotalPrice);
                    $(`#${totalDiscountLabelID}`).text(itemTotalDiscount);
                    $(`#${totalItemMRPLabelID}`).text(itemTotalMRP);
    
                    __removedCouponCode();
                    cart__totalPriceCalculation();
                });
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

                cart__totalPriceCalculation();
                __addCartMetaData('delevery_type_id', gatewayID);
            });

            // On choose payment method
            btnPaymentMethod.click(function() {
                btnPaymentMethod.removeClass('active');
                $(this).addClass('active');

                var paymentID = $(this).data('payment-method-id');
                inputPaymentMethod.val(paymentID);
                __addCartMetaData('payment_method_id', paymentID);
            });

            btnAddressChangeCart.click(function () {
                addressModal.show();
            });

            btnOrderSubmit.click(function () {
                if (isPrescriptionNedded) {
                    __showNotification('error', 'Please choose prescription', aleartTime);
                    return false;
                }
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
                __applyCouponCode(couponCode);
            });

            // On remove coupon code
            btnRemoveCouponCode.click(function() {
                __removedCouponCode();
                cart__totalPriceCalculation();
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

            // input event with prescription checkbox
            inputPrescriptionCheckbox.click(function () {
                __checkPrescribeProduct();
            });

            // check prescription is seledted or not
            inputCartPrescriptionId.change(function() {
                __checkPrescribeProduct();
            });
        });

        // Check coupon code function
        function __applyCouponCode(couponCode) {
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

                    if (coupon.applicable_on === 'products' && coupon.discount_type === 'percentage') {
                        couponCodeOnProducts(coupon);
                    }
                }
            })
            .catch((error) => {
                console.log(error);
            });
        }

         // Remove single cart item
        function __removeCartItem(itemID, btn) {
            btn.find(iconLoadding).show();
            btn.find(iconTrash).hide();

            axios.post('/cart/item/remove', {
                    item_id: itemID
                })
                .then(function (response) {
                    btn.parent().parent().remove();
                    __removedCouponCode();
                    cart__totalPriceCalculation();
                    __cartItemCount();
                    __checkPrescribeProduct();
                })
                .catch(function (error) {
                    btn.find(iconLoadding).hide();
                    btn.find(iconTrash).show();
                });
        }

         // Empty cart
        function __emptyCart(){
            axios.get('/cart/empty')
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
        function __addCartItem(productID, productQty) {
            axios.post(cartAddItemEndPoint, {
                item_id: productID,
                item_quantity: productQty
            })
            .then((response) => {
                // location.reload();
            })
            .catch((error) => {
                console.log(error);
            });
        }

        // Add cart meta data
        function __addCartMetaData(inputName, value) {
            var data = {};

            if (inputName === 'delevery_type_id') {
                data = {
                    'delevery_type_id': value
                };
            }

            if (inputName === 'payment_method_id') {
                data = {
                    'payment_method_id': value
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
        function cart__totalPriceCalculation(couponForProduct = false) {
            var total                   = 0;
            var discount                = 0;
            var itemTotalDiscount       = 0;
            var deliveryCharge          = 0;
            var totalWithDeliveryCharge = 0;
            $(".s-cart-total-mrp").each(function() {
                total = +total;
                var st = $(this).text();
                st = +st;
                total = total + st;
            });

            $(".s-totalDiscount").each(function() {
                itemTotalDiscount = +itemTotalDiscount;
                var subTotal = $(this).text();
                subTotal = +subTotal;
                itemTotalDiscount = itemTotalDiscount + subTotal;
            });

            // Get seltected delivery charge text
            deliveryCharge = inputDelivaryCharge.val();
            // Convert delivery charge to integer
            deliveryCharge = +deliveryCharge;

            // get discount
            itemTotalDiscount = +itemTotalDiscount;
            discount          = mInputDiscount.val();
            discount          = +discount;
            if (couponForProduct) {
                var totalDiscount = discount;
                $('#discount-label').text('0.00');
            } else {
                var totalDiscount     = discount + itemTotalDiscount;
                $('#discount-label').text(itemTotalDiscount.toFixed(2));
            }

            // Calculate cart total amount
            var cartTotalAmount = parseFloat(total - totalDiscount);
            if (cartTotalAmount >= freeDeliveryCartAmount) {
                totalWithDeliveryCharge = cartTotalAmount;
                deliveryGatewayPriceLabel.text('0.00');
            } else {
                totalWithDeliveryCharge = (total + deliveryCharge) - totalDiscount;
            }

            // Calculate total price with delivery charge
            totalWithDeliveryCharge = +totalWithDeliveryCharge;
            // set total price with delivery charge
            total                   = total.toFixed(2);
            totalWithDeliveryCharge = totalWithDeliveryCharge.toFixed(2);
            subTotalPriceLabel.text(total);
            cartTotalPriceLabel.text(totalWithDeliveryCharge);
        }

        function __removedCouponCode() {
            var deliveryGatewayPrice = btnDeliveryGateway.data('delivery-gateway-price');
            applyCouponBox.show();
            activeCouponBox.hide();
            inputCouponCodeId.val('');
            inputCouponCode.val('');
            discountLabel.text('0.00');
            mInputDiscount.val(0);
            if (userOrderCount) {
                inputDelivaryCharge.val(deliveryGatewayPrice);
                deliveryGatewayPriceLabel.text(deliveryGatewayPrice);
            }
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
            mInputDiscount.val(couponAmount)
            var couponCode = coupon.code;
            couponCode     = couponCode.toUpperCase();
            deliveryGatewayPriceLabel.text(deliveryGatewayPrice.toFixed(2));
            discountLabel.text(0.0);
            mInputDiscount.val(0.0);
            inputDelivaryCharge.val(deliveryGatewayPrice);
            cart__totalPriceCalculation();
        }

        function couponCodeOnCart(coupon) {
            var total        = 0;
            var couponAmount = 0;
            if (coupon.discount_type == 'fixed') {
                couponAmount = coupon.discount_amount;
            } else {
                var couponPercent = coupon.discount_amount;
                $(".s-cart-total-price").each(function() {
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
            discountLabel.text(couponAmount.toFixed(2));
            mInputDiscount.val(couponAmount)
            var couponCode = coupon.code;
            couponCode     = couponCode.toUpperCase();
            $('#coupon-discount-div').show();
            $('#coupon-discount-label').text(couponAmount.toFixed(2));
            cart__totalPriceCalculation();
        }

        function couponCodeOnProducts(coupon) {
            var total        = 0;
            var couponAmount = 0;
            $(".product-discount-percent").each(function() {
                var productMRP      = $(this).data('product-mrp');
                var productQuantity = $(this).data('product-quantity');
                var productDiscountPercent = parseFloat($(this).text());
                var couponDiscountPercent = coupon.discount_amount;

                // Casting integer value
                productMRP = +productMRP;
                productQuantity = +productQuantity;
                productDiscountPercent = +productDiscountPercent;

                if(productDiscountPercent < couponDiscountPercent){
                    var productDiscount = (productMRP * couponDiscountPercent) /100;
                    productDiscount = productDiscount * productQuantity;
                    couponAmount += productDiscount;
                } else {
                    var productDiscount = (productMRP * productDiscountPercent) /100;
                    productDiscount = productDiscount * productQuantity;
                    couponAmount += productDiscount;
                }
            });
            couponAmount = parseFloat(couponAmount);

            applyCouponBox.hide();
            activeCouponBox.show();
            labelCouponCode.text(coupon.code);
            inputCouponCodeId.val(coupon.id);
            discountLabel.text(0);
            mInputDiscount.val(couponAmount)
            var couponCode = coupon.code;
            couponCode     = couponCode.toUpperCase();
            $('#coupon-discount-div').show();
            $('#coupon-discount-label').text(couponAmount.toFixed(2));
            cart__totalPriceCalculation(true);
        }

        function __checkPrescribeProduct() {
            var isPrescriptionCheckboxChecked = inputPrescriptionCheckbox.prop("checked")
            var isPrescriptionSelected = document.getElementById("input-cart-prescription-id").files.length;
            if (isPrescriptionCheckboxChecked || isPrescriptionSelected) {
                isPrescriptionNedded = false;
                inputCartPrescriptionId.css({"color": "black"});
                return false;
            }else {
                $('.input-counter-type').each(function () {
                    var counterType = $(this).val();
                    if (counterType === 'prescribed') {
                        isPrescriptionNedded = true;
                        inputCartPrescriptionId.css({"color": "red"});
                        return false;
                    } else {
                        isPrescriptionNedded = false;
                        inputCartPrescriptionId.css({"color": "black"});
                    }
                });
            }
        }

        async function __cartCheckProductOfferQty(selectedProductId, selectedProductQty) {
            var checkOfferQtyEndpoint = '/api/check/offer/quantity';
            try {
                let res = await axios({
                    url: checkOfferQtyEndpoint,
                    method: 'get',
                    params: {
                        'product_id': selectedProductId,
                        'quantity': selectedProductQty
                    },
                    headers: {
                        'Content-Type': 'application/json',
                    }
                    })
                return res
            }
            catch (err) {
                console.error(err);
            }
        }

    </script>
@endpush
