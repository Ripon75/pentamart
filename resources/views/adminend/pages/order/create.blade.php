@extends('adminend.layouts.default')
@section('title', 'Orders')
@section('content')
<section class="page">
    {{-- page header --}}
    <div class="page-toolbar">
        <h6 class="title">All Orders</h6>
        <div class="actions">
            <a href="{{ route('admin.orders.index') }}" class="action btn btn-primary">Orders</a>
        </div>
    </div>
    <div class="page-content">
        <form action="{{ route('admin.orders.manual.store') }}", method="POST">
            @csrf
            <div class="grid grid-cols-12 gap-2">
                <div class="col-span-4">
                    {{-- Show flash message --}}
                    @if(Session::has('message'))
                        <div class="alert mb-8 mt-2 success">{{ Session::get('message') }}</div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert mb-8 mt-2 error">{{ Session::get('error') }}</div>
                    @endif
                    {{-- Payment status --}}
                    <div class="form-item">
                        <label class="form-label">Payment Status <span class="text-red-500 font-medium">*</span> </label>
                        <select class="form-select form-input w-full" name="payment_status">
                            <option value="1">Paid</option>
                            <option value="0">Unpaid</option>
                        </select>
                    </div>
                    {{-- Search and select user --}}
                    <div class="form-item">
                        <label for="" class="form-label mt-2">Choose Customer <span class="text-red-500 font-medium">*</span> </label>
                        <x-adminend.user-search></x-adminend.user-search>
                        @error('search_phone_number')
                            <span class="form-helper error">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Optional customer name --}}
                    <div class="form-item">
                        <label class="form-label">Customer Name</label>
                        <input class="form-input" type="text" name="customer_name" value="{{ old('customer_name') }}"
                            placeholder="Enter Customer Name" />
                        @error('customer_name')
                            <span class="form-helper error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-item">
                        <label class="form-label">Order Date</label>
                        <input class="form-input" type="date" name="ordered_at" value="{{ old('ordered_at') }}"
                            placeholder="Order Date" />
                    </div>
                    {{--Delivery gateway --}}
                    <fieldset class="bg-white shadow-sm border rounded p-4 mt-8">
                        <legend class="bg-gray-50 text-gray-400">Gateways</legend>
                        {{-- Payment gateway --}}
                        <div class="form-item">
                            <label for="" class="form-label">Payment Type <span class="text-red-500 font-medium">*</span> </label>
                            <select class="form-select form-input w-full" name="pg_id">
                                <option value="">Select payment gateway</option>
                                @foreach ($paymentGateways as $paymentGateway)
                                    <option value="{{ $paymentGateway->id }}"
                                        {{ old('pg_id') == $paymentGateway->id ? 'selected' : '' }}>
                                        {{ $paymentGateway->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pg_id')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                    </fieldset>

                    {{-- Create shipping address --}}
                    <fieldset class="bg-white shadow-sm border rounded p-4 mt-8">
                        <legend class="bg-gray-50 text-gray-400">Shipping Address</legend>
                        <div class="form-item">
                            <label for="" class="form-label">Shipping Address <span class="text-red-500 font-medium">*</span> </label>
                            <select id="input-shipping-addresses" class="form-select form-input w-full" name="address_id">
                                <option value="0">Choose Address</option>
                            </select>
                            @error('address_id')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-subtitle">
                            <hr>
                            <div><span>Or Create New Address</span></div>
                        </div>
                        <div class="create-shipping-address py-4">
                            <div class="form-item mr-1">
                                <label for="" class="form-label">Address Title <span class="text-red-500 font-medium">*</span> </label>
                                <select id="admin-address-title" class="form-select form-input w-full" name="shipping_address_title">
                                    <option value="">Select</option>
                                    <option value="Home" {{ old('shipping_address_title') == 'Home' ? 'selected' : '' }}>Home</option>
                                    <option value="Office" {{ old('shipping_address_title') == 'Office' ? 'selected' : '' }}>Office</option>
                                    <option value="Others" {{ old('shipping_address_title') == 'Others' ? 'selected' : '' }}>Others</option>
                                </select>
                                @error('shipping_address_title')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                                @if(Session::has('title_exist'))
                                    <span class="text-red-400 text-sm">{{ Session::get('title_exist') }}</span>
                                @endif
                            </div>
                            <div id="admin-others-title-div" class="form-item mr-1">
                                <label for="">Your address title<span class="text-red-500 font-medium">*</span></label>
                                <input id="header-others-title" class="form-input" type="text" name="others_title"
                                    placeholder="Enter Your address title" value="{{ old('others_title') }}"/>
                                @error('others_title')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Address <span class="text-red-500 font-medium">*</span> </label>
                                <input class="form-input" type="text" name="shipping_address_line" value="{{ old('shipping_address_line') }}"
                                    placeholder="Ex: Home Address, Office Address" />
                                @error('shipping_address_line')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Alternative Phone Number</label>
                                <input class="form-input" type="number" name="phone_number" value="{{ old('phone_number') }}"
                                    placeholder="Enter Your Phone Number" />
                                @error('phone_number')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Area <span class="text-red-500 font-medium">*</span> </label>
                                <select class="form-input select-2-areas" name="area_id">
                                    <option value="">Select area</option>
                                    @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                        {{ $area->name }}
                                    </option>
                                    @endforeach
                                    <span class="text-red-300">@error('area_id') {{ $message }} @enderror</span>
                                </select>
                                @error('area_id')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    {{-- end create shipping address --}}
                </div>
                <!-- Order details update -->
                <div class="card shadow body p-4 col-span-8">
                    {{-- Search and select product --}}
                    <div class="flex w-full space-x-2 mb-2">
                        <div class="flex-1">
                            <x-adminend.product-search/>
                        </div>
                        <div class="w-30">
                            {{-- <input id="product-quantity" class="rounded w-full" type="number" min="1" value="1"> --}}
                            <select id="product-quantity">

                            </select>
                        </div>
                        <button id="btn-add-product" type="button"
                            class="btn btn-success w-16"
                            data-mdb-ripple="true"
                            data-mdb-ripple-color="light">Add
                        </button>
                    </div>
                    {{-- Selected product render table --}}
                    <table class="table-auto w-full">
                        <thead class="">
                            <tr class="bg-gray-100">
                                <th class="text-left border p-2 w-20">Image</th>
                                <th class="text-left border p-2">Product</th>
                                <th class="text-right border p-2 w-28">Quantity</th>
                                <th class="text-right border p-2 w-28">MRP</th>
                                <th class="text-right border p-2 w-28">Unit Price</th>
                                <th class="text-right border p-2 w-24">Discount</th>
                                <th class="text-right border p-2 w-28">Price</th>
                                <th class="text-center border p-2 w-20">Action</th>
                            </tr>
                        </thead>
                        <tbody class="items-table-body">

                        </tbody>
                    </table>
                    <div class="flex flex-col">
                        {{-- Show subtotal price --}}
                        <div class="flex justify-end">
                            <div class="bg-gray-300 p-2 rounded-b w-64 mt-3">
                                <div class="flex justify-between text-gray-700">
                                    <span>Subtotal</span>
                                    <span> Tk
                                        <span id="total-price-label" class="text-lg font-medium ml-1"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            {{-- Show delivery charge --}}
                            <div class="bg-gray-300 p-2 rounded-b w-64 mt-3">
                                <div class="flex items-center justify-between text-gray-700">
                                    <span>Delivery Charge</span>
                                    <span>Tk
                                        <input id="delivery-charge-label" name="delivery_charge" type="number"
                                        class="text-lg font-medium ml-1 w-20 h-8">
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- Show total price --}}
                        <div class="flex justify-end">
                            <div class="bg-primary p-2 rounded-b w-64 mt-3">
                                <div class="flex items-center justify-between text-white">
                                    <span class="text-base">Total</span>
                                    <span>Tk
                                        <span id="total-price-label-with-delivery-charge" class="text-lg font-medium ml-1"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Order create --}}
                    <div class="text-right mt-2">
                        <button id="btn-menual-order-create" class="btn btn-md btn-success w-64"
                            data-mdb-ripple="true"
                            data-mdb-ripple-color="light">
                            <i id="mo-create-loadding-icon" class="lodding-icon fa-solid fa-spinner fa-spin mr-2"></i>
                            Create
                        </button>
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
        var items                             = [];
        var itemsIndex                        = -1;
        var deliveryCharge                    = 0;
        var aleartTime                        = '{{ config('crud.alear_time') }}';
        var manualOrderCreateEndpoint         = '/admin/orders/manual';
        var inputQuantity                     = $('.input-item-qty');
        var totalPriceLabel                   = $('#total-price-label');
        var deliveryChargeLabel               = $('#delivery-charge-label');
        var totalPriceWithDeliveryChargeLabel = $('#total-price-label-with-delivery-charge');
        var deleteBtn                         = $('.delete-order-item-btn');
        var btnAddProduct                     = $('#btn-add-product');
        var inputUserId                       = $('#input-user-id');
        var inputShippingAddresses            = $('#input-shipping-addresses');
        var createShippingAddress             = $('.create-shipping-address');
        var inputDeliveryGateway              = $('#input-delivery-gateway');
        var btnManualOrderCreate              = $('#btn-menual-order-create');
        var adminAddressTitle                 = $('#admin-address-title');
        var createLoddingIcon                 = $('.lodding-icon').hide();
        var inputProductQuantity              = $('#product-quantity');
        // hidden div for title othes
        var adminOthersTitleDiv = $('#admin-others-title-div').hide();
        // Other title div show if old value is Others
        var oldTitle = "{{ old('shipping_address_title') }}";
        if (oldTitle === "Others") {
            adminOthersTitleDiv.show();
        }

        __totalPriceCalculation();

        $(function() {
            // Set time to flash message
            setTimeout(function(){
                $("div.alert").remove();
            }, 5000 );

            // Select-2 for area
            $('.select-2-areas').select2({
                placeholder: "Select area",
            });

            // Action with input quantity change
            $('.items-table-body').on('change keyup', '.input-item-qty', function() {
                var itemQuantity     = $(this).val();
                var currentItemIndex = $(this).data('index');
                items[currentItemIndex]['quantity'] = itemQuantity;

                // item price calculaton
                var itemUnitPrice     = items[currentItemIndex]['unit_price'];
                var itemSubTotalPrice = itemUnitPrice * itemQuantity;
                var itemPriceLabel    = $(this).data('total-item-price-label');
                $(`#${itemPriceLabel}`).text(itemSubTotalPrice);

                // Total discount calculation
                var totalDiscount  = 0;
                var itemMRP   = items[currentItemIndex]['item_mrp'];
                var productID = items[currentItemIndex]['id'];
                totalDiscount = (itemMRP - itemUnitPrice) * itemQuantity;
                $(`#mo-item-discount-${productID}`).val(totalDiscount);
                $(`#mo-item-discount-label-${productID}`).text(totalDiscount.toFixed(2));

                __totalPriceCalculation();
            });

            // Action with product unit price change
            $('.items-table-body').on('change keyup', '.product-unit-price', function() {
                var itemUnitPrice    = $(this).val() ?? 0;
                var currentItemIndex = $(this).data('index');
                items[currentItemIndex]['unit_price'] = itemUnitPrice;

                // item price calculaton
                var itemQuantity      = items[currentItemIndex]['quantity'];
                var itemSubTotalPrice = itemUnitPrice * itemQuantity;
                var itemPriceLabel    = $(this).data('total-item-price-label');
                $(`#${itemPriceLabel}`).text(itemSubTotalPrice);

                // Total discount calculation
                var totalDiscount  = 0;
                var itemMRP   = items[currentItemIndex]['item_mrp'];
                var productID = items[currentItemIndex]['id'];
                totalDiscount = (itemMRP - itemUnitPrice) * itemQuantity;
                $(`#mo-item-discount-${productID}`).val(totalDiscount);
                $(`#mo-item-discount-label-${productID}`).text(totalDiscount.toFixed(2));

                __totalPriceCalculation();
            });

            // Remove order item
            $('.items-table-body').on('click', '.delete-order-item-btn', function() {
                $(this).parent().parent().remove();
                var currentItemIndex = $(this).data('index');
                items.splice(currentItemIndex, 1);

                __totalPriceCalculation();
            });

            btnAddProduct.click(function() {
                var searchText  = $('#input-product-search').val();
                var productName = $('#input-product-name').val();
                if (!productName || !searchText) {
                    __showNotification('error', 'Please select product', aleartTime);
                    return false;
                } else {
                    renderSelectedProduct();
                    __totalPriceCalculation();
                    searchInput.val('');
                    $('#product-quantity').val(1);
                }
            });

            // get selected delivery charge
            inputDeliveryGateway.change(function() {
                deliveryCharge = $("#input-delivery-gateway option:selected").data('delivery-charge');
                var value = $(this).val();
                if (value === '-1') {
                    deliveryChargeLabel.removeAttr('readonly');
                } else {
                    deliveryChargeLabel.attr('readonly','readonly');
                }
                __totalPriceCalculation();
            });

            // get delivery charge when delivery charge change manually
            deliveryChargeLabel.keyup(function() {
                deliveryCharge = $(this).val();
                __totalPriceCalculation();
            });

            // Check address title is others
            adminAddressTitle.change(function(){
                var adminTitle = $(this).val();
                if (adminTitle === 'Others') {
                    adminOthersTitleDiv.show();
                } else {
                    adminOthersTitleDiv.hide();
                }
            });

            btnManualOrderCreate.click(function(){
                $(this).find(createLoddingIcon).show();
            });

             inputProductQuantity.change(function() {
                var selectedProductQty = $(this).val();

            });
        });

        function __userIdOnChangeCallback() {
            var userId = inputUserId.val();
            if (userId) {
                getShippingAddress(userId);
            }
        }

        // Calculate total price
        function __totalPriceCalculation() {
            var totalPrice = 0;
            var totalWithDeliveryCharge = 0;
            // Get all item subtotal
            items.forEach(item => {
                var itemsubtotal = item.quantity * item.unit_price;
                totalPrice = totalPrice + itemsubtotal;
            });

            totalPriceLabel.text(totalPrice.toFixed(2));

            // Set delivery charge
            deliveryCharge = Math.trunc(deliveryCharge);
            deliveryChargeLabel.val(deliveryCharge);
            // Calculate total with delivery charge
            totalWithDeliveryCharge = totalPrice + deliveryCharge;
            totalPriceWithDeliveryChargeLabel.text(totalWithDeliveryCharge.toFixed(2));
        }

        // Get shipping address for selectee user
        function getShippingAddress(userId) {
            axios.get('/api/address/search', {
                params: {
                    user_id: userId
                }
            })
            .then((response) => {
                var shippingAddresses = [];
                if (response.data.success) {
                    shippingAddresses = response.data.result;
                    if (!shippingAddresses) {
                        createShippingAddress.show();
                    } else {
                        renderShippingAddress(shippingAddresses);
                    }
                }
            })
            .catch((error) => {
                console.log(error);
            });
        }

        // HTML render selected product
        function renderSelectedProduct() {
            var productId        = $('#input-product-id').val();
            var productName      = $('#input-product-name').val();
            var productImgSRC    = $('#input-product-image-src').val();
            var productMRP       = $('#input-product-mrp').val();
            var productSalePrice = $('#input-product-selling-price').val();
            var productPackSize  = $('#input-product-pack-size').val();
            var productPackName  = $('#input-product-pack-name').val();
            var productQty       = $('#product-quantity').val();
            var productUOM       = $('#input-product-uom').val();
            var productNumOfPack = $('#input-product-num-of-pack').val();

            // Make dropdown option
            var qtyHTML = makeQtyDropdown(productPackSize, productNumOfPack, productUOM, productQty);

            var productPrice = productSalePrice > 0 ? productSalePrice : productMRP;
            var subTotal = productPrice * productQty;
            subTotal = subTotal.toFixed(2);
            // Calculate discount
            var discount = 0;
            if (productSalePrice > 0) {
                discount = productMRP - productSalePrice;
                discount = discount.toFixed(2);
            }

            // Check item already exist
            var existItems = items.filter((item) => {
                return item.id == productId;
            });

            if (existItems.length > 0) {
                __showNotification('error', 'This product already exist' , aleartTime);
                return false
            }

            itemsIndex++;
            var singleItem = {
                'img_src': productImgSRC,
                'id': productId,
                'name': productName,
                'quantity': productQty,
                'item_mrp': productMRP,
                'unit_price': productPrice,
                'discount': discount
            }
            items.push(singleItem);

            var itemHTML = `
            <tr>
                <input type="hidden" name="items[${ productId }][product_id]" value="${productId}">
                <input type="hidden" name="items[${ productId }][pack_size]" value="${productPackSize}">
                <input type="hidden" name="items[${ productId }][item_mrp]" value="${productMRP}">
                <input id="mo-item-discount-${productId}" type="hidden" name="items[${ productId }][discount]" value="${discount}">
                <td class="text-center border p-2" style="width: 70px; height:40px">
                    <img src="${productImgSRC}" alt="Product Image">
                </td>
                <td class="border p-2 text-sm"> ${productName} </td>
                <td class="border p-2 w-40">
                    <select
                        data-index="${itemsIndex}"
                        data-unit-price="${productPrice}"
                        data-total-item-price-label="total-price-${productId}"
                        data-item-pack-size="${productPackSize}"
                        name="items[${productId}][quantity]"
                        class="input-item-qty w-full border-gray-300 focus:ring-0 focus:outline-none text-center rounded">
                        ${qtyHTML}
                    </select>
                </td>
                <td class="border p-2 text-right">
                    <span>Tk</span>
                    <span>${productMRP}</span>
                </td>
                <td class="border p-2">
                    <input
                        step="any"
                        type="number"
                        name="items[${ productId }][price]"
                        data-index="${itemsIndex}"
                        data-total-item-price-label="total-price-${productId}"
                        value="${productPrice}"
                        class="product-unit-price w-full rounded">
                </td>
                <td class="border p-2 text-right">
                    <span>Tk</span>
                    <span id="mo-item-discount-label-${productId}">${(discount * productQty).toFixed(2)}</span>
                </td>
                <td class="border p-2 text-right">
                    <span>Tk</span>
                    <span id="total-price-${ productId }" class="totalprice ml-1">
                        ${subTotal}
                    </span>
                </td>
                <td class="text-center border w-16">
                    <button class="delete-order-item-btn"
                        type="button"
                        data-order-item-id="${productId}"
                        data-index="${itemsIndex}">
                        <i class="trash-icon text-xl text-gray-600 fa-regular fa-trash-can"></i>
                    </button>
                </td>
            </tr>`;

            $('.items-table-body').append(itemHTML);
        }

         // HTML render shipping address
        function renderShippingAddress(data) {
            inputShippingAddresses.html('<option value="0">Choose Address</option>');
            for(let index = 0 ; index < data.length; index++) {
                var address = data[index];
                var addressHTML =
                `<option value="${address.id}">
                    ${address.title}
                </option>`
                inputShippingAddresses.append(addressHTML);
            }
        }

        // Make dropdown option
        function onSearchProductSelect(productPackSize, productNumOfPack, productUOM) {
            var qtyHTML = makeQtyDropdown(productPackSize, productNumOfPack, productUOM);

            inputProductQuantity.html('');
            inputProductQuantity.append(qtyHTML);
        }

        // Make option
        function makeQtyDropdown(productPackSize, productNumOfPack, productUOM, selectedProdutQty = null) {
            var qtyHTML = '';
            if (!productUOM) {
                productUOM = '';
            }

            for(i = 1; i<=productNumOfPack; i++) {
                qtyHTML = `${qtyHTML}<option value="${i*productPackSize}" ${selectedProdutQty==i*productPackSize?'selected':''}>${i*productPackSize} ${productUOM}</option>`
            }

            return qtyHTML;
        }
    </script>
@endpush
