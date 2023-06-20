@extends('frontend.layouts.default')
@section('title', 'Checkout')
@section('content')
    @if (count($products))
        <section class="container page-section page-top-gap">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-5 xl:grid-cols-5 2xl:grid-cols-5 last:gap-4">
                <div class="col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-3 xl:col-span-3 2xl:col-span-3">
                    <div class="card border-2 p-4">
                        <div class="flex justify-between sm:justify-between md:justify-between lg:justify-end xl:justify-end 2xl:justify-end space-x-6 mt-4">
                            <div class="">
                                <button id="btn-shopping-continue" class="btn btn-md btn-secondary">
                                    <a class="hover:text-white" href="{{ route('products.index') }}">
                                        Continue shopping
                                    </a>
                                    <i class="loadding-icon fa-solid fa-spinner fa-spin mr-2"></i>
                                </button>
                            </div>
                        </div>

                        <div class="">
                            <form class="">
                                <div class="form-item">
                                    <label class="form-label font-medium">
                                        Select Shipping Address <span class="ml-1 text-red-500 font-medium">*</span>
                                    </label>
                                    <div class="flex space-x-2 md:space-x-4">
                                        <select class="header-shipping-address form-input w-full">
                                            <option class="text-xs md:text-sm" value="">Select address</option>
                                            @foreach ($userAddress as $address)
                                                <option value="{{ $address->id }}" {{ $cart->address_id == $address->id ? "selected" : '' }}>
                                                    {{ $address->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="header-address-show-dev" class="mt-1 hidden items-center">
                                        <i class="mr-1 text-sm fa-solid fa-location-dot"></i>
                                        <span id="show-address-label" class="text-sm text-primary font-medium"></span>
                                    </div>
                                </div>
                            </form>
                            <h3 class="mt-2 md:mt-2 mb-2 text-base text-center font-bold">Add new address</h3>
                            <form class="mb-0">
                                <div class="grid grid-cols-1">
                                    <div class="form-item">
                                        <label for="" class="form-label">Address Title<span class="ml-1 text-red-500 font-medium">*</span></label>
                                        <select id="address-title" class="form-select form-input w-full">
                                            <option value="">Select</option>
                                            <option value="Home">Home</option>
                                            <option value="Office">Office</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                    <div class="form-item">
                                        <label class="form-label">Alternative Phone Number</label>
                                        <input id="contact-person-number" class="form-input" type="text"
                                            placeholder="Enter Your Phone Number" />
                                    </div>
                                    <div class="form-item">
                                        <label class="form-label">Area<span class="ml-1 text-red-500 font-medium">*</span></label>
                                        <select id="header-area-id" class="form-input">
                                            <option value="" selected>Select</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}">
                                                    {{ $area->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-item">
                                        <label class="form-label">Address<span class="ml-1 text-red-500 font-medium">*</span></label>
                                        <textarea id="address-line" class="form-input" rows="2" cols="50" placeholder="Enter your address here..."></textarea>
                                    </div>
                                    <div class="form-item">
                                        <button id="addredd-create-btn" type="button" class="btn btn-secondary">
                                            Create
                                            <i class="loadding-icon fa-solid fa-spinner fa-spin text-white"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-span-2">
                    <section class="card border-2">
                        <div class="flex flex-col space-y-1 p-2 border rounded-t font-medium text-sm sm:text-sm md:text-base">

                            <div class="mb-4">
                                <div class="flex justify-between border-b-2">
                                    <span>Product 1 x 2</span>
                                    <span>{{ $currency }}
                                        <span class="ml-1">250</span>
                                    </span>
                                </div>

                                <div class="flex justify-between border-b-2">
                                    <span>Product 1 x 2</span>
                                    <span>{{ $currency }}
                                        <span class="ml-1">250</span>
                                    </span>
                                </div>
                            </div>

                            <div class="flex justify-between">
                                <span>Total Price</span>
                                <span>{{ $currency }}
                                    <span id="sub-total-price-label" class="ml-1">500</span>
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span>Discount (-)</span>
                                <span>{{ $currency }}
                                    <input id="input-items-discount" type="hidden" value="">
                                    <span id="items-total-discount-label" class="ml-1">100</span>
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
                                    <span id="sub-total-sell-price-label" class="ml-1">400</span>
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span>Delivery Charge (+)</span>
                                <span>{{ $currency }}
                                    <span id="delivery-charge-lavel" class="ml-1"></span>
                                </span>
                            </div>

                        </div>
                        <div class="bg-[#c03375] p-2 rounded mx-2 mb-2">
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
                        {{-- <section class="mt-4">
                            <div class="card border-2">
                                <div class="header">
                                    <h1 class="title">Select shipping address <span class="text-red-500">*</span> </h1>
                                </div>
                                <div class="p-2">
                                    <div class="flex justify-between items-center">
                                        <div class="flex space-x-2 items-center">
                                            <div class="h-8 w-8 border rounded flex items-center justify-center">
                                                <i class="text-lg text-gray-500 fa-solid fa-location-dot"></i>
                                            </div>
                                            <div class="">
                                                <input type="hidden" class="shipping-address-id" name="address_id"
                                                    value="{{ ($cart->address->id) ?? null }}">
                                                <div id="" class="shipping-address-label text-sm text-gray-500">
                                                    {{ ($cart->address->title) ?? null }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <button id="btn-address-change" type="button" class="ml-2 btn btn-sm sm:btn-sm md:btn-md btn-primary"
                                            data-bs-toggle="modal" @auth data-bs-target="#address-modal" @endauth>
                                            Select
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section> --}}
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
                                    <h1 class="title">Have a coupon code</h1>
                                </div>
                                <div class="px-2 sm:px-2 md:px-2 xl:px-4 py-4">
                                    <div id="apply-coupon-box">
                                        <div class="flex space-x-2">
                                            <div class="flex-1">
                                                <input id="input-coupon-code-id" type="hidden" value="" name="coupon_id">
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
                                        <button type="button" id="btn-order-submit" class="btn btn-md btn-block btn-secondary">
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
        var cartAddItemEndPoint     = '/cart/items/add';
        var cartAddMetaDataEndPoint = '/cart/meta/add';
        var deleteCartItemBtn       = $('.delete-cart-item-btn');
        var iconLoadding            = $('.loadding-icon');
        var iconTrash               = $('.trash-icon');
        var inputCartEmpty          = $('#input-cart-empty');
        var cartInputItemQty        = $('.cart-input-item-qty');
        var btnPaymentMethod        = $('.btn-payment-method');
        var inputDeliveryGateway    = $('#input-delivery-gateway-id');
        var inputPaymentMethod      = $('#input-payment-method-id');
        var btnOrderSubmit          = $('#btn-order-submit');
        var formCheckOut            = $('#form-checkout');
        var subTotalPriceLabel      = $('#sub-total-price-label');
        var cartTotalPriceLabel     = $('#cart-total-price-label');
        var deliveryCharge          = "{{ $deliveryCharge }}";
        var deliveryChargeLabel     = $('#delivery-charge-lavel');
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

        // totalPriceCalculation();

        $(function() {
            // Delete item
            deleteCartItemBtn.click(function() {
                var itemId = $(this).data('item-id');
                var colorId = $(this).data('color-id');
                var sizeId = $(this).data('size-id');

                removeCartItem(itemId, colorId, sizeId, $(this));
            });

            // Empty item
            inputCartEmpty.click(function() {
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
                        __showNotification('error', 'Please checked terms and conditons');
                        return false;
                    }
                } else {
                    __showNotification('error', 'Please select shipping address to continue');
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
                totalPriceCalculation();
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
                    __showNotification('error', response.data.message);
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
                totalPriceCalculation();
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
                totalPriceCalculation();
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
                __showNotification('error', response.data.message);
                return false;
            });
        }

        // Calculate total price
        function totalPriceCalculation() {
            var itemsTotalPrice         = 0;
            var itemTotalDiscount       = 0;
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
            deliveryCharge = parseFloat(deliveryCharge);
            deliveryChargeLabel.text(deliveryCharge.toFixed(2));

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
            deliveryCharge = deliveryCharge - couponAmount;
            applyCouponBox.hide();
            activeCouponBox.show();
            labelCouponCode.text(coupon.code);
            inputCouponCodeId.val(coupon.id);
            discountLabel.text(couponAmount);
            inputItemsDiscount.val(couponAmount)
            var couponCode = coupon.code;
            couponCode     = couponCode.toUpperCase();
            deliveryChargeLabel.text(deliveryCharge.toFixed(2));
            discountLabel.text(0.0);
            inputItemsDiscount.val(0.0);
            totalPriceCalculation();
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
            totalPriceCalculation();
        }
    </script>
@endpush
