@extends('sellercenter.layouts.default')
@section('title', 'Orders')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Order</h6>
        <div class="actions">
            <a href="{{ route('seller.orders.manual.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        <form action="{{ route('seller.orders.index') }}" method="GET">
            <div class="action-bar mb-4 flex flex-wrap items-end space-x-2 space-y-2 bg-white p-2">
                <div class="flex flex-col ml-2">
                    <label class="text-sm" for="">Order ID</label>
                    <input type="number" class="text-sm border border-gray-300 rounded w-24 h-10" name="order_id"
                        value="{{ request()->input('order_id') }}">
                </div>
                <div class="flex flex-col">
                    <label class="text-sm" for="">Customer Name</label>
                    <input type="text" class="text-sm border border-gray-300 rounded w-32 h-10" name="customer_name"
                        value="{{ request()->input('customer_name') }}">
                </div>
                <div class="flex flex-col">
                    <label class="text-sm" for="">Customer Contact</label>
                    <input type="text" class="text-sm border border-gray-300 rounded w-32 h-10" name="phone_number"
                        value="{{ request()->input('phone_number') }}">
                </div>
                <div class="flex flex-col">
                    <label class="text-sm" for="">Start Date</label>
                    <input type="date" class="text-sm border border-gray-300 rounded w-32 h-10" name="start_date"
                        value="{{ request()->input('start_date') }}">
                </div>
                <div class="flex flex-col">
                    <label class="text-sm" for="">End Date</label>
                    <input type="date" class="text-sm border border-gray-300 rounded w-32 h-10" name="end_date"
                        value="{{ request()->input('end_date') }}">
                </div>
                <div class="flex flex-col">
                    <label class="text-sm" for="">Area</label>
                    <select class="text-sm border border-gray-300 rounded h-10 w-32" name="area_id">
                        <option value="">Select</option>
                        @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ $area->id == request()->input('area_id') ? "selected" : '' }}>
                            {{ $area->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col">
                    <label class="text-sm" for="">Delivery Type</label>
                    <select class="text-sm border border-gray-300 rounded w-36 h-10" name="delivery_type_id">
                        <option value="">Select</option>
                        @foreach ($dGateways as $dGateway)
                        <option value="{{ $dGateway->id }}"
                            {{ $dGateway->id == request()->input('delivery_type_id') ? "selected" : '' }}>
                            {{ $dGateway->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col">
                    <label class="text-sm" for="">Payment Type</label>
                    <select class="text-sm border border-gray-300 rounded h-10 w-36" name="payment_method_id">
                        <option value="">Select</option>
                        @foreach ($pGateways as $pGateway)
                        <option value="{{ $pGateway->id }}"
                            {{ $pGateway->id == request()->input('payment_method_id') ? "selected" : '' }}>
                            {{ $pGateway->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col">
                    <label class="text-sm" for="">Status</label>
                    <select class="text-sm border border-gray-300 rounded h-10 w-32" name="status_id">
                        <option value="">Select</option>
                        @foreach ($orderStatus as $status)
                        <option value="{{ $status->id }}"
                            {{ $status->id == request()->input('status_id') ? "selected" : '' }}>
                            {{ $status->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col">
                    <label class="text-sm" for="">Prescription</label>
                    <select class="text-sm border border-gray-300 rounded h-10 w-24" name="is_prescription">
                        <option value="">Select</option>
                        <option value="yes" {{ request()->input('is_prescription') === 'yes' ? "selected" : '' }}>YES</option>
                        <option value="no" {{ request()->input('is_prescription') === 'no' ? "selected" : '' }}>NO</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    <label class="text-sm" for="">Reference Code</label>
                    <input type="text" class="text-sm border border-gray-300 rounded w-32 h-10" name="ref_code"
                        value="{{ request()->input('ref_code') }}">
                </div>
                <button name="action" value="filter" type="submit" class="btn border h-10">Filter</button>
                <button name="action" value="export" class="btn border h-10">Export</button>
                <a href="{{ route('seller.orders.index') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
                <button type="button" id="btn-order-bulk-paid"
                    href="{{ route('seller.orders.index') }}"
                    class="btn border h-10 bg-green-500 text-white ml-1">
                    Paid
                </button>
                <a href="{{ route('seller.orders.multiple.invoice', ['start_date' => request()->input('start_date'), 'end_date' => request()->input('end_date')]) }}"
                    class="btn border h-10 bg-green-500 text-white ml-1">
                    Print
                </a>
            </div>
        </form>
        @if(Session::has('error'))
            <div class="alert mb-8 error">{{ Session::get('message') }}</div>
        @endif

        @if(Session::has('message'))
            <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif
        <div class="">
            <table class="table-report w-full">
                <thead class="bg-gray-100 shadow-sm sticky top-0">
                    <th class="w-10">
                        <input id="input-check-all" type="checkbox">
                    </th>
                    <th class="text-left">Order ID</th>
                    <th class="text-left">Order Date</th>
                    <th class="text-left" >Customer</th>
                    <th class="text-left">Phone Number</th>
                    <th class="text-left">Delivery Type</th>
                    <th class="text-left">Payment Type</th>
                    <th class="text-left">Delivery Area</th>
                    <th class="text-left">Reference ID</th>
                    <th class="w-14">Paid</th>
                    <th class="w-24">Status</th>
                    <th class="w-14">Rx</th>
                    <th class="w-14">Coupon</th>
                    <th class="w-24">Actions</th>
                </thead>
                <tbody>
                    @foreach ($result as $data)
                    <tr class="hover:bg-gray-100 transition-all duration-300 ease-in-out">
                        <td class="text-center">
                            <input type="checkbox" class="input-bulk-order-paid" name="paid_order_ids" value="{{ $data->id }}">
                        </td>
                        <td>{{ $data->id }}</td>
                        @if ($data->ordered_at)
                            <td>
                                {{ date('d-m-Y', strtotime($data->ordered_at)) }}
                            </td>
                        @else
                            <td>NULL</td>
                        @endif

                        <td>{{ ($data->user->name) ?? null }}</td>
                        <td>{{ ($data->user->phone_number) ?? null }}</td>
                        <td>
                            @if ($data->delivery_type_id)
                                {{ ($data->deliveryGateway->name) ?? null }}
                            @elseif($data->delivery_type_id === 0)
                                Free Delivery
                            @else
                                Custom Delivery
                            @endif
                        </td>
                        <td>{{ ($data->paymentGateway->name) ?? null }}</td>
                        <td>{{ ($data->shippingAddress->area->name) ?? null }}</td>
                        <td>
                            @if ($data->ref_code)
                                {{ $data->ref_code }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($data->is_paid)
                            <span class="block w-full rounded border px-2 py-1 text-sm text-white bg-green-500">Yes</span>
                            @else
                            <span class="block w-full rounded border px-2 py-1 text-sm text-white bg-red-500">No</span>
                            @endif
                        </td>
                        @php
                            $statusSlug = $data->currentStatus->slug ?? null;
                            $label      = 'N/A';
                            $bgColor    = '#f94449';
                            $fontColor  = '#ffff';
                            if ($statusSlug) {
                                $status = $data->getStatus($statusSlug);
                                if ($status) {
                                    $label     = $status['label'];
                                    $bgColor   = $status['color']['background'];
                                    $fontColor = $status['color']['font'];
                                }
                            }
                        @endphp
                        <td class="text-center">
                            <span class="block rounded border px-2 py-1 text-sm w-full"
                                style="background-color:{{ $bgColor }};color:{{ $fontColor }};">
                                {{ $label }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if (count($data->prescriptions))
                                <span class="block w-full rounded border px-2 py-1 text-sm text-white bg-green-500">Yes</span>
                            @else
                                <span class="block w-full rounded border px-2 py-1 text-sm text-white bg-red-500">No</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($data->coupon)
                                <span class="w-full flex items-center justify-center rounded border px-2 py-1 text-sm text-white bg-green-500">Yes</span>
                            @else
                                <span class="w-full flex items-center justify-center rounded border px-2 py-1 text-sm text-white bg-red-500">No</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex space-x-1 justify-end">
                                {{-- <a class="btn btn-secondary btn-sm" href="{{ route('seller.orders.edit', $data->id) }}">Edit</a> --}}
                                <div class="dropdown relative">
                                    <button class="dropdown-toggle btn btn-primary btn-sm" type="button" id="dropdownMenu-{{ $data->id }}"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Other
                                    </button>
                                    <ul class="dropdown-menu min-w-max absolute hidden bg-white text-base
                                        z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 m-0 bg-clip-padding border-none"
                                        aria-labelledby="dropdownMenu-{{ $data->id }}">
                                        <li>
                                            <a class="dropdown-item text-sm py-2 px-4 font-normalblock w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                                href="{{ route('seller.orders.show', $data->id) }}" target="_blank">View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-sm py-2 px-4 font-normalblock w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                                href="{{ route('seller.orders.invoice', $data->id) }}" target="_blank">Invoice</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-sm py-2 px-4 font-normalblock w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                                href="{{ route('seller.prescription.upload', $data->id) }}" target="_blank">Upload Prescriptions</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($result->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $result->appends(request()->input())->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<script>
    var btnOrderPaid     = $('.btn-admin-order-paid');
    var btnOrderBulkPaid = $('#btn-order-bulk-paid');

    // disable order paid button
    btnOrderBulkPaid.prop("disabled", true);
    btnOrderBulkPaid.addClass('disabled:opacity-50');

    $(function () {
        // Bulk order paid event with single checkbox click
        $('.input-bulk-order-paid').click(() => {
            var orderId = [];
            $('input[name="paid_order_ids"]:checked').each(function() {
                orderId.push(this.value);
            });
            if (orderId.length > 0) {
                btnOrderBulkPaid.prop("disabled", false);
                btnOrderBulkPaid.removeClass('disabled:opacity-50');
            } else {
                btnOrderBulkPaid.prop("disabled", true);
                btnOrderBulkPaid.addClass('disabled:opacity-50');
            }
        });

        // Bulk order paid event with all checkbox click
        $("#input-check-all").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
            var orderId = [];
            $('input[name="paid_order_ids"]:checked').each(function() {
                orderId.push(this.value);
            });
            if (orderId.length > 0) {
                btnOrderBulkPaid.prop("disabled", false);
                btnOrderBulkPaid.removeClass('disabled:opacity-50');
            } else {
                btnOrderBulkPaid.prop("disabled", true);
                btnOrderBulkPaid.addClass('disabled:opacity-50');
            }
        });

        // Single order paid
        btnOrderPaid.click(function () {
            var orderId = [];
            orderId.push($(this).data('order-id'));
            sweetAlert(orderId);
        });

        // Bulk order paid
        btnOrderBulkPaid.click(() => {
            var orderId = [];
            $('input[name="paid_order_ids"]:checked').each(function() {
                orderId.push(this.value);
            });
            if (orderId) {
                sweetAlert(orderId);
            }
        });
    });

    // Sweet alert notification
    function sweetAlert(orderId) {
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, paid it!'
            }).then((result) => {
            if (result.isConfirmed) {
                makePaid(orderId);
            }
        });
    }

    // Order paid fucntion
    function makePaid(orderID) {
        var endPoint = '{{ route('seller.make.paid') }}';
        axios.post(endPoint, {
            order_id: orderID
        })
        .then((response) => {
            location.reload();
        })
        .catch((error) => {
            console.log(error);
        });
    }
</script>
@endpush
