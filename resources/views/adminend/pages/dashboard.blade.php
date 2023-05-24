@extends('adminend.layouts.default')
@section('title', 'Dashboard')
@section('content')


<div class="flex space-x-2 justify-end mt-4 px-6">
    <form action="{{ route('admin.dashboard') }}" class="flex space-x-2">
        @csrf
        <div class="flex items-center space-x-2">
            <label for="" class="text-gray-600 text-sm">Start date</label>
            <input type="date" class="rounded-md border border-gray-300 shadow text-gray-600" name="start_date"
            value="{{ request()->input('start_date') }}">
        </div>
        <div class="flex items-center space-x-2">
            <label for="" class="text-gray-600 text-sm">End date</label>
            <input type="date" class="rounded-md border border-gray-300 shadow text-gray-600" name="end_date"
            value="{{ request()->input('end_date') }}">
        </div>
        <button class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.dashboard') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
    </form>
</div>
<div class="page">
    <div class="flex-auto px-4 xl:px-10 py-4 ">
        <div class="grid grid-cols-1 xl:grid-cols-2 w-full space-x-0 xl:space-x-4 space-y-4 xl:space-y-0">
            <div class="h-full w-full bg-white rounded-lg shadow-md">
                <div class="grid grid-cols-2 h-full w-full">
                    <div class="col-span-2 h-full p-4">
                        <h1 class="text-3xl text-blue-500">Hi {{ Auth::user()->name }}</h1>
                        <p class="text-gray-400">Here's what happening your Pentamart</p>
                        <div class="flex space-x-10 mt-10">
                            {{-- <div class="space-y-2">
                                <h2 class="text-gray-400">Total Visit</h2>
                                <h1 class="text-gray-600 text-2xl font-medium">
                                    {{ number_format($userEvent->number_of_browse, 0) ?? 0 }}
                                </h1>
                            </div> --}}
                            <div class="flex">
                                <div class="space-y-2">
                                    <h2 class="text-gray-400">Total Sales</h2>
                                    <h1 class="text-gray-600 text-2xl font-medium">
                                        {{ number_format($orderReport->order_value, 2) ?? 0 }}
                                    </h1>
                                </div>
                                {{-- <div class="flex items-center text-green-500 mt-11 ml-2">
                                    @if ($positiveOrdersValuePercent)
                                        <i class="fa-solid fa-arrow-up statictics-icon"></i>
                                        <h6>{{ number_format($positiveOrdersValuePercent, 2) }}</h6>
                                    @elseif ($negativeOrdersValuePercent)
                                        <i class="fa-solid fa-arrow-down statictics-icon"></i>
                                        <h6>{{ number_format($negativeOrdersValuePercent, 2) }}</h6>
                                    @else
                                        <h6>{{ number_format($neutralOrdersValuePercent, 2) }}</h6>
                                    @endif
                                    <p>%</p>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-span-1 h-full ">
                        <img class="flex items-center h-full" src="{{ asset('images/adminend/people.svg') }}">
                    </div> --}}
                </div>
            </div>
            <div class="h-full w-full border bg-white rounded-lg shadow-md">
                <div class="grid grid-cols-3 py-2 divide-x divide-gray-300">
                    <div class="statics-card border-b">
                        <div class="statics-card-wrapper">
                            <h1 class="statics-card-title">Submitted Orders</h1>
                            <h2 class="statics-card-content">
                                {{ number_format($orderReport->submitted_order, 0) ?? 0 }}
                            </h2>
                            <div class="statics-percent-wrapper">
                                <h2 class="statics-percent-content">Tk
                                    <span>{{ number_format($orderReport->submitted_order_value, 2) ?? 0 }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="statics-card border-b">
                        <div class="statics-card-wrapper">
                            <h1 class="statics-card-title">Canceled Orders</h1>
                            <h2 class="statics-card-content">
                                {{ number_format($orderReport->canceled_order, 0) ?? 0 }}
                            </h2>
                            <div class="statics-percent-wrapper">
                                <h2 class="statics-percent-content">Tk
                                    <span>{{ number_format($orderReport->canceled_order_value, 2) ?? 0 }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="statics-card border-b">
                        <div class="statics-card-wrapper">
                            <h1 class="statics-card-title">Delivered Orders</h1>
                            <h2 class="statics-card-content">
                                {{ number_format($orderReport->delivered_order, 0) ?? 0 }}
                            </h2>
                            <div class="statics-percent-wrapper">
                                <h2 class="statics-percent-content">Tk
                                    <span>{{ number_format($orderReport->delivered_order_value, 2) ?? 0 }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="statics-card">
                        <div class="statics-card-wrapper">
                            <h1 class="statics-card-title">Returned Orders</h1>
                            <h2 class="statics-card-content">
                                {{ number_format($orderReport->returned_order, 0) ?? 0 }}
                            </h2>
                            <div class="statics-percent-wrapper">
                                <h2 class="statics-percent-content">Tk
                                    <span>{{ number_format($orderReport->returned_order_value, 2) ?? 0 }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="statics-card">
                        <div class="statics-card-wrapper">
                            <h1 class="statics-card-title">Paid Orders</h1>
                            <h2 class="statics-card-content">
                                {{ number_format($orderReport->paid_order, 0) ?? 0 }}
                            </h2>
                            <div class="statics-percent-wrapper">
                                <h2 class="statics-percent-content">Tk
                                    <span>{{ number_format($orderReport->paid_order_value, 2) ?? 0 }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="statics-card">
                        <div class="statics-card-wrapper">
                            <h1 class="statics-card-title">Unpaid Orders</h1>
                            <h2 class="statics-card-content">
                                {{ number_format($orderReport->unpaid_order, 0) ?? 0 }}
                            </h2>
                            <div class="statics-percent-wrapper">
                                <h2 class="statics-percent-content">Tk
                                    <span>{{ number_format($orderReport->unpaid_order_value, 2) ?? 0 }}</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-3 w-full space-x-0 xl:space-x-4 space-y-4 xl:space-y-0 mt-6">
            <div class="col-span-1 xl:col-span-3 h-full w-full bg-white rounded-lg shadow-lg">
                <div class="">
                    <div class="flex items-center justify-between p-4">
                        <h1 class="text-gray-600 font-medium">Order</h1>
                    </div>
                    <div class="overflow-auto h-80">
                        <table class=" w-full">
                            <thead class="bg-primary-lightest text-sm text-gray-600 capitalize h-10">
                                <tr>
                                    <th class="text-left w-28 pl-3">ID</th>
                                    <th class="text-left w-28">Order Date</th>
                                    <th class="text-left w-28">Customer</th>
                                    <th class="text-left w-36">Phone Number</th>
                                    <th class="text-left w-20">Area</th>
                                    <th class="w-32 text-center">Status</th>
                                    <th class="w-8 text-center">Paid</th>
                                    <th class="w-32 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-100 transition duration-300 ease-in-out">
                                        <td class="text-gray-500 text-sm font-medium py-4 pl-3">{{ $order->id }}</td>
                                        <td class="text-gray-500 text-sm font-medium py-4">
                                            {{ date('d-m-Y', strtotime($order->ordered_at)) }}
                                        </td>
                                        <td class="text-gray-500 text-sm">{{ $order->user->name ?? '' }}</td>
                                        <td class="text-gray-500 text-sm">{{ $order->user->phone_number ?? '' }}</td>
                                        <td class="text-sm font-medium text-gray-500">{{ $order->shippingAddress->area->name ?? '' }}</td>
                                        @php
                                            $statusSlug = $order->currentStatus->slug ?? null;
                                            $label      = 'N/A';
                                            $bgColor    = '#f94449';
                                            $fontColor  = '#ffff';
                                        @endphp
                                        <td class="text-center">
                                            <span class="text-xs font-medium text-center w-20 rounded p-2"
                                                style="background-color:{{ $bgColor }};color:{{ $fontColor }};">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td class="text-center ">
                                            @if ($order->is_paid)
                                                <span class="block w-14 rounded border px-2 py-1 text-sm text-white bg-green-500 mx-auto">Yes</span>
                                            @else
                                                <span class="block w-14 rounded border px-2 py-1 text-sm text-white bg-red-500 mx-auto">No</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.orders.edit', $order->id) }}" class=" px-2 py-1 bg-white border border-gray-300 shadow text-sm font-medium text-gray-500 rounded">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
    <script>
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 4000 );
    </script>
@endpush
