@extends('frontend.layouts.default')
@section('title', 'Cart')
@section('content')
    @if (count($products))
        <section class="container page-section page-top-gap">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-3 last:gap-4">
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
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r text-left pl-2">
                                            MRP
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 text-right border-r pr-0 sm:pr-0 md:pr-2">
                                            Discount
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r text-right pr-0 sm:pr-0 md:pr-2">
                                            Price
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 text-center border-r">
                                            Qty
                                        </th>
                                        <th class="text-xs sm:text-xs md:text-sm lg:text-base py-2 sm:py-2 md:py-3 lg:py-4 border-r text-right pr-0 sm:pr-0 md:pr-2">
                                            Total
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
                                            <td class="hidden sm:hidden md:block p-1 w-14 h-14 mx-auto">
                                                <div class="">
                                                    <img class="" src="{{ $product->img_src }}" alt="Product Image">
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
                                                        @if ($key < count($selelctedColors))
                                                            @if (array_key_exists('name', $selelctedColors[$key]))
                                                                {{ $selelctedColors[$key]['name'] }}
                                                            @endif
                                                        @else
                                                            <span class="ml-1">N/A</span>
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="ml-1">N/A</span>
                                                @endif
                                            </td>
                                            <td class="text-xs md:text-sm lg:text-base border text-primary font-medium text-center sm:text-center md:text-right lg:text-right xl:text-right 2xl:text-right pr-1 sm:pr-1 md:pr-2">
                                                @if ($product->pivot->size_id)
                                                    <span class="ml-1">
                                                        @if ($key < count($selelctedSizes))
                                                            @if (array_key_exists('name', $selelctedSizes[$key]))
                                                                {{ $selelctedSizes[$key]['name'] }}
                                                            @endif
                                                        @else
                                                            <span class="ml-1">N/A</span>
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="ml-1">N/A</span>
                                                @endif
                                            </td>
                                            <td class="text-xs md:text-sm lg:text-base border text-primary font-medium text-center sm:text-center md:text-right lg:text-right xl:text-right 2xl:text-right pr-1 sm:pr-1 md:pr-2">
                                                <span class="ml-1">
                                                    {{ $product->pivot->item_mrp }}
                                                </span>
                                            </td>
                                            <td class="text-xs sm:text-xs md:text-sm lg:text-base border text-primary font-medium text-right pr-1 sm:pr-1 md:pr-2">
                                                <span id="total-discount-{{ $product->pivot->item_id }}" class="sub-total-discount ml-1">
                                                    <span id="discount-show-{{ $product->pivot->item_id}}">
                                                        {{ $product->pivot->item_discount }}
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="text-xs md:text-sm lg:text-base border text-primary font-medium text-center sm:text-center md:text-right lg:text-right xl:text-right 2xl:text-right pr-1 sm:pr-1 md:pr-2">
                                                <span class="ml-1">
                                                    {{ $product->pivot->item_sell_price }}
                                                </span>
                                            </td>
                                            <td width="70px" class="text-xs md:text-sm lg:text-base text-center border px-2">
                                                {{-- <select class="cart-input-item-qty rounded text-xs md:text-sm lg:text-base py-1" name=""
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
                                                </select> --}}





                                                {{-- input item quantity --}}
                                                @php
                                                    $productId = $product->id;
                                                    $colorId   = $product->pivot->color_id;
                                                    $sizeId    = $product->pivot->size_id;
                                                    $sellPrice = $product->pivot->item_sell_price;
                                                @endphp
                                                <div class="flex items-center border rounded border-gray-300" style="height: 32px">
                                                    <button
                                                        data-input-product-id="{{ $productId }}"
                                                        data-input-color-id="{{ $colorId }}"
                                                        data-input-size-id="{{ $sizeId }}"
                                                        data-input-sell-price="{{ $sellPrice }}"
                                                        class="btn-input-minus w-8 h-8 border-r border-gray-300">
                                                        <i class="fa-solid fa-minus text-gray-500"></i>
                                                    </button>
                                                    <div>
                                                        <input id="input-quantity-{{ $productId }}-{{ $colorId }}-{{ $sizeId }}"
                                                            class="qty-input text-center text-gray-500 border-none focus:outline-none focus:ring-0"
                                                            style="width: 45px; height:28px" type="text" name=""
                                                            value="{{ $product->pivot->quantity }}" value="1"
                                                            min="1" readonly>
                                                    </div>
                                                    <button
                                                        data-input-product-id="{{ $productId }}"
                                                        data-input-color-id="{{ $colorId }}"
                                                        data-input-size-id="{{ $sizeId }}"
                                                        data-input-sell-price="{{ $sellPrice }}"
                                                        class="btn-input-plus w-8 h-8 border-l border-gray-300">
                                                        <i class="fa-solid fa-plus text-gray-500"></i>
                                                    </button>
                                                </div>




                                            </td>
                                            <td class="text-xs sm:text-xs md:text-sm lg:text-base border text-primary font-medium text-right pr-1 sm:pr-1 md:pr-2">
                                                @php
                                                    $itemTotalSellPrice = $product->pivot->item_sell_price * $product->pivot->quantity;
                                                    $itemTotalSellPrice = number_format((float)$itemTotalSellPrice, 2);
                                                @endphp
                                                <span
                                                    id="item-sell-price-label-{{ $productId }}-{{ $colorId }}-{{ $sizeId }}"
                                                    class="item-sell-price ml-1">
                                                    {{ ($itemTotalSellPrice) }}
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
                                    </a>
                                        <i class="loadding-icon fa-solid fa-spinner fa-spin mr-2"></i>
                                </button>
                            </div>
                            <div class="">
                                <button id="input-cart-empty" class="btn btn-md btn-danger">
                                    Clear cart
                                    <i class="ml-2 trash-icon text-white fa-regular fa-trash-can"></i>
                                    <i class="loadding-icon fa-solid fa-spinner fa-spin mr-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-1">
                    <section class="">
                        <div class="card border-2">
                            <div class="px-4 py-2">

                                <div class="p-2 rounded">
                                    <div class="flex justify-between font-medium">
                                        <span class="text-base sm:text-base md:text-lg">Total</span>
                                        <span class="text-base sm:text-base md:text-lg font-medium">
                                            <span>{{ $currency }}
                                                <span id="total-sell-price-label" class="ml-1">
                                                    {{ number_format($cartTotalSellPrice, 2) }}
                                                </span>
                                            </span>
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('checkout') }}" id="btn-order-submit" class="btn btn-md btn-block btn-primary">
                                        <i class="loadding-icon fa-solid fa-spinner fa-spin mr-2"></i>
                                        Checkout
                                    </a>
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
        var btnAddressChangeCart = $('#btn-address-change');
        var btnContinueShopping  = $('#btn-shopping-continue');
        // Coupon code
        var itemsTotalDiscountLabel = $('#items-total-discount-label');
        var totalSellPriceLabel  = $('#total-sell-price-label');
        var inputItemsDiscount      = $('#input-items-discount');
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
            });

            // On choose payment method
            btnPaymentMethod.click(function() {
                btnPaymentMethod.removeClass('active');
                $(this).addClass('active');

                var paymentID = $(this).data('payment-method-id');
                inputPaymentMethod.val(paymentID);
                addCartMetaData('pg_id', paymentID);
            });

            btnOrderSubmit.click(function () {
                $(this).find(iconLoadding).show();
            });


            btnContinueShopping.click( function() {
                $(this).find(iconLoadding).show();
            });
        });

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
            var totalSellPrice = 0;
            $(".item-sell-price").each(function() {
                var itemSellPrice = parseFloat($(this).text());
                totalSellPrice = totalSellPrice + itemSellPrice;
            });

            totalSellPrice = totalSellPrice.toFixed(2);
            totalSellPriceLabel.text(totalSellPrice);
        }
    </script>

    <script>
        var btnInputMinus = $('.btn-input-minus');
        var btnInputPlus  = $('.btn-input-plus');

        $(function() {
            btnInputMinus.on('click', function() {
                changeCountNumber($(this), 'minus');
            });

            btnInputPlus.on('click', function() {
                changeCountNumber($(this), 'plus');
            });
        });

        function changeCountNumber(actionOn, action = 'minus') {
            var productId = actionOn.data('input-product-id');
            var sellPrice = actionOn.data('input-sell-price');
            var colorId   = actionOn.data('input-color-id');
            var sizeId    = actionOn.data('input-size-id');
            var itemSellPriceLabel = $(`#item-sell-price-label-${productId}-${colorId}-${sizeId}`);

            console.log('product id '+ productId);
            console.log('color id '+ colorId);
            console.log('size id '+ sizeId);

            var inputQuantity  = $(`#input-quantity-${productId}-${colorId}-${sizeId}`);
            var quantity   = inputQuantity.val();

            if (action === 'minus' && quantity > 1) {
                quantity--;
                var itemTotalSellPrice = parseFloat(sellPrice * quantity);
                itemSellPriceLabel.text(itemTotalSellPrice.toFixed(2));

                addCartItem(productId, quantity, colorId, sizeId);
            }

            if (action === 'plus') {
                quantity++;
                var itemTotalSellPrice = parseFloat(sellPrice * quantity);
                itemSellPriceLabel.text(itemTotalSellPrice.toFixed(2));

                addCartItem(productId, quantity, colorId, sizeId);
            }

            inputQuantity.val(quantity);
        }

    </script>
@endpush
