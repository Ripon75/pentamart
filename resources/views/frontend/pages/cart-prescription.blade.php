@extends('frontend.layouts.default')
@section('title', 'Prescription upload')
<form action="{{ route('prescription.store') }}" method="POST" enctype="multipart/form-data" id="form-checkout">
    @csrf

    @section('content')

    <!--========Cart page Banner========-->
    <section class="page-top-gap">
        <x-frontend.header-title height="250px" bgColor="linear-gradient( #112f7a, rgba(111, 111, 211, 0.52))"
            bgImageSrc="/images/banners/cart-banner.png" title="Shopping Cart" />
    </section>
    <section class="container page-section">
        <div
            class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3 last:gap-8">
            <div class="col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-2 xl:col-span-2 2xl:col-span-2">
                {{-- ===============prescription upload================== --}}
                <section class="mt-4">
                    @if (Session::has('message'))
                        <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                    @endif
                    <div class="card border-2">
                        <div class="header">
                            <h1 class="title">Upload prescriptions
                                <i class="ml-3 fa-solid fa-file-arrow-up"></i>
                                <span class="text-red-500 text-xl ml-2">*</span>
                            </h1>
                        </div>
                        <div class="px-4 py-2">
                            <input name="files[]" multiple type="file" class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border
                                file:border-secondary/50
                                file:text-sm file:font-medium
                                file:bg-violet-50 file:text-secondary
                                hover:file:bg-violet-100
                            "/>
                        </div>
                        @error('files')
                        <span class="text-red-500 text-sm p-2">{{ $message }}</span>
                        @enderror
                    </div>
                </section>
            </div>

            <div class="col-span-1">
                {{-- ========Choose Delivery Type===== --}}
                <section class="mt-4">
                    <div class="card border-2">
                        <div class="header">
                            <h1 class="title">Choose Delivery Type <i class="ml-3 fa-solid fa-truck-fast"></i></h1>
                        </div>
                        <div class="p-2 flex space-x-2">
                            <input type="hidden" id="input-delivery-gateway-id" value="{{ $deliveryGateways[0]->id }}"
                                name="delivery_gateway_id">
                            @for ($i=0 ; $i < count($deliveryGateways) ; $i++) <button type="button"
                                data-delivery-gateway-price="{{ $deliveryGateways[$i]->price }}"
                                data-delivery-gateway-id="{{ $deliveryGateways[$i]->id }}"
                                class="btn-delivery-gateway {{ $i === 0 ? 'active' : '' }}">
                                <span class="text-sm tracking-wide font-bold">{{ $deliveryGateways[$i]->name }}</span>
                                <span class="text-xs">
                                    {{ $deliveryGateways[$i]->min_delivery_time }} to
                                    {{ $deliveryGateways[$i]->max_delivery_time }}
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
                                            Select Shipping Address <span class="text-red-500 text-xl">*</span>
                                        </div>
                                        <input type="hidden" class="shipping-address-id" name="shipping_address_id"
                                            value="{{ ($cart->userAddress->id) ?? null }}">
                                        <div id="shipping-address-title" class="shipping-address-label text-sm text-gray-500">
                                            {{ ($cart->userAddress->title) ?? null }}
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <button id="btn-address-change-pres" type="button" class="ml-2 btn btn-sm sm:btn-sm md:btn-md btn-secondary"
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

                {{-- ===============Checkout================== --}}
                <section class="mt-4">
                    <div class="card border-2">
                        <div class="px-4 py-2">
                            <div class="mt-4">
                                <label for="">Write note</label><br>
                                <textarea name="note"
                                    class="w-full focus:outline-none focus:ring-0 text-sm text-gray-500 placeholder:text-gray-400 placeholder:text-sm border-gray-500 rounded"></textarea>
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
                                    <i id="prescription-upload-loaddin-icon" class="fa-solid fa-spinner fa-spin mr-2"></i>
                                    SUBMIT ORDER
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</form>
@endsection

@push('scripts')
    <script>
        var cartAddMetaDataEndPoint = '/cart/meta/add';
        var btnDeliveryGateway      = $('.btn-delivery-gateway');
        var btnPaymentMethod        = $('.btn-payment-method');
        var inputDeliveryGateway    = $('#input-delivery-gateway-id');
        var btnAddressChangePres    = $('#btn-address-change-pres');
        var btnOrderSubmit          = $('#btn-order-submit');
        var formCheckOut            = $('#form-checkout');
        var inputPaymentMethod      = $('#input-payment-method-id');
        var pUploadLoddingIcon      = $('#prescription-upload-loaddin-icon');
        var addressModal         = $('#address-modal');
        // disable order submit button
        btnOrderSubmit.prop("disabled", true);
        btnOrderSubmit.addClass('disabled:opacity-50');
        pUploadLoddingIcon.hide();

        $(function() {
            // Set time to flash message
            setTimeout(function(){
                $("div.alert").remove();
            }, 5000 );

            // On Choose Delivery Type item
            btnDeliveryGateway.click(function() {
                btnDeliveryGateway.removeClass('active');
                $(this).addClass('active');
                var gatewayID    = $(this).data('delivery-gateway-id');
                inputDeliveryGateway.val(gatewayID);
            });

            // event with address change
            btnAddressChangePres.click(function () {
                addressModal.show();
            });

            btnOrderSubmit.click(function () {
                var addressID = $('.header-shipping-address').find(":selected").val();
                if (addressID) {
                    formCheckOut.submit();
                } else {
                    __showNotification('error', 'Please select shipping address to continue', 1000);
                    return false;
                }
                pUploadLoddingIcon.show();
            });

            // On choose payment method
            btnPaymentMethod.click(function() {
                btnPaymentMethod.removeClass('active');
                $(this).addClass('active');

                var paymentID = $(this).data('payment-method-id');
                inputPaymentMethod.val(paymentID);
                __addCartMetaData('payment_method_id', paymentID);
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
        });

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
                __showNotification('error', response.data.message, 1000);
                return false;
            });
        }
    </script>
@endpush

