@extends('adminend.layouts.default')
@section('title', 'Orders')
@section('content')
<section class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Orders</h6>
        <div class="actions">
            <a href="{{ route('admin.orders.index') }}" class="action btn btn-primary">Orders</a>
        </div>
    </div>

    <div class="page-content">
        {{-- Show success or error message --}}
        <div class="col-span-12 mb-5">
            @if(Session::has('success'))
                <div class="alert success">{{ Session::get('success') }}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert error">{{ Session::get('error') }}</div>
            @endif
        </div>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-12 gap-1">
                <div class="card shadow body p-2 col-span-2">
                     <div class="form-item">
                        <label class="form-label">
                            Payment Status <span class="text-red-500 font-medium">*</span>
                        </label>
                        <select class="form-select form-input w-full" name="is_paid">
                            <option value="1" {{ $order->is_paid == 1 ? 'selected' : '' }}>Paid</option>
                            <option value="0" {{ $order->is_paid == 0 ? 'selected' : '' }}>Unpaid</option>
                        </select>
                    </div>

                    <div class="form-item w-full mt-4">
                        {{-- Hidden input --}}
                        <input id="input-order-id" type="hidden" value="{{ $order->id }}">
                        <input type="hidden" name="shipping_id" value="{{ $order->shippingAddress->id ?? null }}">

                        <label for="" class="form-label">
                            Order Status <span class="text-red-500 font-medium">*</span>
                        </label>
                        <select id="input-order-status" class="form-select form-input w-full" name="status_id">
                            <option value="">Select Status</option>
                            @foreach ($orderStatus as $status)
                                <option value="{{ $status->id }}" {{ $order->status_id == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_id')
                            <span class="form-helper error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-item">
                        <label class="form-label">
                            Address <span class="text-red-500 font-medium">*</span>
                        </label>
                        <textarea id="input-shipping-address" class="form-input" type="text" name="address">{{ $order->shippingAddress->address ?? null }}</textarea>
                        @error('address')
                            <span class="form-helper error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-item w-full">
                        <label class="form-label">Alternative Phone Number</label>
                        <input id="input-alternative-phone-number" class="form-input" type="number"
                            name="phone_number"
                            value="{{ $order->shippingAddress->phone_number ?? null }}" autocomplete="off"/>
                   </div>

                    <div class="form-item w-full">
                       <label class="form-label">
                            District <span class="text-red-500 font-medium">*</span>
                        </label>
                       <select id="input-area-id" class="form-input select-2-districts" name="district_id">
                           <option value="">Select district</option>
                           @foreach ($districts as $district)
                               <option
                                   value="{{ $district->id }}"
                                   @if ($order->shippingAddress)
                                        {{ $order->shippingAddress->district_id == $district->id ? "selected" : '' }}
                                   @endif
                                   >
                                   {{ $district->name }}
                               </option>
                           @endforeach
                           @error('district_id')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                       </select>
                   </div>
                </div>

                 <!-- Product add section -->
                <div class="card shadow body p-2 col-span-10">
                    {{-- Search and select product --}}
                    <div class="flex space-x-2 mb-4">
                        <div class="flex-1">
                            <x-adminend.product-search/>
                        </div>
                        <div class="w-30">
                            <select id="input-product-color-id" class="rounded-md">

                            </select>
                        </div>
                        <div class="w-30">
                            <select id="input-product-size-id" class="rounded-md">

                            </select>
                        </div>
                        <div class="w-30">
                            <select id="input-product-qty" class="rounded-md">
                                @for ($i = 1; $i<=10; $i++)
                                    <option value="{{ $i }}" >{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <button id="btn-add-product"
                            type="button"
                            data-mdb-ripple="true"
                            data-mdb-ripple-color="light"
                            class="btn btn-success w-32">Add
                        </button>
                    </div>
                    <div class="">
                        {{-- Product render table --}}
                        <table class="table-auto w-full">
                            <thead class="">
                                <tr class="bg-gray-100">
                                    <th class="text-left border p-2 w-20">Image</th>
                                    <th class="text-left border p-2">Name</th>
                                    <th class="text-right border p-2 w-20">Color</th>
                                    <th class="text-right border p-2 w-20">Size</th>
                                    <th class="text-right border p-2 w-20">Qty</th>
                                    <th class="text-right border p-2 w-20">MRP</th>
                                    <th class="text-right border p-2 w-20">Price</th>
                                    <th class="text-right border p-2 w-20">Dis.</th>
                                    <th class="text-right border p-2 w-28">Total</th>
                                    <th class="text-center border p-2 w-20">Action</th>
                                </tr>
                            </thead>
                            <tbody class="items-table-body">
                                @foreach ($order->items as $key => $item)
                                    <tr class="hover:bg-gray-50 transition duration-300 ease-in-out">
                                        <input type="hidden" name="items[{{ $item->id }}][{{ $item->pivot->color_id }}][{{ $item->pivot->size_id }}][product_id]" value="{{ $item->pivot->item_id }}">
                                        <input type="hidden" name="items[{{ $item->id }}][{{ $item->pivot->color_id }}][{{ $item->pivot->size_id }}][buy_price]" value="{{ $item->pivot->item_buy_price }}">
                                        <input type="hidden" name="items[{{ $item->id }}][{{ $item->pivot->color_id }}][{{ $item->pivot->size_id }}][mrp]" value="{{ $item->pivot->item_mrp }}">
                                        <input type="hidden" name="items[{{ $item->id }}][{{ $item->pivot->color_id }}][{{ $item->pivot->size_id }}][sell_price]" value="{{ $item->pivot->item_sell_price }}">
                                        <input type="hidden" name="items[{{ $item->id }}][{{ $item->pivot->color_id }}][{{ $item->pivot->size_id }}][discount]"value="{{ $item->pivot->item_discount }}">
                                        @php
                                            $itemQty       = $item->pivot->quantity;
                                            $itemMrpPrice  = $item->pivot->item_mrp;
                                            $itemSellPrice = $item->pivot->item_sell_price;
                                            $itemDiscount  = $item->pivot->item_discount;
                                        @endphp
                                        <input id="eo-item-discount-{{ $item->id }}" type="hidden" value="{{ $itemDiscount }}">

                                        <td class="text-center border p-2" style="width: 70px; height:40px">
                                            <img src="{{ $item->img_src }}" alt="Product Image">
                                        </td>
                                        <td class="border p-2 text-sm">{{ $item->name }}</td>
                                        <td class="border p-2 text-sm">
                                            <select
                                                name="items[{{ $item->id }}][{{ $item->pivot->color_id }}][{{ $item->pivot->size_id }}][color_id]"
                                                class="border-gray-300 focus:ring-0 focus:outline-none text-center rounded">
                                                <option value="1">Select</option>
                                                @foreach ($item->colors as $color)
                                                    <option value="{{ $color->id }}" {{ $color->id == $item->pivot->color_id ? 'selected' : '' }}>
                                                        {{ $color->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border p-2 text-sm">
                                            <select
                                                name="items[{{ $item->id }}][{{ $item->pivot->color_id }}][{{ $item->pivot->size_id }}][size_id]"
                                                class="border-gray-300 focus:ring-0 focus:outline-none text-center rounded">
                                                <option value="1">Select</option>
                                                @foreach ($item->sizes as $size)
                                                    <option value="{{ $size->id }}" {{ $size->id == $item->pivot->size_id ? 'selected' : '' }}>
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border p-2 text-right">
                                            <select
                                                data-index="{{ $key }}"
                                                data-item-id="{{ $item->id }}"
                                                data-color-id="{{ $item->pivot->color_id }}"
                                                data-size-id="{{ $item->pivot->size_id }}"
                                                data-sell-price="{{ $itemSellPrice }}"
                                                name="items[{{ $item->id }}][{{ $item->pivot->color_id }}][{{ $item->pivot->size_id }}][quantity]"
                                                value="{{ $item->pivot->quantity }}"
                                                class="input-item-qty border-gray-300 focus:ring-0 focus:outline-none text-center rounded">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $i == $item->pivot->quantity ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td class="border p-2 text-right">
                                            <span class="ml-1">{{ ($itemMrpPrice) }}</span>
                                        </td>
                                        <td class="border p-2 text-right">
                                            <span class="ml-1">{{ ($itemSellPrice) }}</span>
                                        </td>
                                        <td class="border p-2 text-right">
                                            <span
                                                id="item-discount-label-{{ $item->id }}-{{ $item->pivot->color_id }}-{{ $item->pivot->size_id }}"
                                                class="ml-1">
                                                {{ number_format($itemDiscount * $itemQty, 2)}}
                                            </span>
                                        </td>
                                        <td class="border p-2 text-right font-medium">
                                            @php
                                                $subTotal = $itemSellPrice * $itemQty;
                                            @endphp
                                            <span
                                                id="item-sell-price-label-{{ $item->pivot->item_id }}-{{ $item->pivot->color_id }}-{{ $item->pivot->size_id }}"
                                                class="total-sell-price ml-1">
                                                {{ number_format($subTotal, 2);  }}
                                            </span>
                                        </td>
                                        <td class="text-center border w-16">
                                            <button class="btn-delete-item bg-red-500 hover:bg-red-700 w-8 h-8 rounded transition duration-300 ease-in-out"
                                                type="button"
                                                data-index="{{ $key }}"
                                                data-item-id="{{ $item->pivot->item_id }}"
                                                data-color-id="{{ $item->pivot->color_id }}"
                                                data-size-id="{{ $item->pivot->size_id }}">
                                                <i class="loadding-icon fa-solid fa-spinner fa-spin text-white"></i>
                                                <i class="trash-icon text-base text-white fa-regular fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <tfoot>
                            <div class="flex flex-col">
                                {{-- Show item discount amount --}}
                                <div class="flex justify-end">
                                    <div class="bg-gray-300 p-2 rounded-b w-72 mt-3">
                                        <div class="flex justify-between text-gray-700">
                                            <span>Items Discount</span>
                                            <span>
                                                <span class="font-medium">{{ $currency }}</span>
                                                <span id="total-discount-label" class="text-lg font-medium ml-1">
                                                    {{ number_format($order->discount, 2) }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Show subtotal price --}}
                                <div class="flex justify-end">
                                    <div class="bg-gray-300 p-2 rounded-b w-72 mt-3">
                                        <div class="flex justify-between text-gray-700">
                                            <span>Subtotal</span>
                                            <span>
                                                <span class="font-medium">{{ $currency }}</span>
                                                <span id="total-sell-price-label" class="text-lg font-medium ml-1">
                                                    {{ $order->sell_price }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Show delivery charge --}}
                                <div class="flex justify-end">
                                    <div class="bg-gray-300 p-2 rounded-b w-72 mt-3">
                                        <div class="flex items-center justify-between text-gray-700">
                                            <span>Delivery Charge</span>
                                            <span>
                                                <span class="font-medium">{{ $currency }}</span>
                                                <input id="delivery-charge-label" name="delivery_charge"
                                                    value="{{ $order->delivery_charge }}" type="number"
                                                    class="text-lg font-medium w-24 h-8 rounded ml-1">
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Show discount amount --}}
                                @if ($order->coupon)
                                    <div class="flex justify-end">
                                        <div class="bg-gray-300 p-2 rounded-b w-72 mt-3">
                                            <div class="flex items-center justify-between text-gray-700">
                                                <span>Coupon Discount</span>
                                                <span>
                                                    <span class="font-medium">{{ $currency }}</span>
                                                    <span class="text-lg font-medium ml-1">
                                                        - {{ number_format($order->coupon_value, 2) }}
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Show total price --}}
                                <div class="flex justify-end">
                                    <div class="bg-primary p-2 rounded-b w-72 mt-3">
                                        <div class="flex items-center justify-between text-white">
                                            <span class="text-lg">Total</span>
                                            <span>
                                                <span class="font-medium">{{ $currency }}</span>
                                                <span id="total-with-delivery-label" class="text-lg font-medium ml-1">
                                                    {{ number_format($order->payable_price, 2) }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </tfoot>
                        <div class="text-right mt-2">
                            <button
                                id="btn-order-update"
                                type="submit"
                                data-mdb-ripple="true"
                                data-mdb-ripple-color="light"
                                class="btn btn-md btn-success w-72 text-lg font-medium"
                                >Update
                                <i class="loadding-icon fa-solid fa-spinner fa-spin text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var items = [];
        var itemIndex              = {{ count($order->items) - 1 }};
        var totalSellPriceLabel    = $('#total-sell-price-label');
        var totalDiscountLabel     = $('#total-discount-label');
        var totalWithDeliveryLabel = $('#total-with-delivery-label');
        var iconLoadding           = $('.loadding-icon');
        var iconTrash              = $('.trash-icon');
        var btnOrderUpdate         = $('#btn-order-update');
        var btnAddProduct          = $('#btn-add-product');
        var deliveryCharge         = {{ $order->delivery_charge }};
        var deliveryChargeLabel    = $('#delivery-charge-label');
        var inputSpecialDiscount   = $('#input-special-discount');
        var inputProductQuantity   = $('#product-quantity');
        var inputProductColorId    = $('#input-product-color-id');
        var inputProductSizeId     = $('#input-product-size-id');
        var selelctedProductColors = [];
        var selelctedProductSizes  = [];

        // Make array object of product
        items = [
            @foreach ($order->items as $key => $item)
            {
                'img_src': '{{ $item->img_src }}',
                'id': {{ $item->id }},
                'color_id': {{ $item->pivot->color_id }},
                'size_id': {{ $item->pivot->size_id }},
                'name': '{{ $item->name }}',
                'quantity': {{ $item->pivot->quantity ?? 1 }},
                'buy_price': {{ $item->pivot->item_buy_price}},
                'mrp': {{ $item->pivot->item_mrp }},
                'sell_price': {{ $item->pivot->item_sell_price }},
                'discount': {{ $item->pivot->item_discount }}
            },
            @endforeach
        ];

        iconTrash.show()
        iconLoadding.hide();

        $(function() {
            // Set time to flash message
            setTimeout(function(){
                $("div.alert").remove();
            }, 5000 );

            // Select-2 for area
            $('.select-2-districts').select2({
                placeholder: "Select area",
            });

            // Action with input quantity change
            $('.items-table-body').on('change', '.input-item-qty', function() {
                var itemQty          = $(this).val();
                var itemId           = $(this).data('item-id');
                var colorId          = $(this).data('color-id');
                var sizeid           = $(this).data('size-id');
                var currentItemIndex = $(this).data('index');

                // update item quantity
                items[currentItemIndex]['quantity'] = itemQty;

                // item sub total price calculaton
                var itemSellPrice      = items[currentItemIndex]['sell_price'];
                var itemTotalSellPrice = (parseFloat(itemSellPrice * itemQty)).toFixed(2);

                // Show item subtotal price
                $(`#item-sell-price-label-${itemId}-${colorId}-${sizeid}`).text(itemTotalSellPrice);

                // discount calculation
                var discount  = 0;
                discount = items[currentItemIndex]['discount'];
                discount = (parseFloat(discount * itemQty)).toFixed(2);

                // Show discount
                $(`#item-discount-label-${itemId}-${colorId}-${sizeid}`).text(discount);

                totalPriceCalculation();
            });

            // Remove order item
            $('.items-table-body').on('click', '.btn-delete-item', function() {
                var orderId = $('#input-order-id').val();
                var itemId  = $(this).data('item-id') ?? 1;
                var colorId = $(this).data('color-id') ?? 1;
                var sizeId  = $(this).data('size-id') ?? 1;
                orderId     = +orderId;

                orderItemRemove(orderId, itemId, colorId, sizeId, $(this));
            });

            // Render selected product
            btnAddProduct.click(function() {
                var searchText  = $('#input-product-search').val();
                var productName = $('#input-product-name').val();
                if (!productName || !searchText) {
                    __showNotification('error', 'Please select product');
                    return false;
                } else {
                    renderSelectedProduct();
                    iconTrash.show()
                    iconLoadding.hide();
                    totalPriceCalculation();
                }
            });

            // get delivery charge when delivery charge change manually
            deliveryChargeLabel.keyup(function() {
                deliveryCharge = $(this).val();
                totalPriceCalculation();
            });

            inputProductQuantity.change(function() {
                var selectedProductQty = $(this).val();
            });

            btnOrderUpdate.click(function() {
                $(this).find(iconLoadding).show();
            });
        });

        // Calculate total price
        function totalPriceCalculation() {
            var totalSellPrice = 0;
            var totalDiscount = 0;
            var totalWithDeliveryCharge = 0;

            // Get all item subtotal
            items.forEach(item => {
                var itemQty       = parseFloat(item.quantity);
                var itemSellPrice = parseFloat(item.sell_price);
                var itemDiscount  = parseFloat(item.discount);

                var itemTotalSellPrice = itemSellPrice * itemQty;
                var itemTotalDiscount = itemDiscount * itemQty;

                totalSellPrice = totalSellPrice + itemTotalSellPrice ;
                totalDiscount  = totalDiscount + itemTotalDiscount;
            });

            // Set delivery charge
            deliveryCharge = +deliveryCharge;
            totalSellPrice = +totalSellPrice;
            deliveryChargeLabel.val(deliveryCharge);

            // Calculate total with delivery charge
            totalWithDeliveryCharge = (totalSellPrice + deliveryCharge);

            // show price
            totalSellPriceLabel.text(totalSellPrice.toFixed(2));
            totalDiscountLabel.text(totalDiscount.toFixed(2));

            totalWithDeliveryLabel.text(totalWithDeliveryCharge.toFixed(2));
        }

        // Order item remove
        function orderItemRemove(orderId, itemId, colorId, sizeId, btn) {
            btn.find(iconLoadding).show();
            btn.find(iconTrash).hide();

            axios.post('/admin/order/items/remove', {
                order_id: orderId,
                item_id: itemId,
                color_id: colorId,
                size_id: sizeId
            })
            .then(function (response) {
                btn.parent().parent().remove();
                var currentItemIndex = btn.data('index');
                items.splice(currentItemIndex, 1);

                // calculate total price and reseat delete button index
                totalPriceCalculation();
                resetDeleteIndex();
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        // reset index delete button
        function resetDeleteIndex(){
            $('.btn-delete-item').each(function(index, item) {
                $(item).attr('data-index', index);
            });
        }

        // Render selected product
        function renderSelectedProduct() {
            var productId       = $('#input-product-id').val();
            var productName     = $('#input-product-name').val();
            var productImgSRC   = $('#input-product-img-src').val();
            var buyPrice        = $('#input-product-buy-price').val();
            var mrp             = $('#input-product-mrp').val();
            var offerPrice      = $('#input-product-offer-price').val();

            console.log(buyPrice);

            // selected color id and name
            var selectedQty     = $('#input-product-qty').val();
            var selectedColorId = $('#input-product-color-id').find(":selected").val() ?? 1;
            var selectedSizeId  = $('#input-product-size-id').find(":selected").val() ?? 1;

            // make dropdown
            var qtyHTML    = makeQtyDropdown(selectedQty);
            var colorsHTML = makeColorsDropdown(selelctedProductColors, selectedColorId);
            var sizesHTML  = makeSizesDropdown(selelctedProductSizes, selectedSizeId);

            var sellPrice = offerPrice > 0 ? offerPrice : mrp;
            var itemTotal = (sellPrice * selectedQty).toFixed(2);

            // Calculate discount
            var discount = 0;
            if (offerPrice > 0) {
                discount = (parseFloat(mrp - offerPrice)).toFixed(2);
            }

            // Check item already exist
            var existItems = items.filter((item) => {
                return (item.id == productId && item.color_id ==selectedColorId && item.size_id == selectedSizeId);
            });

            if (existItems.length > 0) {
                __showNotification('error', 'This product already exist');
                return false
            }

            // reset product name, colors and sizes dropdown
            searchInput.val('');
            inputProductColorId.html('');
            inputProductSizeId.html('');

            itemIndex++;
            var singleItem = {
                'img_src': productImgSRC,
                'id': productId,
                'name': productName,
                'color_id': selectedColorId,
                'size_id': selectedSizeId,
                'quantity': selectedQty,
                'buy_price': buyPrice,
                'mrp': mrp,
                'sell_price': sellPrice,
                'discount': discount
            }
            items.push(singleItem);

            var itemHTML = `
            <tr>
                <input type="hidden" name="items[${ productId }][${selectedColorId}][${selectedSizeId}][product_id]" value="${productId}">
                <input type="hidden" name="items[${ productId }][${selectedColorId}][${selectedSizeId}][buy_price]" value="${buyPrice}">
                <input type="hidden" name="items[${ productId }][${selectedColorId}][${selectedSizeId}][mrp]" value="${mrp}">
                <input type="hidden" name="items[${ productId }][${selectedColorId}][${selectedSizeId}][sell_price]" value="${sellPrice}">
                <input type="hidden" name="items[${ productId }][${selectedColorId}][${selectedSizeId}][discount]" value="${discount}">

                <td class="text-center border p-2" style="width: 70px; height:40px">
                    <img src="${productImgSRC}" alt="Img">
                </td>
                <td class="border p-2"> ${productName} </td>
                <td class="border p-2 w-30">
                    <select
                        name="items[${productId}][${selectedColorId}][${selectedSizeId}][color_id]"
                        class="w-30 border-gray-300 focus:ring-0 focus:outline-none text-center rounded">
                        ${colorsHTML}
                    </select>
                </td>
                <td class="border p-2">
                    <select
                        name="items[${productId}][${selectedColorId}][${selectedSizeId}][size_id]"
                        class="w-30 border-gray-300 focus:ring-0 focus:outline-none text-center rounded">
                        ${sizesHTML}
                    </select>
                </td>
                <td class="border p-2">
                    <select
                        data-index="${itemIndex}"
                        data-item-id="${productId}"
                        data-color-id="${selectedColorId}"
                        data-size-id="${selectedSizeId}"
                        data-sell-price="${sellPrice}"
                        name="items[${productId}][${selectedColorId}][${selectedSizeId}][quantity]"
                        class="input-item-qty w-30 border-gray-300 focus:ring-0 focus:outline-none text-center rounded">
                        ${qtyHTML}
                    </select>
                </td>
                <td class="border p-2 text-right">
                    <span>${mrp}</span>
                </td>
                <td class="border p-2 text-right">
                    <span>${sellPrice}</span>
                </td>
                <td class="border p-2 text-right">
                    <span
                        id="item-discount-label-${productId}-${selectedColorId}-${selectedSizeId}">
                        ${(discount * selectedQty).toFixed(2)}
                    </span>
                </td>
                <td class="border p-2 text-right">
                    <span
                        id="item-sell-price-label-${productId}-${selectedColorId}-${selectedSizeId}"
                        class="total-sell-price ml-1">
                        ${itemTotal}
                    </span>
                </td>
                <td class="text-center border w-16">
                    <button class="btn-delete-item bg-red-500 hover:bg-red-700 w-8 h-8 rounded transition duration-300 ease-in-out"
                        type="button"
                        data-index="${itemIndex}"
                        data-item-id="${productId}"
                        data-color-id="${selectedColorId}"
                        data-size-id="${selectedSizeId}">
                        <i class="trash-icon text-base text-white fa-regular fa-trash-can"></i>
                    </button>
                </td>
            </tr>`;

            $('.items-table-body').append(itemHTML);
        }

        function onSearchColorsSelect(productColors) {
            selelctedProductColors = productColors;
            var colorsHTML = makeColorsDropdown(productColors);

            inputProductColorId.html('');
            inputProductColorId.append(colorsHTML);
        }

        function onSearchSizesSelect(productSizes) {
            selelctedProductSizes = productSizes;
            var sizesHTML = makeSizesDropdown(productSizes);

            inputProductSizeId.html('');
            inputProductSizeId.append(sizesHTML);
        }

        // Make colors dropdown
        function makeColorsDropdown(productColors, selelctedColorId = null) {
            var colorsHTML = '';
            colorsHTML = `<option value="1">Select</option>`
            if (productColors.length > 0) {
                var productColors = JSON.parse(productColors);

                productColors.forEach(function(color, index) {
                    colorsHTML = `${colorsHTML}<option value="${color.id}"${selelctedColorId==color.id?'selected':''}>${color.name}</option>`
                });
            }

            return colorsHTML;
        }

        // Make sizes dropdown
        function makeSizesDropdown(productSizes, selelctedSizeId = null) {
            var sizesHTML = '';
            sizesHTML = `<option value="1">Select</option>`

            if (productSizes.length > 0) {
                var productSizes = JSON.parse(productSizes);

                productSizes.forEach(function(size, index) {
                    sizesHTML = `${sizesHTML}<option value="${size.id}"${selelctedSizeId==size.id?'selected':''}>${size.name}</option>`
                });
            }

            return sizesHTML;
        }

        // Make quantity dropdown
        function makeQtyDropdown(selectedQty = null) {
            var qtyHTML = '';

            for(i = 1; i<=10; i++) {;
                qtyHTML = `${qtyHTML}<option value="${i}"${selectedQty==i?'selected':''}>${i}</option>`
            }

            return qtyHTML;
        }
    </script>
@endpush
