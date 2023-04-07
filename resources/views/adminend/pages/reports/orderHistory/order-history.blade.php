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
                    <a href="{{ route('admin.orders.report') }}" class="btn btn-clear">Clear</a>
                </div>
            </form>
        </div>
        @if(count($orders))
            <div class="mt-8" id="table-report">
                <table class="table-report w-full">
                    <thead class="bg-gray-100 shadow-sm">
                        <th>SN</th>
                        <th style="width: 80px;">Order ID</th>
                        <th style="width: 80px;">Order Ref.</th>
                        <th style="width: 100px;">Order Date</th>
                        <th>Customer Name</th>
                        <th>Customer Contact</th>
                        <th style="text-align: right;">Items MRP</th>
                        <th style="text-align: right;">Items Discount</th>
                        <th style="text-align: right;">Sub Total</th>
                        <th style="text-align: right;">Delivery Amount</th>
                        <th style="text-align: right;">Coupon Discount</th>
                        <th style="text-align: right;">Special Discount</th>
                        <th style="text-align: right;">Total Amount</th>
                    </thead>
                    <tbody>
                        @php
                            $itemsTotalMRP       = 0;
                            $itemsTotalDiscount  = 0;
                            $itemsTotalAmount    = 0;
                            $totalDeliveryAmount = 0;
                            $totalCouponDiscount = 0;
                            $totalSpecialDiscout = 0;
                            $totalAmount         = 0;
                        @endphp
                        @foreach ($orders as $key => $order)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td style="width: 80px;">{{ $order->id }}</td>
                            <td style="width: 80px;">{{ $order->ref_code }}</td>
                            <td style="width: 100px;">{{ date('d-m-Y', strtotime($order->ordered_at)) }}</td>
                            <td>{{ $order->user->name ?? null }}</td>
                            <td>{{ $order->user->phone_number ?? null }}</td>
                            @php
                                $itemsMRP = $order->order_items_mrp;
                                $itemsTotalMRP += $itemsMRP;
                            @endphp
                            <td style="text-align: right;">{{ number_format($itemsMRP, 2) }}</td>
                            @php
                                $itemsDiscount = $order->total_items_discount;
                                $itemsTotalDiscount += $itemsDiscount;
                            @endphp
                            <td style="text-align: right;">{{ number_format($itemsDiscount, 2) }}</td>
                            @php
                                $itemsPrice = $order->order_items_value;
                                $itemsTotalAmount += $itemsPrice;
                            @endphp
                            <td style="text-align: right;">{{ number_format($itemsPrice, 2) }}</td>
                            @php
                                $deliveryCharge = $order->delivery_charge;
                                $totalDeliveryAmount += $deliveryCharge;
                            @endphp
                            <td style="text-align: right;">{{ number_format($deliveryCharge, 2) }}</td>
                            @php
                                $couponDiscunt = $order->coupon_value;
                                $totalCouponDiscount += $couponDiscunt;
                            @endphp
                            <td style="text-align: right;">{{ number_format($couponDiscunt, 2) }}</td>
                            @php
                                $specialDiscout = $order->total_special_discount;
                                $totalSpecialDiscout += $specialDiscout;
                            @endphp
                            <td style="text-align: right;">{{ number_format($specialDiscout, 2) }}</td>
                            @php
                                $totalWithDeliveryCharge = $order->payable_order_value;
                                $totalAmount += $totalWithDeliveryCharge;
                            @endphp
                            <td style="text-align: right;">{{ number_format($totalWithDeliveryCharge, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-sm border border-black">
                            <td class="text-center"colspan="1">#</td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-2" colspan="5">Ground Total : </td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($itemsTotalMRP, 2) }} </td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($itemsTotalDiscount, 2) }} </td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($itemsTotalAmount, 2) }} </td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($totalDeliveryAmount, 2) }}</td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($totalCouponDiscount, 2) }}</td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($totalSpecialDiscout, 2) }}</td>
                            <td style="text-align: right;" class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($totalAmount, 2) }}</td>
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

