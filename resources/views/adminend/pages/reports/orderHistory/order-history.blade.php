@extends('adminend.layouts.default')
@section('title', 'Order History')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Order</h6>
        <div class="actions">
            <button class="prntBtn btn btn-primary" onclick="printDiv('table-report')">Print</button>
        </div>
    </div>
    <div class="page-content">
        <div class="action-bar mb-4 bg-primary-lightest border p-4">
            <form action="{{ route('admin.orders.report') }}" method="GET" class="flex justify-between items-end">
                <div class="flex items-end space-x-2">
                    <div class="flex flex-col">
                        <label for="">From Date</label>
                        <input type="date" class="border border-gray-300 rounded w-36 h-10" name="start_date"
                            value="{{ request()->input('start_date') }}">
                    </div>
                    <div class="flex flex-col">
                        <label for="">To Date</label>
                        <input type="date" class="border border-gray-300 rounded w-36 h-10" name="end_date"
                            value="{{ request()->input('end_date') }}">
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button name="action" value="filter" type="submit" class="btn btn-secondary border h-10">Filter</button>
                    <button name="action" value="export" class="btn btn-success border h-10">Export</button>
                    <a href="{{ route('admin.orders.report') }}" class="btn btn-danger">Clear</a>
                </div>
            </form>
        </div>
        @if(count($orders))
            <div class="mt-8" id="table-report">
                <table class="table-report w-full">
                    <thead class="bg-gray-100 shadow-sm">
                        <th style="width: 80px;">ID</th>
                        <th style="width: 100px;">Created at</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th style="text-align: right;">Buy price</th>
                        <th style="text-align: right;">MRP</th>
                        <th style="text-align: right;">Discount</th>
                        <th style="text-align: right;">Sell Price</th>
                        <th style="text-align: right;">Delivery</th>
                        <th style="text-align: right;">Coupon</th>
                        <th style="text-align: right;">Payable</th>
                    </thead>
                    <tbody>
                        @php
                            $totalBuyPrice       = 0;
                            $totalMRP            = 0;
                            $totalDiscount       = 0;
                            $totalSellPrice      = 0;
                            $totalDeliveryCharge = 0;
                            $totalCouponDiscount = 0;
                            $totalPyablePrice    = 0;
                        @endphp
                        @foreach ($orders as $key => $order)
                        @php
                            $buyPrice       = $order->buy_price;
                            $mrp            = $order->mrp;
                            $discount       = $order->discount;
                            $sellPrice      = $order->sell_price;
                            $deliveryCharge = $order->delivery_charge;
                            $couponDiscunt  = $order->coupon_value;
                            $payablePrice   = $order->payable_price;

                            $totalBuyPrice       += $buyPrice;
                            $totalMRP            += $mrp;
                            $totalDiscount       += $discount;
                            $totalSellPrice      += $sellPrice;
                            $totalDeliveryCharge += $deliveryCharge;
                            $totalCouponDiscount += $couponDiscunt;
                            $totalPyablePrice    += $payablePrice;
                        @endphp
                        <tr>
                            <td style="width: 80px;">{{ $order->id }}</td>
                            <td style="width: 100px;">{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                            <td>{{ $order->user->name ?? null }}</td>
                            <td>{{ $order->user->phone_number ?? null }}</td>
                            <td style="text-align: right;">{{ number_format($buyPrice, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($mrp, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($discount, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($sellPrice, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($deliveryCharge, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($couponDiscunt, 2) }}</td>
                            <td style="text-align: right;">{{ number_format($payablePrice, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-sm border border-black">
                            <td class="text-center"colspan="1">#</td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-2" colspan="3">Ground Total : </td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">
                                {{ number_format($totalBuyPrice, 2) }}
                            </td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">
                                {{ number_format($totalMRP, 2) }}
                            </td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">
                                {{ number_format($totalDiscount, 2) }}
                            </td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">
                                {{ number_format($totalSellPrice, 2) }}
                            </td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">
                                {{ number_format($totalDeliveryCharge, 2) }}
                            </td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">
                                {{ number_format($totalCouponDiscount, 2) }}
                            </td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">
                                {{ number_format($totalPyablePrice, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            No data found
        @endif
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush

