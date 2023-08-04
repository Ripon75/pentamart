@extends('adminend.layouts.default')
@section('title', 'Order-details')
@section('content')
<div class="page">
    {{-- page header --}}
    <div class="page-toolbar">
        <h6 class="title">Order Details</h6>
        <div class="actions">
            <a href="{{ route('admin.orders.index') }}" class="action btn btn-primary">Orders</a>
        </div>
    </div>
    <div class="page-content">
        <section class="container">
            <div class="page-section">
                <div class="grid grid-cols-6 gap-4">
                    <div class="col-span-6 mt-2">
                        <div class="mb-4">
                           <x-frontend.header-title
                                type="else"
                                title="Order"
                                bgImageSrc=""
                                bg-Color="#00798c"
                           />
                        </div>
                        <div class="card p-1">
                            <div class="">
                                <table class="table-auto w-full">
                                    <thead class="">
                                        <tr class="bg-gray-100 mt-2">
                                            <th class="text-left border p-2 w-20">Order ID</th>
                                            <th class="text-left border p-2">Created At</th>
                                            <th class="text-left border p-2">Customer</th>
                                            <th class="text-left border p-2">Address</th>
                                            <th class="text-left border p-2">Status</th>
                                            <th class="text-left border p-2">Coupon</th>
                                            <th class="text-left border p-2">note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border p-2">{{ $order->id }}</td>
                                            <td class="border p-2">{{ $order->created_at }}</td>
                                            <td class="border p-2">{{ ($order->user->name) ?? null }}</td>
                                            <td class="border p-2">{{ ($order->address) ?? null }}</td>
                                            <td class="border p-2">{{ ($order->currentStatus->name) ?? null }}</td>
                                            <td class="border p-2">{{ $order->coupon->code ?? null }}</td>
                                            <td class="border p-2">{{ $order->note }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {{-- Order details part --}}
                        <div class="col-span-6">
                            <div class="mb-1">
                               <x-frontend.header-title
                                    type="else"
                                    title="Order Details"
                                    bgImageSrc=""
                                    bg-Color="#00798c"
                               />
                            </div>
                            <div class="card p-4">
                                <div class="">
                                    <table class="table-auto w-full">
                                        <thead class="">
                                            <tr class="bg-gray-100">
                                                <th class="text-left border p-2">Product</th>
                                                <th class="text-left border p-2">Quantity</th>
                                                <th class="text-left border p-2">Buy price</th>
                                                <th class="text-left border p-2">MRP</th>
                                                <th class="text-left border p-2">Sell price</th>
                                                <th class="text-left border p-2">Discount</th>
                                                <th class="text-left border p-2">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $item)
                                            @php
                                                $itemQuantity       = $item->pivot->quantity;
                                                $itemBuyPrice       = $item->pivot->item_buy_price;
                                                $itemMRP            = $item->pivot->item_mrp;
                                                $itemSellPrice      = $item->pivot->item_sell_price;
                                                $itemDiscount       = $item->pivot->item_discount;
                                                $itemTotalSellPrice = $itemSellPrice * $itemQuantity;
                                                $itemTotalDiscount  = $itemDiscount * $itemQuantity;
                                            @endphp
                                            <tr>
                                                <td class="border p-2">{{ $item->name }}</td>
                                                <td class="border p-2">{{ $itemQuantity }}</td>
                                                <td class="border p-2">{{ number_format($itemBuyPrice, 2) }}</td>
                                                <td class="border p-2">{{ number_format($itemMRP, 2) }}</td>
                                                <td class="border p-2">{{ number_format($itemSellPrice, 2) }}</td>
                                                <td class="border p-2">{{ number_format($itemDiscount, 2) }}</td>
                                                <td class="border p-2">{{ number_format($itemTotalSellPrice, 2); }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="flex flex-col">
                                        {{-- Show subtotal price --}}
                                        <div class="flex justify-end">
                                            <div class="bg-gray-300 p-2 rounded-b w-64 mt-3">
                                                <div class="flex justify-between text-gray-700">
                                                    <span>Total</span>
                                                    <span>
                                                        <span>{{ $currency }}</span>
                                                        <span class="text-lg font-medium ml-1">
                                                            {{ number_format($order->mrp, 2) }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Show discount amount --}}
                                        <div class="flex justify-end">
                                            <div class="bg-gray-300 p-2 rounded-b w-64 mt-3">
                                                <div class="flex justify-between text-gray-700">
                                                    <span>Items Discount</span>
                                                    <span>
                                                        <span class="text-lg font-medium ml-1">
                                                            <span>{{ $currency }}</span>
                                                            - {{ number_format($order->discount, 2) }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Show sell price --}}
                                        <div class="flex justify-end">
                                            <div class="bg-gray-300 p-2 rounded-b w-64 mt-3">
                                                <div class="flex justify-between text-gray-700">
                                                    <span>Total - (Discount)</span>
                                                    <span>
                                                        <span class="text-lg font-medium ml-1">
                                                            <span>{{ $currency }}</span>
                                                             {{ number_format($order->sell_price, 2) }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Show delivery charge --}}
                                        <div class="flex justify-end">
                                            <div class="bg-gray-300 p-2 rounded-b w-64 mt-3">
                                                <div class="flex justify-between text-gray-700">
                                                    <span>Delivery Charge</span>
                                                    <span>
                                                        <span>{{ $currency }}</span>
                                                        <span class="text-lg font-medium ml-1">
                                                            {{ $order->delivery_charge }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Show coupon discount amount --}}
                                        @if ($order->coupon)
                                            <div class="flex justify-end">
                                                <div class="bg-gray-300 p-2 rounded-b w-64 mt-3">
                                                    <div class="flex justify-between text-gray-700">
                                                        <span>Coupon Discount</span>
                                                        <span>
                                                            <span>{{ $currency }}</span>
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
                                            <div class="bg-primary p-2 rounded-b w-64 mt-3">
                                                <div class="flex justify-between text-white">
                                                    <span>Payable</span>
                                                    <span>
                                                        <span>{{ $currency }}</span>
                                                        <span class="text-lg font-medium ml-1">
                                                            {{ number_format(round($order->payable_price), 2) }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Show order status --}}
                            <div>
                                <div class="mb-4">
                                    <x-frontend.header-title
                                         type="else"
                                         title="Order Status"
                                         bgImageSrc=""
                                         bg-Color="#00798c"
                                    />
                                 </div>
                                @if (count($order->status) > 0)
                                <table class="table-auto w-full">
                                    <thead class="">
                                        <tr class="bg-gray-100">
                                            <th class="text-left border p-2">Status ID</th>
                                            <th class="text-left border p-2">Status</th>
                                            <th class="text-left border p-2">Created at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $index = 0;
                                        @endphp
                                        @foreach ($order->status as $status)
                                        <tr>
                                            <td class="border p-2">{{ ++$index }}</td>
                                            <td class="border p-2">
                                                <span class="rounded border px-2 py-1 text-sm"
                                                style="background-color:{{ $status->bg_color }};color:{{ $status->text_color }};">
                                                {{ $status->name }}
                                            </span>
                                            </td>
                                            <td class="border p-2">{{ $status->pivot->created_at }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


@endsection

@push('scripts')
    <script>
        var btnShowPrescription = $('.btn-show-prescription');
        btnShowPrescription.prop('disabled', true);
    </script>
@endpush
