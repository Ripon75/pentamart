@extends('adminend.layouts.default')
@section('title', 'Purchase Orders Create')
@section('content')

<div class="page">
    <form action="{{ route('admin.purchase.orders.store') }}" method="POST">
        <div class="page-toolbar">
            <h6 class="title">All Purchase Orders Create</h6>
            <div class="actions">
                <button type="submit" class="action btn btn-primary">Submit</button>
            </div>
        </div>
        <div class="page-content">
            <div class="">
                 {{-- Show flash message --}}
                <div class="col-span-12">
                    @if(Session::has('message'))
                        <div class="alert success">{{ Session::get('message') }}</div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert error">{{ Session::get('error') }}</div>
                    @endif
                </div>
                @csrf
                @php
                    $i = 1;
                @endphp
                @foreach ($orders as $key => $order)
                    @if (count($order->items))
                        <div class="flex flex-col p-4 bg-white mb-8 rounded border shadow-sm">
                            <div class="w-full flex justify-between mb-4 items-center">
                                <h1 class="text-lg">[{{ $i }}] Order #{{ $order->id }}</h1>
                                <div class="actions flex space-x-2">
                                    <select
                                        name=""
                                        class="h-8 w-64 text-sm medipos-branch select-2-branch select-parant-branch"
                                        data-orderid="{{ $order->id }}">
                                    </select>
                                </div>
                            </div>
                            <table class="table-report w-full">
                                <thead class="bg-gray-100 shadow-sm sticky top-0">
                                    <th class="text-left w-28">Created At</th>
                                    <th class="text-left w-24">Product ID</th>
                                    <th class="text-left">Product Name</th>
                                    <th style="text-align: right" class="w-24">MRP</th>
                                    <th style="text-align: right" class="w-28">Selling Price</th>
                                    <th style="text-align: right" class="w-24">Purchase Price</th>
                                    <th class="w-24">Pharmacy</th>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <input type="hidden" name="orders[{{ $order->id }}][{{ $item->id }}][order_id]" value="{{ $order->id }}">
                                        <input type="hidden" name="orders[{{ $order->id }}][{{ $item->id }}][item_id]" value="{{ $item->id }}">
                                        <input type="hidden" name="orders[{{ $order->id }}][{{ $item->id }}][mrp]" value="{{ $item->mrp }}">
                                        <input type="hidden" name="orders[{{ $order->id }}][{{ $item->id }}][selling_price]" value="{{ $item->selling_price }}">
                                        <input type="hidden" name="orders[{{ $order->id }}][{{ $item->id }}][quantity]" value="{{ $item->pivot->quantity }}">
                                        <tr class="hover:bg-gray-100 transition-all duration-300 ease-in-out">
                                            <td>
                                                {{ $order->ordered_at ? $order->ordered_at->format('d/m/Y') : '' }}
                                            </td>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td style="text-align: right">{{ $item->mrp }}</td>
                                            <td style="text-align: right">
                                                {{ $item->selling_price > 0 ? $item->selling_price : $item->mrp }}
                                            </td>
                                            <td>
                                                <input type="number" class="h-8 w-28" name="orders[{{ $order->id }}][{{ $item->id }}][purchase_price]"
                                                    value="{{ old("orders.{$order->id}.{$item->id}.purchase_price") }}">
                                                @error("orders.{$order->id}.{$item->id}.purchase_price")
                                                    <span class="text-red-500">Required.</span>
                                                @enderror
                                            </td>
                                            <td>
                                                <select
                                                    name="orders[{{ $order->id }}][{{ $item->id }}][pharmacy_id]"
                                                    class="h-8 w-64 text-sm medipos-branch select-2-branch select-child-{{ $order->id }}">
                                                </select>
                                                @error("orders.{$order->id}.{$item->id}.pharmacy_id")
                                                    <span class="text-red-500">Required.</span>
                                                @enderror
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @php
                            $i++
                        @endphp
                    @endif
                @endforeach
                {{-- ========Pagination============ --}}
                @if ($orders->hasPages())
                    <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                        {{ $orders->appends(request()->input())->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var posBaseURL         = '{{ config('app.pos_api_base_url') }}';
        var posToken           = localStorage.getItem('pos_token');
        var mediposBranch      = $('.medipos-branch');
        var selectParantBranch = $('.select-parant-branch');
        __getAllMediposBranch();

        $(() => {
            $('.select-2-branch').select2({
                placeholder: "Select branch",
            });

            selectParantBranch.on('select2:select', function () {
                var orderId = $(this).data('orderid');
                var pharmaId = $(this).children('option:selected').val();
                var pharmaName = $(this).children('option:selected').text();

                $(`.select-child-${orderId}`).val(pharmaId).trigger('change');
            });
        });

        // Get area wise branch
        function __getAllMediposBranch(areaID){
            axios.get(`${posBaseURL}/api/branch/data/private/index`, {
                headers: {
                    Authorization: `Bearer ${posToken}`,
                },
                params: {
                    sort: 'display_name.ascend'
                }
            })
            .then(function (res) {
                if (res) {
                    var branches = res.data.result.data
                    if (branches) {
                        renderMediposBranches(branches);
                    }
                }
            })
            .catch(function (err) {
                console.log(err);
            });
        }

        // Render medipos area wise branch
        function renderMediposBranches (branches) {
            mediposBranch.html('');
            mediposBranch.html('<option value="">Select</option>');
            if (branches.length > 0) {
                branches.forEach( function (item) {
                    branchHTML =
                        `<option value="${item.id}" data-business-id="${item.business_info.id}">
                            ${item.business_info.display_name} - (${item.display_name})
                        </option>`;
                    mediposBranch.append(branchHTML);
                });
            }
        }
    </script>
@endpush
