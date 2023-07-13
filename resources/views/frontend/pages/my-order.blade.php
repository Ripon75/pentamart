@extends('frontend.layouts.default')
@section('title', 'My-Order')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            <div class="col-span-4">
                <div class="card p-0 sm:p-0 md:p-2 lg:p-4 xl:p-4 2xl:p-4">
                    <div class="w-full overflow-x-scroll">
                        <table class="table-auto w-full text-xs sm:text-xs md:text-sm">
                            <thead class="">
                                <tr class="bg-secondary">
                                    <th class="text-left border p-2">Order ID</th>
                                    <th class="text-right border p-2">Items</th>
                                    <th class="text-right border p-2">Price</th>
                                    <th class="text-center border p-2">Status</th>
                                    <th class="text-center border p-2">Paid</th>
                                    <th class="text-center border p-2">Area</th>
                                    <th class="text-left border p-2">Submitted at</th>
                                    <th class="text-center border p-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="border p-2">{{ $order->id }}</td>
                                        <td class="border border-l-0 p-2 text-right">{{ count($order->items) }}</td>
                                        <td class="border border-l-0 p-2 text-right">
                                            <span>{{ $currency }}</span>
                                            <span class="ml-1">{{ number_format($order->payable_price, 2) }}</span>
                                        </td>
                                        @php
                                            $label      = $order->currentStatus->name ?? 'N/A';
                                            $bgColor    = $order->currentStatus->bg_color ?? '#f94449';
                                            $fontColor  = $order->currentStatus->font_color ?? '#ffff';
                                        @endphp
                                        <td class="border border-l-0 p-2 text-center">
                                            <span class="rounded border px-2 py-1 text-xs"
                                                style="background-color:{{ $bgColor }};color:{{ $fontColor }};">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($order->is_paid)
                                                <button class="border px-2 py-1 rounded text-white bg-green-500 text-sm">
                                                    YES
                                                </button>
                                            @else
                                                <button class="border px-2 py-1 rounded text-white bg-red-500 text-sm">
                                                    NO
                                                </button>
                                            @endif
                                        </td>
                                        <td class="border border-l-0 p-2">{{ $order->shippingAddress->area->name ?? '' }}</td>
                                        <td class="border border-l-0 p-2">{{ $order->created_at }}</td>
                                        <td class="border border-l-0 p-2 flex flex-wrap space-y-1 md:space-y-0 space-x-2 items-center justify-center">
                                            <a href="{{ route('my.order.show', $order->id) }}" class="">
                                                <button title="View" class="btn btn-primary px-2 py-1">
                                                    Show
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- ========Pagination============ --}}
                        @if ($orders->hasPages())
                            <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                                {{ $orders->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
