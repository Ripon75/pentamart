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
        <form class="card grid grid-cols-12 gap-4" action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- Show flash message --}}
            <div class="col-span-12">
                @if(Session::has('success'))
                    <div class="alert success">{{ Session::get('success') }}</div>
                @endif
            </div>
            {{-- =========Order edit titile========== --}}
            <div class="col-span-12">
                <x-frontend.header-title
                    type="else"
                    title="Order Update"
                    bgImageSrc=""
                    bgColor="#102967"
                />
            </div>
            <div class="col-span-4 px-4 bg-gray-200">
                 {{-- Payment status --}}
                 <div class="form-item">
                    <label class="form-label">Payment Status <span class="text-red-500 font-medium">*</span> </label>
                    <select class="form-select form-input w-full" name="payment_status">
                        <option value="1" {{ $order->is_paid === 1 ? 'selected' : '' }}>Paid</option>
                        <option value="0" {{ $order->is_paid === 0 ? 'selected' : '' }}>Unpaid</option>
                    </select>
                </div>

                {{-- Attach status --}}
                <div class="form-item w-full mt-4">
                    <input id="input-order-id" type="hidden" value="{{ $order->id }}">
                    <label for="" class="form-label">Order Status(<strong>{{ $order->currentStatus->name ?? null }}</strong>)</label>
                    <select id="input-order-status" class="form-select form-input w-full" name="status_id">
                        <option value="">Select Status</option>
                        @foreach ($orderStatus as $status)
                            <option value="{{ $status['id']}}">
                                {{ $status['label'] }}</option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <span class="form-helper error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex space-x-2">
                    {{-- Order date --}}
                    <div class="form-item w-full">
                        <label for="" class="form-label">Order Date <span class="text-red-500 font-medium">*</span> </label>
                        <input class="form-input" type="datetime-local" step="any" name="ordered_at" value="{{ date('Y-m-d\TH:i:s', strtotime($order->ordered_at)) }}">
                    </div>
                    {{-- Shipping address --}}
                    <div class="form-item w-full">
                        <label for="" class="form-label">Address Title</label>
                        <select id="area-shipping-address-id" class="form-select form-input w-full" name="address_id">
                            <option value="">Select Title</option>
                            @foreach ($shippingAddresses as $shippingAddress)
                            <option value="{{ $shippingAddress->id }}"
                                {{ $order->address_id == $shippingAddress->id ? "selected" : '' }}>
                                {{ $shippingAddress->title }}
                            </option>
                            @endforeach
                        </select>
                        @error('address_id')
                            <span class="form-helper error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-item">
                    <label class="form-label">Address</label>
                    <textarea id="area-shipping-address-line" class="form-input" type="text" name="address">{{ $order->shippingAddress->address ?? null }}</textarea>
                </div>
                <div class="form-item w-full">
                       <label class="form-label">Alternative Phone Number</label>
                       <input id="area-alternative-phone-number" class="form-input" type="number" name="phone_number"
                           value="{{ $order->shippingAddress->phone_number ?? null }}"/>
               </div>
                <div class="form-item w-full">
                   <label class="form-label">Area</label>
                   <select id="input-area-id" class="form-input select-2-areas" name="area_id">
                       <option value="">Select area</option>
                       @foreach ($areas as $area)
                           <option
                               value="{{ $area->id }}"
                               @if ($order->shippingAddress)
                               {{ $order->shippingAddress->area_id == $area->id ? "selected" : '' }}
                               @endif
                               >
                               {{ $area->name }}
                           </option>
                       @endforeach
                       <span class="text-red-300">@error('area_id') {{ $message }} @enderror</span>
                   </select>
               </div>
            </div>
            <div class="col-span-8 p-2">
                {{-- Search and select product --}}
                <div class="flex space-x-2 mb-4">
                    <div class="flex-1">
                        <x-adminend.product-search/>
                    </div>
                    <div class="w-40">
                        <select id="product-quantity">

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
                                <th class="text-left border p-2">Image</th>
                                <th class="text-left border p-2">Product</th>
                                <th class="text-center border p-2 w-24">Quantity</th>
                                <th class="text-right border p-2 w-28">MRP ({{ $currency }})</th>
                                <th class="text-center border p-2 w-32">Unit Price ({{ $currency }})</th>
                                <th class="text-right border p-2 w-32">Discount ({{ $currency }})</th>
                                <th class="text-right border p-2 w-36">Sub Total ({{ $currency }})</th>
                                <th class="text-left border p-2">Action</th>
                            </tr>
                        </thead>
                        <tbody class="items-table-body">
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($order->items as $key => $item)
                                <tr class="hover:bg-gray-50 transition duration-300 ease-in-out">
                                    <input type="hidden" name="items[{{ $item->id }}][product_id]" value="{{ $item->pivot->item_id }}">
                                    <input type="hidden" name="items[{{ $item->id }}][price]" value="{{ $item->pivot->price }}">
                                    <input type="hidden" name="items[{{ $item->id }}][pack_size]" value="{{ $item->pivot->pack_size }}">
                                    <input type="hidden" name="items[{{ $item->id }}][item_mrp]" value="{{ $item->pivot->item_mrp }}">
                                    <input type="hidden" name="items[{{ $item->id }}][discount]"
                                        value="{{ $item->pivot->item_mrp - $item->pivot->price }}">
                                    @php
                                        $discount  = 0;
                                        $itemMRP   = $item->pivot->item_mrp;
                                        $itemPrice = $item->pivot->price;
                                        $quantity  = $item->pivot->quantity;
                                        $discount = ($itemMRP - $itemPrice) * $quantity;
                                    @endphp
                                    <input id="eo-item-discount-{{ $item->id }}" type="hidden" value="{{ $discount }}">

                                    <td class="text-center border p-2" style="width: 70px; height:40px">
                                        <img src="{{ $item->image_src }}" alt="Product Image">
                                    </td>
                                    <td class="border p-2 text-sm">{{ $item->name }}</td>
                                    @php
                                        $itemPrice = $item->pivot->price;
                                    @endphp
                                    <td class="border p-2 text-right">
                                        <select
                                            data-index="{{ $key }}"
                                            data-unit-price="{{ $itemPrice }}"
                                            data-total-item-price-label="total-price-{{ $item->pivot->item_id }}"
                                            data-item-pack-size="{{ $item->pivot->pack_size }}"
                                            name="items[{{ $item->id }}][quantity]"
                                            value="{{ $item->pivot->quantity }}"
                                            class="input-item-qty border-gray-300 focus:ring-0 focus:outline-none text-center rounded">
                                            @if ($item->is_single_sell_allow)
                                                    @for ($i = 1; $i <= $item->num_of_pack; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $i == $item->pivot->quantity ? 'selected' : '' }}>
                                                            {{ $i }} {{ $item->uom }}
                                                        </option>
                                                    @endfor
                                                @else
                                                    @for ($i = 1; $i <= $item->num_of_pack; $i++)
                                                        <option value="{{ $item->pack_size * $i }}"
                                                            {{ ($item->pack_size * $i) == $item->pivot->quantity ? 'selected' : '' }}>
                                                            {{ $item->pack_size * $i }} {{ $item->uom }}
                                                        </option>
                                                    @endfor
                                                @endif
                                        </select>
                                    </td>
                                    @php
                                        $itemMRP = $item->pivot->item_mrp;
                                    @endphp
                                    <td class="border p-2 text-right">
                                        <span class="ml-1">{{ ($itemMRP) ?? null }}</span>
                                    </td>
                                    <td class="border p-2 text-right">
                                        <input
                                            step="any"
                                            type="number"
                                            name="items[{{ $item->id }}][price]"
                                            data-index="{{ $key }}"
                                            data-total-item-price-label="total-price-{{ $item->id }}"
                                            value="{{ $itemPrice }}"
                                            class="product-unit-price w-full border-gray-300 focus:ring-0 focus:outline-none text-center rounded">
                                    </td>
                                    <td class="border p-2 text-right">
                                        <span id="eo-item-discount-label-{{ $item->id }}" class="ml-1">
                                            {{ number_format($discount, 2)}}
                                        </span>
                                    </td>
                                    <td class="border p-2 text-right font-medium">
                                        @php
                                            $subTotal = $item->pivot->price * $item->pivot->quantity;
                                        @endphp
                                        <span id="total-price-{{ $item->pivot->item_id }}" class="totalprice ml-1">
                                            {{ number_format($subTotal, 2);  }}
                                        </span>
                                    </td>
                                    <td class="text-center border w-16">
                                        <button class="delete-order-item-btn bg-red-500 hover:bg-red-700 w-8 h-8 rounded transition duration-300 ease-in-out"
                                            type="button"
                                            data-index="{{ $key }}"
                                            data-order-item-id="{{ $item->pivot->item_id }}">
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
                                            <span class="font-medium">{{ $currency }}</span> -
                                            <span id="eo-items-discount-label" class="text-lg font-medium ml-1">
                                                {{ number_format($order->total_items_discount, 2) }}
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
                                            <span id="total-price-label" class="text-lg font-medium ml-1"></span>
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
                                            <input id="delivery-charge-label" name="delivery_charge" value="" type="number"
                                                class="text-lg font-medium w-24 h-8 rounded ml-1" readonly>
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
                            {{-- Show special discount --}}
                            <div class="flex justify-end">
                                <div class="bg-gray-300 p-2 rounded-b w-72 mt-3">
                                    <div class="flex items-center justify-between text-gray-700">
                                        <span>Special Discout</span>
                                        <span>
                                            <span class="font-medium">{{ $currency }}</span>
                                            <input id="special-discount-id" name="total_special_discount" value="{{ $order->total_special_discount }}"
                                                type="number"
                                                class="text-lg font-medium w-24 h-8 rounded ml-1" step="any">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            {{-- Show total price --}}
                            <div class="flex justify-end">
                                <div class="bg-primary p-2 rounded-b w-72 mt-3">
                                    <div class="flex items-center justify-between text-white">
                                        <span class="text-lg">Total</span>
                                        <span>
                                            <span class="font-medium">{{ $currency }}</span>
                                            <span id="total-price-label-with-delivery-charge" class="text-lg font-medium ml-1">
                                                @php
                                                    $paybleTotal = round($order->payable_order_value);
                                                @endphp
                                                {{ number_format($paybleTotal, 2) }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tfoot>
                    <div class="text-right mt-2">
                        <button
                            id="btn-admin-order-update"
                            type="submit"
                            data-mdb-ripple="true"
                            data-mdb-ripple-color="light"
                            class="btn btn-md btn-success w-72 text-lg font-medium"
                            >Update
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="grid grid-cols-12 gap-4 mt-4">
            <div class="card p-4 col-span-6">
                {{-- Header title component --}}
                <x-frontend.header-title
                type="else"
                title="Create New Address"
                bgImageSrc=""
                bgColor="#102967"
                />
                {{-- =========create new address=========== --}}
                <form action="{{ route('my.address.other.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $order->user_id }}"/>
                    <div class="form-item mt-4">
                        <label class="form-label">Address Title <span class="text-red-500 font-medium">*</span> </label>
                        <select id="edit-page-address-title" class="form-select form-input w-full" name="title">
                            <option value="">Select</option>
                            <option value="Home" {{ old('title') === 'Home' ? 'selected' : '' }}>Home</option>
                            <option value="Office" {{ old('title') === 'Office' ? 'selected' : '' }}>Office</option>
                            <option value="Others" {{ old('title') === 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                        @error('title')
                            <span class="form-helper error">{{ $message }}</span>
                        @enderror
                        @if(Session::has('title_exist'))
                            <span class="form-helper error">{{ Session::get('title_exist') }}</span>
                        @endif
                    </div>
                    <div id="edit-page-others-title-div" class="form-item mr-1">
                        <label for="">Your address title<span class="text-red-500 font-medium">*</span></label>
                        <input id="header-others-title" class="form-input" type="text" name="others_title"
                            placeholder="Enter Your address title" value="{{ old('others_title') }}"/>
                        @error('others_title')
                            <span class="form-helper error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-item">
                        <label class="form-label">Address <span class="text-red-500 font-medium">*</span> </label>
                        <textarea class="form-input" type="text" name="address"
                            placeholder="Ex: Write your address here.." >{{ old('address') }}</textarea>
                        @error('address')
                            <span class="form-helper error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-item w-full">
                        <label class="form-label">Alternative Phone Number</label>
                        <input class="form-input" type="text" name="phone_number"
                            placeholder="Enter Your Phone Number" value="{{ old('phone_number') }}"/>
                    </div>
                    <div class="form-item w-full">
                        <label class="form-label">Area <span class="text-red-500 font-medium">*</span> </label>
                        <select class="form-input select-2-areas" name="area_id">
                            <option value="">Select area</option>
                            @foreach ($areas as $area)
                            <option value="{{ $area->id }}">
                                {{ $area->name }}
                            </option>
                            @endforeach
                            <span class="text-red-300">@error('area_id') {{ $message }} @enderror</span>
                        </select>
                        @error('area_id')
                            <span class="form-helper error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-md btn-success w-32"
                            data-mdb-ripple="true"
                            data-mdb-ripple-color="light">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var items = [];
        var itemsIndex                        = {{ count($order->items) - 1 }};
        var aleartTime                        = '{{ config('crud.alear_time') }}';
        var baseURL                           = '{{ config('app.url') }}';
        var posBaseURL                        = '{{ config('app.pos_api_base_url') }}';
        var inputQuantity                     = $('.input-item-qty');
        var totalPriceLabel                   = $('#total-price-label');
        var totalPriceWithDeliveryChargeLabel = $('#total-price-label-with-delivery-charge');
        var iconLoadding                      = $('.loadding-icon');
        var iconTrash                         = $('.trash-icon');
        var deleteBtn                         = $('.delete-order-item-btn');
        var btnAddProduct                     = $('#btn-add-product');
        var deliveryCharge                    = {{ $order->delivery_charge }};
        var specialDiscount                   = {{ $order->total_special_discount ?? 0 }};
        var currencySymbol                    = '{{ $currency }}';
        var posToken                          = localStorage.getItem('pos_token');
        var deliveryChargeLabel               = $('#delivery-charge-label');
        var inputDeliveryGateway              = $('#input-delivery-gateway');
        var deliveryGatewayId                 = "{{ $order->dg_id }}";
        var inputProductQuantity              = $('#product-quantity');
        var couponForProduct                  = false;

        // Make array object of product
        items = [
            @foreach ($order->items as $key => $item)
            {
                'img_src': '{{ $item->image_src }}',
                'id': {{ $item->id }},
                'name': '{{ $item->name }}',
                'quantity': {{ $item->pivot->quantity }},
                'item_mrp': {{ $item->pivot->item_mrp }},
                'unit_price': {{ $item->pivot->price }},
                'discount': {{ $item->pivot->discount }},
                'pack_size': {{ $item->pivot->pack_size }},
            },
            @endforeach
        ];

        // Check custom delivery type id
        if (!deliveryGatewayId) {
            deliveryChargeLabel.removeAttr('readonly');
        }

        // Create customer address
        var editPageAddressTitle  = $('#edit-page-address-title');
        var editPageOtherTitleDiv = $('#edit-page-others-title-div').hide();
        var oldTitle = "{{ old('title') }}";
        if (oldTitle === "Others") {
            editPageOtherTitleDiv.show();
        }

        // calculate coupon discount
        var couponApplicableOn = "{{ $order->coupon->applicable_on ?? null }}";
        var couponDiscountType = "{{ $order->coupon->discount_type ?? 'fixed' }}";
        var couponDiscount = {{ $order->coupon->discount_amount ?? 0 }};
        var totalAmount    = {{ $order->order_items_value }};

        // Check coupon code applied on delivery charge
        if (couponApplicableOn === 'delivery_fee') {
            couponDiscount = 0;
        }

        // Check coupon code applied on cart
        if (couponApplicableOn === 'cart') {
            if (couponDiscountType == 'percentage') {
                couponDiscount = (totalAmount * couponDiscount)/100;
            }
        }

        // Check coupon code applied on products
        if (couponApplicableOn === 'products') {
            if (couponDiscountType === 'percentage') {
                var calculateCouponDiscount = 0;
                items.forEach(item => {
                    var productQuantity = item.quantity;
                    var productMRP = item.item_mrp;
                    var productDiscount = item.discount;
                    var productDiscountPercent = (productDiscount * 100) / productMRP;
                    var couponDiscountPercent = couponDiscount;
                    if(productDiscountPercent < couponDiscountPercent){
                        var productDiscount = (productMRP * couponDiscountPercent) /100;
                        productDiscount = productDiscount * productQuantity;
                        calculateCouponDiscount += productDiscount;
                    } else {
                        var productDiscount = (productMRP * productDiscountPercent) /100;
                        productDiscount = productDiscount * productQuantity;
                        calculateCouponDiscount += productDiscount;
                    }
                });
                couponDiscount = calculateCouponDiscount;
            }
            couponForProduct = true;
        }

        __totalPriceCalculation(couponForProduct);

        iconTrash.show()
        iconLoadding.hide();

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
            $('.items-table-body').on('change', '.input-item-qty', function() {
                var itemQuantity     = $(this).val();
                var currentItemIndex = $(this).data('index');
                items[currentItemIndex]['quantity'] = itemQuantity;

                // item sub total price calculaton
                var itemUnitPrice     = items[currentItemIndex]['unit_price'];
                var itemSubTotalPrice = itemUnitPrice * itemQuantity;
                itemSubTotalPrice = itemSubTotalPrice.toFixed(2);

                // Show item subtotal price
                var itemPriceLabel    = $(this).data('total-item-price-label');
                $(`#${itemPriceLabel}`).text(itemSubTotalPrice);

                // discount calculation
                var discount  = 0;
                var productID = items[currentItemIndex]['id'];
                discount = items[currentItemIndex]['discount'];
                discount = discount * itemQuantity;

                // Show discount
                $(`#eo-item-discount-label-${productID}`).text(discount.toFixed(2));

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
                itemSubTotalPrice     = itemSubTotalPrice.toFixed(2);

                // Show item sub total price
                var itemPriceLabel    = $(this).data('total-item-price-label');
                $(`#${itemPriceLabel}`).text(itemSubTotalPrice);

                // Discount calculation
                var discount  = 0;
                var itemMRP   = items[currentItemIndex]['item_mrp'];
                var productID = items[currentItemIndex]['id'];
                discount      = (itemMRP - itemUnitPrice);
                items[currentItemIndex]['discount'] = discount;
                discount = discount * itemQuantity;

                // Show discount
                $(`#eo-item-discount-label-${productID}`).text(discount.toFixed(2));

                __totalPriceCalculation();
            });

            // Remove order item
            $('.items-table-body').on('click', '.delete-order-item-btn', function() {
                var orderId     = $('#input-order-id').val();
                var orderItemId = $(this).data('order-item-id');

                orderItemRemove(orderId, orderItemId, $(this));
            });

            // Render selected product
            btnAddProduct.click(function() {
                var searchText  = $('#input-product-search').val();
                var productName = $('#input-product-name').val();
                if (!productName || !searchText) {
                    __showNotification('error', 'Please select product', aleartTime);
                    return false;
                } else {
                    renderSelectedProduct();
                    iconTrash.show()
                    iconLoadding.hide();
                    __totalPriceCalculation();
                    searchInput.val('');
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

            // update shipping address change
            $('#area-shipping-address-id').change(function() {
                var shippingAddressID = $('#area-shipping-address-id :selected').val();
                axios.get(`${baseURL}/my/shipping/addrss`, {
                    params: {
                        address_id: shippingAddressID
                    }
                })
                .then(res => {
                    if (res.data.status) {
                        var address      = res.data.result.address ?? null;
                        var phoneNumber  = res.data.result.phone_number ?? null;
                        var areaID       = res.data.result.area_id ?? null;
                        // admin edit address shipping address line
                        $('#area-shipping-address-line').val(address);
                        $('#area-alternative-phone-number').val(phoneNumber);
                        $('#input-area-id').val(areaID);
                    }
                })
                .catch(err => {
                    console.log(err);
                });
            });

            // Update special discount
            $('#special-discount-id').keyup(function() {
                specialDiscount = $(this).val();
                __totalPriceCalculation();
            });

            // Check address title is others
            editPageAddressTitle.change(function(){
                var addressTitle = $(this).val();
                if (addressTitle === 'Others') {
                    editPageOtherTitleDiv.show();
                } else {
                    editPageOtherTitleDiv.hide();
                }
            });

            inputProductQuantity.change(function() {
                var selectedProductQty = $(this).val();
            })
        });

        // Calculate total price
        function __totalPriceCalculation(couponForProduct = false) {
            var totalPrice = 0;
            var totalWithDeliveryCharge = 0;
            var totalDiscount = 0;
            // Get all item subtotal
            items.forEach(item => {
                var quantity = item.quantity;
                var itemsubtotal = item.quantity * item.unit_price;
                totalPrice = totalPrice + itemsubtotal;
                var itemDiscount = item.discount * quantity;
                totalDiscount += itemDiscount;
            });

            // Check coupon applied for product
            if (couponForProduct) {
                totalPrice = totalPrice + totalDiscount;
                totalPriceLabel.text(totalPrice.toFixed(2));
                $('#eo-items-discount-label').text(0);

            } else {
                totalDiscount = totalDiscount.toFixed(2);
                totalPrice    = totalPrice.toFixed(2);
                totalPriceLabel.text(totalPrice);
                $('#eo-items-discount-label').text(totalDiscount);
            }

            // Set delivery charge
            deliveryCharge = +deliveryCharge;
            totalPrice     = +totalPrice;
            deliveryChargeLabel.val(deliveryCharge);
            // Calculate total with delivery charge
            totalWithDeliveryCharge = totalPrice + deliveryCharge;
            totalWithDeliveryCharge = (totalWithDeliveryCharge - specialDiscount) - couponDiscount;

            totalPriceWithDeliveryChargeLabel.text(totalWithDeliveryCharge.toFixed(2));
        }

        // Order item remove
        function orderItemRemove(orderId, orderItemId, btn) {
            btn.find(iconLoadding).show();
            btn.find(iconTrash).hide();

            axios.post('/admin/order-items/remove', {
                order_id: orderId,
                order_item_id: orderItemId
            })
            .then(function (response) {
                btn.parent().parent().remove();
                var currentItemIndex = btn.data('index');
                items.splice(currentItemIndex, 1);
                __totalPriceCalculation();
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        // Render selected product
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

            // Check item already exist
            var existItems = items.filter((item) => {
                return item.id == productId;
            });

            if (existItems.length > 0) {
                __showNotification('error', 'This product already exist' , aleartTime);
                return false
            }

            var productPrice = productSalePrice > 0 ? productSalePrice : productMRP;
            var subTotal = productPrice * productQty;
            subTotal = subTotal.toFixed(2);

            // Calculate discount
            var discount = 0;
            if (productSalePrice > 0) {
                discount = productMRP - productSalePrice;
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
                <input type="hidden" name="items[${ productId }][price]" value="${productPrice}">
                <input type="hidden" name="items[${ productId }][pack_size]" value="${productPackSize}">
                <input type="hidden" name="items[${ productId }][item_mrp]" value="${productMRP}">
                <input id="eo-item-discount-${productId}" type="hidden" name="items[${ productId }][discount]" value="${discount}">
                <td class="text-center border p-2" style="width: 70px; height:40px">
                    <img src="${productImgSRC}" alt="Product Image">
                </td>
                <td class="border p-2"> ${productName} </td>
                <td class="border p-2">
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
                    <span>${productMRP}</span>
                </td>
                <td class="border p-2 text-right">
                    <input
                        step="any"
                        type="number"
                        name="items[${ productId }][price]"
                        data-index="${itemsIndex}"
                        data-total-item-price-label="total-price-${productId}"
                        value="${productPrice}"
                        class="product-unit-price w-full border-gray-300 focus:ring-0 focus:outline-none text-center rounded">
                </td>
                <td class="border p-2 text-right">
                    <span id="eo-item-discount-label-${productId}">${(discount * productQty).toFixed(2)}</span>
                </td>
                <td class="border p-2 text-right">
                    <span id="total-price-${ productId }" class="totalprice ml-1">
                        ${subTotal}
                    </span>
                </td>
                <td class="text-center border w-16">
                    <button class="delete-order-item-btn bg-red-500 hover:bg-red-700 w-8 h-8 rounded transition duration-300 ease-in-out"
                        type="button"
                        data-index="${itemsIndex}"
                        data-order-item-id="${productId}">
                        <i class="trash-icon text-base text-white fa-regular fa-trash-can"></i>
                    </button>
                </td>
            </tr>`;

            $('.items-table-body').append(itemHTML);
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
    {{-- Send status update information to medipos --}}
    <script>
        $(function() {
            $('#btn-admin-order-update').click(function () {
                var orderId          = $('#input-order-id').val();
                var areaId           = $('#input-area-id').val();
                var inputOrderStatus = $('#input-order-status').val();

                if (inputOrderStatus == 4 || inputOrderStatus == 7) {
                    var status;
                    if (inputOrderStatus == 4) {
                        status = 'picked-up';
                    } else {
                        status = 'delivered';
                    }
                    sendStatusUpdateInfo(orderId, status, areaId);
                }

            })
        });

        function sendStatusUpdateInfo(orderId, status, areaId) {
            var token    = localStorage.getItem('pos_token');
            var endPoint = '/admin/orders/status/update';
            axios.post(endPoint, {
                order_id: orderId,
                token: token,
                status: status,
                area_id: areaId
            })
            .then(function (response) {
                // console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    </script>
@endpush
