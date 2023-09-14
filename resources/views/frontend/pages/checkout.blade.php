@extends('frontend.layouts.default')
<style>
    .form-otline-none:focus {
        outline: none !important;
        border: none !important;
        border-color: transparent !important;
        box-shadow: none !important;
    }
</style>
@section('title', 'Checkout')
@section('content')
    @if (count($products))
        <section class="container page-section page-top-gap">
            <div
                class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-5 xl:grid-cols-5 2xl:grid-cols-5 last:gap-4">
                <div class="col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-3 xl:col-span-3 2xl:col-span-3">
                    <div class="card border-2 p-4">
                        <div class="">
                            <div class="mt-2 md:mt-2 mb-2 text-base text-center font-bold mx-auto lg:mb-6">
                                <h2>Shipping Adress (Please fill out your information)</h2>
                            </div>

                            <form class="mb-0" id="order-submit-form" action="{{ route('my.order.store') }}" method="POST">
                                @csrf

                                <div class="flex flex-col mb-5 sm:flex-row md:flex-row space-x-2">
                                    @foreach ($userAddress as $uAddress)
                                        <div class="border p-2 text-sm w-full">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <input id="{{ $uAddress->id }}"
                                                        class="input-shipping-address w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                        type="radio" value="{{ $uAddress->id }}"
                                                        name="shipping_address_id"
                                                        data-shipping-charge="{{ $uAddress->district->delivery_charge ?? 0 }}">
                                                    <label for="default-radio-1"
                                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                        {{ $uAddress->title }}
                                                    </label>
                                                </div>
                                                <a href="{{ route('my.address.edit', $uAddress->id) }}"
                                                    class="btn btn-primary btn-xs items-end">Edit</a>
                                            </div>
                                            <div>{{ $uAddress->address }}</div>
                                            <div>{{ $uAddress->district->name ?? '' }}</div>
                                            <div>{{ $uAddress->user_name }}</div>
                                            <div>{{ $uAddress->phone_number }}</div>
                                            <div>{{ $uAddress->phone_number_2 }}</div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="grid grid-cols-1">
                                    <div style="width:97%" class="form-item">
                                        <fieldset class="border first-letter:rounded shadow-md">
                                            <legend style="color: rgb(0 121 140 / var(--tw-bg-opacity));"
                                                class="text-sm font-semibold ml-2 md:ml-4 lg:ml-4 2xl:ml-4">Pick Up your
                                                parcel From :
                                            </legend>
                                            <select id="input-address-title" name="title"
                                                class="form-select form-input border-0 w-full form-otline-none">
                                                <option value="" disabled selected>Select</option>
                                                <option value="Home">Home</option>
                                                <option value="Office">Office</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </fieldset>

                                        @error('title')
                                            <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1">
                                    <div style="width:97%" class="form-item">
                                        <fieldset class="border first-letter:rounded shadow-md">
                                            <legend style="color: rgb(0 121 140 / var(--tw-bg-opacity));"
                                                class="text-sm font-semibold ml-2 md:ml-4 lg:ml-4 2xl:ml-4">Name:
                                            </legend>
                                            <input class="form-input border-0 w-full form-otline-none" type="text"
                                                name="user_name" />
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2">
                                    <div style="width:95%" class="form-item">
                                        <fieldset class="border first-letter:rounded shadow-md">
                                            <legend style="color: rgb(0 121 140 / var(--tw-bg-opacity));"
                                                class="text-sm font-semibold ml-2 md:ml-4 lg:ml-4 2xl:ml-4">
                                                Districs<span class="ml-1 text-red-500 font-medium">*</span></legend>
                                            <select id="input-address-district" name="district_id"
                                                class="form-select form-input border-0 w-full form-otline-none">
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}"
                                                        {{ $district->id == 1 ? 'selected' : '' }}
                                                        data-delivery-charge="{{ $district->delivery_charge }}">
                                                        {{ $district->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </fieldset>

                                        @error('district_id')
                                            <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div style="width:95%" class="form-item">
                                        <fieldset class="border first-letter:rounded shadow-md">
                                            <legend style="color: rgb(0 121 140 / var(--tw-bg-opacity));"
                                                class="text-sm font-semibold ml-2 md:ml-4 lg:ml-4 2xl:ml-4">Thana:
                                            </legend>
                                            <input class="form-input border-0 w-full form-otline-none" type="text"
                                                name="thana" />
                                        </fieldset>
                                        @error('thana')
                                            <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div style="width:95%" class="form-item">
                                        <fieldset class="border first-letter:rounded shadow-md">
                                            <legend style="color: rgb(0 121 140 / var(--tw-bg-opacity));"
                                                class="text-sm font-semibold ml-2 md:ml-4 lg:ml-4 2xl:ml-4">Phone
                                                Number:<span class="ml-1 text-red-500 font-medium">*</span></legend>
                                            <input class="form-input border-0 w-full form-otline-none" type="text"
                                                name="phone_number" />
                                        </fieldset>
                                        @error('phone_number')
                                            <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div style="width:95%" class="form-item">
                                        <fieldset class="border first-letter:rounded shadow-md">
                                            <legend style="color: rgb(0 121 140 / var(--tw-bg-opacity));"
                                                class="text-sm font-semibold ml-2 md:ml-4 lg:ml-4 2xl:ml-4">Phone
                                                Number(2):
                                            </legend>
                                            <input class="form-input border-0 w-full form-otline-none" type="text"
                                                name="phone_number_2" />
                                        </fieldset>
                                        @error('phone_number_2')
                                            <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1">
                                    <div style="width:97%" class="form-item">
                                        <fieldset class="border first-letter:rounded shadow-md">
                                            <legend style="color: rgb(0 121 140 / var(--tw-bg-opacity));"
                                                class="text-sm font-semibold ml-2 md:ml-4 lg:ml-4 2xl:ml-4">Full
                                                Address:
                                            </legend>
                                            <textarea id="input-address" name="address" class="form-input border-0 w-full form-otline-none" rows="2"
                                                cols="50"></textarea>
                                        </fieldset>
                                        @error('address')
                                            <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-2">
                    <section class="card border-2">
                        <h2 class="p-2 text-2xl font-bold">Checkout Summary</h2>
                        <div
                            class="flex flex-col space-y-1 p-2 border rounded-t font-medium text-sm sm:text-sm md:text-base">


                            <div class="flex justify-between capitalize">
                                <span>Sub Total</span>
                                <span>{{ $currency }}
                                    <span class="ml-1">
                                        {{ number_format($cart->getTotalMRP(), 2) }}
                                    </span>
                                </span>
                            </div>

                            {{-- Show total discount --}}
                            <div class="flex justify-between capitalize">
                                <span>Discount (-)</span>
                                <span>{{ $currency }}
                                    <input type="hidden" value="">
                                    <span class="ml-1">
                                        {{ number_format($cart->getTotalDiscount(), 2) }}
                                    </span>
                                </span>
                            </div>

                            {{-- Show sell price --}}
                            <div class="flex justify-between capitalize">
                                <span>Total Price(-Discount)</span>
                                <span>{{ $currency }}
                                    <span class="ml-1">
                                        {{ number_format($cart->getTotalSellPrice(), 2) }}
                                    </span>
                                </span>
                            </div>

                            {{-- Show coupon discount --}}
                            <div id="coupon-discount-div" class="hidden">
                                <div class="flex justify-between capitalize">
                                    <span>Coupon Discount (-)</span>
                                    <span>{{ $currency }}
                                        <input type="hidden" value="">
                                        <span id="coupon-discount-label" class="ml-1">0.00</span>
                                    </span>
                                </div>
                            </div>

                            {{-- Show delivery charge --}}
                            <div class="flex justify-between capitalize">
                                <span>Delivery Charge (+)</span>
                                <span>{{ $currency }}
                                    <span id="delivery-charge-label" class="ml-1">
                                        {{ number_format($defaultDeliveryCharge, 2) }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        {{-- Show payable price --}}
                        <div class="p-2 rounded mx-2 mb-2">
                            <div class="flex justify-between text-black font-medium capitalize">
                                <span class="text-base sm:text-base md:text-lg">Total</span>
                                <span class="text-base sm:text-base md:text-lg font-medium">
                                    <span>{{ $currency }}
                                        <span id="total-with-delivery-charge-label" class="ml-1">
                                            {{ number_format($cart->getTotalSellPrice() + $defaultDeliveryCharge, 2) }}
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </section>

                    {{-- hidden field for shipping address --}}
                    <input id="input-shipping-address-id" type="hidden" name="address_id" value="">

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
                                            {{-- Hidden input for coupon code --}}
                                            <input id="input-coupon-code-id" type="hidden" value=""
                                                name="coupon_id">

                                            <input id="input-coupon-code"
                                                class="w-full focus:outline-none focus:ring-0 focus:border-primary-light text-gray-500 border-gray-500 p-1.5 px-4 rounded border placeholder:text-sm m-0"
                                                placeholder="Enter coupon code">
                                        </div>
                                        <button id="btn-check-coupon" type="button"
                                            class="btn btn-md btn-primary">Apply</button>
                                    </div>
                                </div>
                                <div id="active-coupon-box" class="hidden">
                                    <div
                                        class="bg-green-100 rounded-md p-1 border border-green-600 text-green-600 flex justify-between items-center">
                                        <span class="text-sm">
                                            <span class="label-coupon-code font-medium ml-2 uppercase"></span>
                                            &nbsp;Applied
                                        </span>
                                        <button type="button" id="btn-remove-coupon-code"
                                            class="p-1 text-red-600 text-sm" title="Remove coupon">Remove</button>
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
                                    <textarea name="order_note"
                                        class="w-full mt-1 focus:outline-none focus:ring-0 text-sm text-gray-500 placeholder:text-gray-400 placeholder:text-sm border-gray-500 rounded"></textarea>
                                </div>
                                <h2 class="mt-4">Payment Method : <span
                                        style="color: rgb(0 121 140 / var(--tw-bg-opacity));">Cash
                                        On
                                        Delivery</span></h2>
                                <div style="background-color: #00ffff1f" class="mt-4 mb-4 p-2 rounded-sm">
                                    <p class="text-xs mb-1">আপনার অবগতির জন্য জানানো যাচ্ছে যে,</p>
                                    <p class="text-xs">১.ডেলিভারী চার্জ - </p>
                                    <p class="indent-8 text-xs">ঢাকার মধ্যে - ৬০ টাকা</p>
                                    <p class="indent-8 text-xs">ঢাকার বাইরে - ১০০ টাকা</p>

                                    <p class="text-xs mt-2 mb-2">
                                        ২.প্রোডাক্ট রিটার্ন করলে ডেলিভারী চার্জ দিয়ে রিটার্ন করতে হবে।
                                    </p>

                                    <p class="text-xs mt-2 mb-2">
                                        ৩.ডেলিভারী ম্যান থাকা অবস্থায় ভালভাবে চেক করে রিসিভ করবেন। <br>
                                        অন্যথায় ডেলিভারী ম্যান চলে যাওয়ার পর কোন অভিযোগ গ্রহণ বা রিটার্ন নেওয়া হবে না।
                                    </p class="text-sm">

                                    <input class="focus:ring-0" type="checkbox" value="1" name="terms_conditons">
                                    <span class="text-gray-500 text-xs">
                                        এই শর্তগুলো মেনে
                                        <a href="{{ route('terms.and.condition') }}" class="text-primary"> অর্ডার
                                            প্রদান করছি </a>,
                                    </span>
                                </div>


                                <div class="mt-4">
                                    <button type="button" id="btn-order-submit"
                                        class="btn btn-md btn-block btn-primary">
                                        <i class="loadding-icon hidden fa-solid fa-spinner fa-spin mr-2"></i>
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
                        <h1 class="text-2xl sm:text-2xl md:text-3xl lg:text-4xl font-medium tracking-wide text-primary">
                            Your cart is empty</h1>
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
        var iconLoadding = $('.loadding-icon').hide();
        var btnOrderSubmit = $('#btn-order-submit');
        var orderSubmitForm = $('#order-submit-form');
        var btnCreateNewAddress = $('#btn-create-new-address');
        var cartTotalSellPrice = "{{ $cart->getTotalSellPrice() }}";
        var deliveryCharge = "{{ $defaultDeliveryCharge }}";
        var deliveryChargeLabel = $('#delivery-charge-label');
        var totalWithDeliveryChargeLabel = $('#total-with-delivery-charge-label');

        // For address create
        var addressCreateForm = $('#address-create-form');
        var inputShippingAddress = $('.input-shipping-address');
        var inputShippingAddressId = $('#input-shipping-address-id');
        var inputAddressDistrict = $('#input-address-district');

        // Coupon code
        var couponDiscount = 0;
        var inputCouponCode = $('#input-coupon-code');
        var btnApplyCoupon = $('#btn-check-coupon');
        var applyCouponBox = $('#apply-coupon-box');
        var activeCouponBox = $('#active-coupon-box');
        var labelCouponCode = $('.label-coupon-code');
        var btnRemoveCouponCode = $('#btn-remove-coupon-code');
        var inputCouponCodeId = $('#input-coupon-code-id');
        var couponDiscountLabel = $('#coupon-discount-label');
        var couponDiscountDiv = $('#coupon-discount-div');

        $(function() {
            inputShippingAddress.click(function() {
                var addressId = $('input[name="shipping_address_id"]:checked').val();
                deliveryCharge = $(this).data('shipping-charge');

                inputShippingAddressId.val(addressId)
                totalPriceCalculation();
            });

            inputAddressDistrict.on('change', function() {
                var selectedOption = $(this).find(":selected");
                // Get the value of the data-delivery-charge attribute
                deliveryCharge = selectedOption.data("delivery-charge");
                totalPriceCalculation();
            });

            btnOrderSubmit.click(function() {
                try {
                    var checked = $('input[name=terms_conditons]:checked').val();

                    if (!checked) {
                        __showNotification('error', 'Please check terms and conditions');
                        return false;
                    }

                    $(this).find(iconLoadding).show();
                    orderSubmitForm.submit();
                } catch (error) {
                    console.log(error);
                } finally {
                    $(this).find(iconLoadding).hide();
                }
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

            btnCreateNewAddress.click(function() {
                addressCreateForm.show();
            });
        });

        // Check coupon code function
        function applyCouponCode(couponCode) {
            var endpoint = "{{ route('coupon.check') }}";
            axios.post(endpoint, {
                    coupon_code: couponCode
                })
                .then((response) => {
                    if (response.data.success) {
                        var coupon = response.data.result;
                        calculateCouponValue(coupon);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }

        // Calculate total price
        function totalPriceCalculation() {
            cartTotalSellPrice = parseFloat(cartTotalSellPrice);
            deliveryCharge = parseFloat(deliveryCharge);

            var totalWithDeliveryCharge = cartTotalSellPrice + deliveryCharge;
            couponDiscount = parseFloat(couponDiscount);
            totalWithDeliveryCharge = totalWithDeliveryCharge - couponDiscount;

            deliveryChargeLabel.text(deliveryCharge.toFixed(2));
            totalWithDeliveryChargeLabel.text(totalWithDeliveryCharge.toFixed(2));
        }

        function removedCouponCode() {
            applyCouponBox.show();
            activeCouponBox.hide();
            inputCouponCodeId.val('');
            inputCouponCode.val('');
            couponDiscountLabel.text('0.00');
            couponDiscountDiv.hide();
            couponDiscount = 0;
            totalPriceCalculation();
        }

        function calculateCouponValue(coupon) {
            cartTotalSellPrice = parseFloat(cartTotalSellPrice);
            if (coupon.discount_type == 'fixed') {
                couponDiscount = coupon.discount_amount;
            } else {
                var couponPercent = coupon.discount_amount;
                couponDiscount = (cartTotalSellPrice * couponPercent) / 100;
            }
            couponDiscount = parseFloat(couponDiscount);
            applyCouponBox.hide();
            activeCouponBox.show();
            labelCouponCode.text(coupon.code);
            inputCouponCodeId.val(coupon.id);
            couponDiscountDiv.show();
            couponDiscountLabel.text(couponDiscount.toFixed(2));
            totalPriceCalculation();
        }
    </script>
@endpush
