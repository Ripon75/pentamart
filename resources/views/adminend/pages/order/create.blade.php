@extends('adminend.layouts.default')
@section('title', 'Order Create')
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
        <form id="input-form" action="{{ route('admin.orders.manual.store') }}", method="POST">
            @csrf
            <div class="grid grid-cols-12 gap-2">
                <div class="card shadow body p-4 col-span-3">
                    {{-- Show flash message --}}
                    @if(Session::has('success'))
                        <div class="alert mb-8 mt-2 success">{{ Session::get('success') }}</div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert mb-8 mt-2 error">{{ Session::get('error') }}</div>
                    @endif
                    {{-- Payment status --}}
                    <div class="form-item">
                        <label class="form-label">Payment Status <span class="text-red-500 font-medium">*</span> </label>
                        <select class="form-select form-input w-full" name="payment_status">
                            <option value="0">Select</option>
                            <option value="0">Unpaid</option>
                            <option value="1">Paid</option>
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
                    {{-- Gateway --}}
                    {{-- <fieldset class="bg-white shadow-sm border rounded p-4 mt-8">
                        <legend class="bg-gray-50 text-gray-400">Gateways</legend>
                        <div class="form-item">
                            <label for="" class="form-label">Payment Type <span class="text-red-500 font-medium">*</span> </label>
                            <select class="form-select form-input w-full" name="pg_id">
                                <option value="">Select payment gateway</option>
                                @foreach ($pgs as $pg)
                                    <option value="{{ $pg->id }}"
                                        {{ old('pg_id') == $pg->id ? 'selected' : '' }}>
                                        {{ $pg->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pg_id')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                    </fieldset> --}}

                    {{-- Create shipping address --}}
                    <fieldset class="bg-white shadow-sm border rounded p-4 mt-8">
                        <legend class="bg-gray-50 text-gray-400">Shipping Address</legend>
                        <div class="form-item">
                            <label for="" class="form-label">Shipping Address <span class="text-red-500 font-medium">*</span> </label>

                            <select id="input-addresses-id" class="form-select form-input w-full" name="address_id">
                                <option value="">Select</option>
                            </select>
                            @error('address_id')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-subtitle">
                            <div>
                                <button id="btn-create-address" type="button" class="btn btn-success btn-sm">Create new address</button>
                            </div>
                        </div>
                        <div id="div-shipping-address" class="py-4 hidden">
                            <div class="form-item mr-1">
                                <label for="" class="form-label">Address Title <span class="text-red-500 font-medium">*</span> </label>
                                <select class="form-select form-input w-full" name="address_title">
                                    <option value="">Select</option>
                                    <option value="Home">Home</option>
                                    <option value="Office">Office</option>
                                    <option value="Others">Others</option>
                                </select>
                                @error('address_title')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Address <span class="text-red-500 font-medium">*</span> </label>
                                <input class="form-input" type="text" name="address_line" placeholder="Ex: Home Address, Office Address" />
                                @error('address_line')
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
                </div>
                <!-- Product add section -->
                <div class="card shadow body p-4 col-span-9">
                    <div class="flex w-full space-x-2 mb-2">
                        <div class="flex-1">
                            <x-adminend.product-search/>
                        </div>
                        <div class="w-30">
                            <select id="input-product-qty" class="rounded-md">
                                @for ($i = 1; $i<=5; $i++)
                                    <option value="{{ $i }}" >{{ $i }}</option>
                                @endfor
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
                                <th class="text-right border p-2 w-28">Color</th>
                                <th class="text-right border p-2 w-28">Size</th>
                                <th class="text-right border p-2 w-28">Quantity</th>
                                <th class="text-right border p-2 w-28">Price</th>
                                <th class="text-right border p-2 w-28">Sell Price</th>
                                <th class="text-right border p-2 w-24">Discount</th>
                                <th class="text-right border p-2 w-28">Sub Total</th>
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
                                        <span id="total-with-delivery-charge-label" class="text-lg font-medium ml-1"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Order create --}}
                    <div class="text-right mt-2">
                        <button id="btn-menual-order-create" type="button" class="btn btn-md btn-success w-64"
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
        var items                        = [];
        var itemIndex                    = -1;
        var deliveryCharge               = {{ $deliveryCharge->promo_price ? $deliveryCharge->promo_price : $deliveryCharge->price }};
        var manualOrderCreateEndpoint    = '/admin/orders/manual';
        var inputQuantity                = $('.input-item-qty');
        var totalPriceLabel              = $('#total-price-label');
        var deliveryChargeLabel          = $('#delivery-charge-label');
        var totalWithDeliveryChargeLabel = $('#total-with-delivery-charge-label');
        var btnAddProduct                = $('#btn-add-product');
        var inputUserId                  = $('#input-user-id');
        var inputAddressesId             = $('#input-addresses-id');
        var divShippingAddress           = $('#div-shipping-address');
        var btnManualOrderCreate         = $('#btn-menual-order-create');
        var loddingIcon                  = $('.lodding-icon').hide();
        var inputProductQty              = $('#input-product-qty');
        var btnCreateAddress             = $('#btn-create-address');

        totalPriceCalculation();

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
                var itemSellPrice  = items[currentItemIndex]['sell_price'];
                var itemTotalPrice = itemSellPrice * itemQuantity;
                var itemPriceLabel = $(this).data('total-item-price-label');
                $(`#${itemPriceLabel}`).text(itemTotalPrice.toFixed(2));

                // Total discount calculation
                var itemTotalDiscount  = 0;
                var itemPrice     = items[currentItemIndex]['item_price'];
                var productID     = items[currentItemIndex]['id'];
                itemTotalDiscount = (itemPrice - itemSellPrice) * itemQuantity;
                $(`#input-item-discount-${productID}`).val(itemTotalDiscount);
                $(`#input-item-discount-label-${productID}`).text(itemTotalDiscount.toFixed(2));

                totalPriceCalculation();
            });

            // Action with product sell price change
            $('.items-table-body').on('change keyup', '.product-sell-price', function() {
                var itemSellPrice    = $(this).val() ?? 0;
                var currentItemIndex = $(this).data('index');
                items[currentItemIndex]['sell_price'] = itemSellPrice;

                // item price calculaton
                var itemQuantity      = items[currentItemIndex]['quantity'];
                var itemTotalPrice    = itemSellPrice * itemQuantity;
                var itemTotalPriceLabel    = $(this).data('total-item-price-label');
                $(`#${itemTotalPriceLabel}`).text(itemTotalPrice.toFixed(2));

                // Item total discount calculation
                var itemTotalDiscount  = 0;
                var itemPrice   = items[currentItemIndex]['item_price'];
                var productId = items[currentItemIndex]['id'];
                itemTotalDiscount = (itemPrice - itemSellPrice) * itemQuantity;
                $(`#input-item-discount-${productId}`).val(itemTotalDiscount);
                $(`#input-item-discount-label-${productId}`).text(itemTotalDiscount.toFixed(2));

                totalPriceCalculation();
            });

            // Remove order item
            $('.items-table-body').on('click', '.btn-delete-order-item', function() {
                $(this).parent().parent().remove();
                var currentItemIndex = $(this).data('index');
                items.splice(currentItemIndex, 1);

                totalPriceCalculation();
            });

            btnAddProduct.click(function() {
                var searchText  = $('#input-product-search').val();
                var productName = $('#input-product-name').val();
                if (!productName || !searchText) {
                    __showNotification('error', 'Please select product');
                    return false;
                } else {
                    renderSelectedProduct();
                    totalPriceCalculation();
                    searchInput.val('');
                    inputProductQty.val(1);
                }
            });

            // get delivery charge when delivery charge change manually
            deliveryChargeLabel.keyup(function() {
                deliveryCharge = $(this).val();
                totalPriceCalculation();
            });

            btnManualOrderCreate.click(function(){
                var inputUserSearch   = $('#input-user-search');
                var inputAddressTitle = $("select[name=address_title]");
                var inputAddressLine  = $("input[name=address_line]");
                var inputAreaId       = $("select[name=area_id]");

                if (!inputUserSearch.val()) {
                    __showNotification('error', 'Please select user');
                    inputUserSearch.focus();
                    return false;
                }

                if (!inputAddressesId.val()) {
                    // Show create new address section
                    divShippingAddress.show();

                    if (!inputAddressTitle.val()) {
                        __showNotification('error', 'Address title field is required');
                        $('select[name^="address_title"]').eq(1).focus();
                        return false;
                    }

                    if (!inputAddressLine.val()) {
                        inputAddressLine.focus();
                        __showNotification('error', 'Address field is required');
                        return false;
                    }

                    if (!inputAreaId.val()) {
                        inputAreaId.select2('open');
                        __showNotification('error', 'Area field is required');
                        return false;
                    }
                }

                $(this).find(loddingIcon).show();
                $('#input-form').submit()
            });

             inputProductQty.change(function() {
                var selectedProductQty = $(this).val();
            });

            btnCreateAddress.click(function() {
                divShippingAddress.show();
            });
        });

        function __userIdOnChangeCallback() {
            var userId = inputUserId.val();
            if (userId) {
                getShippingAddress(userId);
            }
        }

        // Calculate total price
        function totalPriceCalculation() {
            var totalPrice = 0;
            var totalWithDeliveryCharge = 0;

            // Get all item subTotal
            items.forEach(item => {
                var itemTotal = parseFloat(item.quantity * item.sell_price);
                totalPrice = parseFloat(totalPrice + itemTotal);
            });

            totalPriceLabel.text(totalPrice.toFixed(2));

            // Set delivery charge
            deliveryCharge = Math.trunc(deliveryCharge);
            deliveryChargeLabel.val(deliveryCharge);

            // Calculate total with delivery charge
            totalWithDeliveryCharge = parseFloat(totalPrice + deliveryCharge);
            totalWithDeliveryChargeLabel.text(totalWithDeliveryCharge.toFixed(2));
        }

        // Get shipping address for selectee user
        function getShippingAddress(userId) {
            axios.get('/api/address/search', {
                params: {
                    user_id: userId
                }
            })
            .then((res) => {
                console.log(res);
                var shippingAddresses = [];
                if (res.data.success) {
                    shippingAddresses = res.data.result;
                    if (!shippingAddresses) {
                        divShippingAddress.show();
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
            var productId     = $('#input-product-id').val();
            var productName   = $('#input-product-name').val();
            var productImgSRC = $('#input-product-image-src').val();
            var productPrice  = $('#input-product-price').val();
            var offerPrice    = $('#input-product-offer-price').val();
            var productQty    = $('#input-product-qty').val();

            var sellPrice = offerPrice > 0 ? offerPrice : productPrice;
            var itemTotal = (sellPrice * productQty).toFixed(2);

            // Calculate discount
            var itemDiscount = 0;
            if (offerPrice > 0) {
                itemDiscount = (parseFloat(productPrice - offerPrice)).toFixed(2);
            }

            // Check item already exist
            var existItems = items.filter((item) => {
                return item.id == productId;
            });

            if (existItems.length > 0) {
                __showNotification('error', 'This product already exist');
                return false
            }

            itemIndex++;
            var singleItem = {
                'img_src': productImgSRC,
                'id': productId,
                'name': productName,
                'quantity': productQty,
                'item_price': productPrice,
                'sell_price': sellPrice,
                'discount': itemDiscount
            }
            items.push(singleItem);

            // Make dropdown option
            var qtyHTML = makeQtyDropdown(productQty);

            var itemHTML = `
            <tr>
                <input type="hidden" name="items[${ productId }][product_id]" value="${productId}">
                <input type="hidden" name="items[${ productId }][item_price]" value="${productPrice}">
                <input id="input-item-discount-${productId}" type="hidden" name="items[${ productId }][discount]" value="${itemDiscount}">
                <td class="text-center border p-2" style="width: 70px; height:40px">
                    <img src="${productImgSRC}" alt="Product Image">
                </td>
                <td class="border p-2 text-sm"> ${productName} </td>
                <td class="border p-2">
                    <select
                        data-index="${itemIndex}"
                        data-unit-price="${sellPrice}"
                        data-total-item-price-label="total-price-${productId}"
                        name="items[${productId}][quantity]"
                        class="input-item-qty w-16 border-gray-300 focus:ring-0 focus:outline-none text-center rounded">
                        ${qtyHTML}
                    </select>
                </td>
                <td class="border p-2 text-right">
                    <span>${productPrice}</span>
                </td>
                <td class="border p-2 w-40">
                    <input
                        step="any"
                        type="number"
                        name="items[${ productId }][price]"
                        data-index="${itemIndex}"
                        data-total-item-price-label="total-price-${productId}"
                        value="${sellPrice}"
                        class="product-sell-price w-24 rounded">
                </td>
                <td class="border p-2 text-right">
                    <span id="input-item-discount-label-${productId}">${(itemDiscount * productQty).toFixed(2)}</span>
                </td>
                <td class="border p-2 text-right">
                    <span id="total-price-${ productId }" class="totalprice ml-1">
                        ${itemTotal}
                    </span>
                </td>
                <td class="text-center border w-16">
                    <button class="btn-delete-order-item"
                        type="button"
                        data-order-item-id="${productId}"
                        data-index="${itemIndex}">
                        <i class="trash-icon text-xl text-gray-600 fa-regular fa-trash-can"></i>
                    </button>
                </td>
            </tr>`;

            $('.items-table-body').append(itemHTML);
        }

         // HTML render shipping address
        function renderShippingAddress(data) {
            inputAddressesId.html('<option value="">Choose Address</option>');
            for(let index = 0 ; index < data.length; index++) {
                var address = data[index];
                var addressHTML =
                `<option value="${address.id}">
                    ${address.title}
                </option>`
                inputAddressesId.append(addressHTML);
            }
        }

        // Make dropdown option
        // function onSearchProductSelect() {
        //     var qtyHTML = makeQtyDropdown(null);

        //     inputProductQty.html('');
        //     inputProductQty.append(qtyHTML);
        // }

        // Make option
        function makeQtyDropdown(selectedProdutQty = null) {
            var qtyHTML = '';

            for(i = 1; i<=5; i++) {;
                qtyHTML = `${qtyHTML}<option value="${i}" ${selectedProdutQty==i?'selected':''}>${i}</option>`
            }

            return qtyHTML;
        }
    </script>
@endpush
