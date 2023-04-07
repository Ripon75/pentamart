@extends('adminend.layouts.default')
@section('title', 'Order Processing')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Order Processing</h6>
        <div class="actions"></div>
    </div>
    <div class="page-content">
        <div class="flex w-full space-x-8">
            <div class="flex-1">
                <div class="card shadow">
                    <div class="header">
                        <div class="flex justify-between p-2">
                            <input id="order-id" type="hidden" value="{{ $order->id }}">
                            <div class="flex flex-col pl-2">
                                <span class="font-bold text-gray-600">Order #{{ $order->id }}</span>
                                <span class="text-sm text-gray-400">Date: {{ $order->ordered_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="actions flex space-x-2">
                                <div class="medipos-area form-item w-[300px]" style="margin-bottom: 0">
                                    <select name="" id="medipos-area-id" class="form-input select-2-areas">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="medipos-branch form-item w-[300px]" style="margin-bottom: 0">
                                    <select name="" id="medipos-branch-id" class="form-input select-2-branches">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <button id="btn-product-qty-check" class="btn flex items-center space-x-2">
                                    <span class="flex items-center">
                                        <i id="check-loadding-icon" class="fa-solid fa-spinner fa-spin mr-2"></i>
                                        <i id="check-icon" class="fa-solid fa-check"></i>
                                    </span>
                                    <span>Check</span>
                                </button>
                                <button id="btn-send-order-medipos" class="btn">
                                    <i id="share-loadding-icon" class="fa-solid fa-spinner fa-spin mr-2"></i>
                                    <i id="share-icon" class="fa-solid fa-share"></i>
                                    Transfer
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="body p-4">
                        <div class="mb-4 flex space-x-16">
                            <table class="flex-1">
                                <tbody>
                                    <tr class="bg-slate-100">
                                        <th class="w-28 text-left">Name :</th>
                                        <td>{{ $order->user->name ?? null }}</td>
                                    </tr>
                                    <tr class="bg-slate-50">
                                        <th class="w-28 text-left">Cell Phone :</th>
                                        <td>{{ $order->user->phone_number ?? null }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="flex-1">
                                <tbody>
                                    <tr class="bg-slate-100">
                                        <th class="w-28 text-left">Address :</th>
                                        <td>{{ $order->shippingAddress->address ?? null }}</td>
                                    </tr>
                                    <tr class="bg-slate-100">
                                        <th class="w-28 text-left">Area :</th>
                                        <td>{{ $order->shippingAddress->area->name ?? null }}</td>
                                    </tr>
                                    <tr class="bg-slate-50">
                                        <th class="w-28 text-left">Cell Phone :</th>
                                        <td>{{ $order->shippingAddress->phone_number ?? null }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th calss="w-12">ID</th>
                                    <th title="POS ID" calss="w-12">PID</th>
                                    <th class="w-12">IMG</th>
                                    <th>Product</th>
                                    <th class="w-24">MRP</th>
                                    <th class="w-24">Discout</th>
                                    <th class="w-24">Price</th>
                                    <th class="w-12">Qty</th>
                                    <th calss="w-12">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr id="row-pid-{{ $item->pos_product_id }}">
                                        <td>{{ $item->pivot->item_id }}</td>
                                        <td>{{ $item->pos_product_id }}</td>
                                        <td>
                                            <img src="{{ $item->image_src }}" alt="">
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        @php
                                            // Calculate item value
                                            $itemMRP          = $item->pivot->item_mrp;
                                            $itemSellingPrice = $item->pivot->price;
                                            $itemDiscount     = $item->pivot->discount;
                                            $itemPrice        = $itemSellingPrice > 0 ? $itemSellingPrice : $itemMRP;
                                        @endphp
                                        <td class="text-right">{{ number_format($itemMRP, 2) }}</td>
                                        <td class="text-right">{{ number_format($itemDiscount, 2) }}</td>
                                        <td class="text-right">{{ number_format($itemPrice, 2) }}</td>
                                        <td class="text-right">{{ $item->pivot->quantity }}</td>
                                        <td class="text-right stock">N/A</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4 flex space-x-4">
                            <div class="flex-1 h-1">&nbsp;</div>
                            <table class="w-80">
                                <tbody>
                                    <tr class="bg-slate-100">
                                        <th class="w-36 text-left">Items Total :</th>
                                        <td class="text-right">{{ number_format($order->order_items_mrp, 2) }} tk</td>
                                    </tr>
                                    <tr class="bg-slate-50">
                                        <th class="w-36 text-left">Total Discount :</th>
                                        <td class="text-right">{{ number_format($order->total_items_discount, 2) }} tk</td>
                                    </tr>
                                    <tr class="bg-slate-100">
                                        <th class="w-36 text-left">Coupon Discount :</th>
                                        <td class="text-right">{{ number_format($order->coupon_value, 2) }} tk</td>
                                    </tr>
                                    <tr class="bg-slate-50">
                                        <th class="w-36 text-left">Special Discount :</th>
                                        <td class="text-right">{{ number_format($order->total_special_discount, 2) }} tk</td>
                                    </tr>
                                    <tr class="bg-slate-100">
                                        <th class="w-36 text-left">After Discount :</th>
                                        <td class="text-right">{{ number_format($order->order_items_value, 2) }} tk</td>
                                    </tr>
                                    <tr class="bg-slate-50">
                                        <th class="w-36 text-left">Dilevery Charge :</th>
                                        <td class="text-right">{{ number_format($order->deliveryCharge(), 2) }} tk</td>
                                    </tr>
                                    <tr class="bg-slate-100">
                                        <th class="w-36 text-left">Payable Total :</th>
                                        <td class="text-right">{{ number_format(round($order->payable_order_value), 2) }} tk</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var posBaseURL          = '{{ config('app.pos_api_base_url') }}';
        var posToken            = localStorage.getItem('pos_token');
        var aleartTime          = '{{ config('crud.alear_time') }}';
        var checkLoddingIcon    = $('#check-loadding-icon');
        var shareLoddingIcon    = $('#share-loadding-icon');
        var checkIcon           = $('#check-icon');
        var shareIcon           = $('#share-icon');
        var mediposAreaID       = $('#medipos-area-id');
        var mediposBranchID     = $('#medipos-branch-id');
        var btnProductQtyCheck  = $('#btn-product-qty-check');
        var btnSendOrderMedipos = $('#btn-send-order-medipos');
        var itemIDs             = [@foreach ($order->items as $item) @php echo $item->pos_product_id ? "{$item->pos_product_id}," : "0,"; @endphp @endforeach];

        // Initially isable button
        btnSendOrderMedipos.prop("disabled", true);
        btnSendOrderMedipos.addClass('disabled:opacity-30');

        // Get all medipost buseiness
        __getAllMediposAreas();
        checkLoddingIcon.hide();
        shareLoddingIcon.hide();

        $(() => {
            // Select-2 for area
            $('.select-2-areas').select2({
                placeholder: "Select area",
            });

            // Select-2 for branch
            $('.select-2-branches').select2({
                placeholder: "Select branch",
            });

            // Area wise branch filter event
            $('.medipos-area').on('change', mediposAreaID, () => {
                var areaID = mediposAreaID.val();
                if (areaID) {
                    // Get area wise branch
                    __getAreaWiseBranch(areaID);
                }
            });

            // Button disable enable envet when change area
            mediposAreaID.change(function () {
                btnSendOrderMedipos.prop("disabled", true);
                btnSendOrderMedipos.addClass('disabled:opacity-30');
            });

            // Button disable enable envet when change branch
            mediposBranchID.change(function () {
                var businessAndBranchID = __getBusinsessAndBranchId();
                var businessID = businessAndBranchID.business_id;
                var branchID   = businessAndBranchID.branch_id;

                if (businessID & branchID) {
                    btnSendOrderMedipos.prop("disabled", false);
                    btnSendOrderMedipos.removeClass('disabled:opacity-30');
                } else {
                    btnSendOrderMedipos.prop("disabled", true);
                    btnSendOrderMedipos.addClass('disabled:opacity-30');
                }
            });

            // Product quantity check event
            btnProductQtyCheck.click(() => {
                // Get selected branch id
                var businessAndBranchID = __getBusinsessAndBranchId();
                var businessID = businessAndBranchID.business_id;
                var branchID   = businessAndBranchID.branch_id;

                if (!branchID) {
                    __showNotification('error', 'Please select branch' , aleartTime);
                    return false;
                }
                __mediposProductQtyCheck(itemIDs, businessID, branchID);
            });

            // Send order from medicart to medipos
            btnSendOrderMedipos.click(function() {
                var businessAndBranchID = __getBusinsessAndBranchId();
                var orderId    = $('#order-id').val();
                var businessID = businessAndBranchID.business_id;
                var branchID   = businessAndBranchID.branch_id;

                if (!branchID) {
                    __showNotification('error', 'Please select branch' , aleartTime);
                    return false;
                }
                __sendOrderMedipos(businessID, branchID, orderId);
            });
        });

        // Get all areas from medipos
        function __getAllMediposAreas(){
            axios.get(`${posBaseURL}/api/area/data/private/index`, {
                headers: {
                    Authorization: `Bearer ${posToken}`,
                },
                params: {
                    sort: 'display_name.ascend'
                }
            })
            .then(function (response) {
                if (response) {
                    areas = response.data.result.data;
                    if (areas) {
                        renderMediposArea(areas);
                    }
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        // Get area wise branch
        function __getAreaWiseBranch(areaID){
            axios.get(`${posBaseURL}/api/branch/data/private/index`, {
                headers: {
                    Authorization: `Bearer ${posToken}`,
                },
                params: {
                    area_id: areaID,
                    sort: 'display_name.ascend'
                }
            })
            .then(function (response) {
                if (response) {
                    var branches = response.data.result.data
                    if (branches) {
                        renderMediposAreaWieseBranches(branches);
                    }
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        // Check medipos product stock
        function __mediposProductQtyCheck(itemIDs, businessID, branchID){
            checkLoddingIcon.show();
            checkIcon.hide();
            axios.get(`${posBaseURL}/api/productTransaction/data/private/stock/closing-stock`, {
                headers: {
                    Authorization: `Bearer ${posToken}`,
                    Accept: 'application/json'
                },
                params: {
                    product_id: itemIDs,
                    business_id: businessID,
                    branch_id: branchID
                }
            })
            .then(function (response) {
                if (response) {
                    var result = response.data.result;
                    if (result.length > 0) {
                        result.forEach(function(item) {
                            var posProductID    = item.product_id;
                            var posProductStock = item.stock ? item.stock : 0;
                            posProductStock = parseInt(posProductStock);
                            posProductStock = posProductStock.toFixed(0);
                            if (posProductID) {
                                $(`#row-pid-${posProductID} .stock`).text(posProductStock);
                            }
                        });
                        checkLoddingIcon.hide();
                        checkIcon.show();
                    } else {
                        itemIDs.forEach(function(itemID) {
                            $(`#row-pid-${itemID} .stock`).text(0);
                        });

                        checkLoddingIcon.hide();
                        checkIcon.show();
                    }
                }
            })
            .catch(function (error) {
                checkLoddingIcon.hide();
                checkIcon.show();
                console.log(error);
            });
        }

        //Send order from medicart to medipos
        function __sendOrderMedipos(businessID, branchID, orderID) {
            shareLoddingIcon.show();
            shareIcon.hide();
            var token    = localStorage.getItem('pos_token');
            var endPoint = '/admin/orders/send';
            axios.post(endPoint, {
                business_id: businessID,
                branch_id: branchID,
                order_id: orderID,
                token: token
            })
            .then(function (response) {
                if (response.data.success) {
                    __showNotification('success', response.data.message , aleartTime);
                } else {
                    __showNotification('error', 'Something went to wrong' , aleartTime);
                    return false;
                }
                shareLoddingIcon.hide();
                shareIcon.show();
            })
            .catch(function (error) {
                shareLoddingIcon.hide();
                shareIcon.show();
                console.log(error);
            });
        }

        function __getBusinsessAndBranchId() {
            var businessID = $('.medipos-branch').on('#medipos-branch-id').find(":selected").data('business-id');
            var branchID   = $('.medipos-branch').on('#medipos-branch-id').find(":selected").val();
            return {
                business_id : businessID,
                branch_id: branchID
            }
        }

        // Render all medipos areas
        function renderMediposArea (areas) {
            if (areas.length > 0) {
                areas.forEach( function (item) {
                    var areaHTML = `<option value="${item.id}">${item.display_name}</option>`;
                    mediposAreaID.append(areaHTML);
                });
            }
        }

        // Render medipos area wise branch
        function renderMediposAreaWieseBranches (branches) {
            mediposBranchID.html('');
            mediposBranchID.html('<option value="">Select</option>');
            if (branches.length > 0) {
                branches.forEach( function (item) {
                    branchHTML =
                        `<option value="${item.id}" data-business-id="${item.business_info.id}">
                        ${item.business_info.display_name} - (${item.display_name})
                        </option>`;
                    mediposBranchID.append(branchHTML);
                });
            }
        }
    </script>
@endpush
