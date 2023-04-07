@extends('adminend.layouts.print')
@section('title', 'Purchase order')
@section('content')


<section class="page mx-auto w-[928px]">
    <div class="my-4 flex justify-end no-print">
        <button class="btn btn-primary" onclick="window.print()">Print</button>
    </div>
    <div class="bg-white">
        <div class="p-8">
            {{-- Header section --}}
            <div class="flex justify-between border-b pb-4">
                <img class="h-12 w-auto" src="/images/logos/logo-full-color.svg" alt="">
                <div>
                    <div class="text-right text-black">
                        <span>Invoice ID </span>
                        <span class="font-medium">#{{ $order->id }}</span>
                    </div>
                </div>
            </div>
            {{-- Info section --}}
            <div class="flex justify-between mt-4">
                <div>
                    <div>
                        <span class="font-medium">Order to:</span><br>
                        <span class="font-medium">Xtrenza Model Pharmacy</span><br>
                        <span class="font-medium">21, Segun Bagicha, Ramna, Dhaka-1000</span><br>
                    </div>
                </div>
                <div>
                    <div class="font-bold">Purchase Order (PO)</div>
                    <div>
                        <span>Order date:</span> <span class="font-medium">{{ ($order->created_at->format('Y-m-d')) ?? null }}</span>
                    </div>
                    <div>
                        <span>Delivery date:</span> <span class="font-medium">{{ ($order->created_at->format('Y-m-d')) ?? null }}</span>
                    </div>
                </div>
            </div>
            {{-- Items list --}}
            <div class="mt-4 mb-16">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-300 text-sm border">
                            <th width="32px" class="text-center">SN</th>
                            <th width="auto" class="text-left">Product</th>
                            <th width="100px" class="text-center">Quantity</th>
                            <th width="100px" class="text-center">Unit Price (Tk.)</th>
                            <th width="100px" class="text-center">Sub Total (Tk.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($order->items as $item)
                        <tr class="border text-sm">
                            <td width="32px" class="text-center">{{ $i }}</td>
                            <td width="auto" class="text-left font-medium">{{ $item->name }}</td>
                            <td width="100px" class="text-center">{{ $item->pivot->quantity }}</td>
                            <td width="100px" class="text-right">{{ $item->pivot->price }}</td>
                            <td width="100px" class="text-right pr-2">{{ $item->pivot->quantity * $item->pivot->price }} Tk.</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-sm text-right">
                            @php
                                $itemTotalDiscount = 0;
                            @endphp
                            <td class="" colspan="3"></td>
                            <td class="border-b border-l">Discount</td>
                            <td class="border-b border-r pr-2"> -
                                @if ($order->coupon && $order->coupon->applicable_on === 'products' && $order->coupon->discount_type === 'percentage')
                                    <span class="line-through">
                                        {{ number_format($order->total_items_discount, 2) }}Tk.
                                        @php
                                            $itemTotalDiscount = $order->total_items_discount;
                                        @endphp
                                    </span>
                                @else
                                    {{ number_format($order->total_items_discount, 2) }}Tk.
                                @endif
                            </td>
                        </tr>
                        <tr class="text-sm text-right">
                            <td class="" colspan="3"></td>
                            <td class="border-b border-l">Subtotal</td>
                            @php
                                $subTotalAmount = $order->order_items_value + $itemTotalDiscount;
                            @endphp
                            <td class="border-b border-r pr-2">{{ number_format($subTotalAmount, 2) }} Tk.</td>
                        </tr>
                        <tr class="text-sm text-right">
                            <td class="" colspan="3"></td>
                            <td class="border-b border-l">Shipping</td>
                            <td class="border-b border-r pr-2">{{ $order->delivery_charge }} Tk.</td>
                        </tr>
                        <tr class="text-sm text-right">
                            <td class="" colspan="3"></td>
                            <td class="border-b border-l">Coupon Discount</td>
                            <td class="border-b border-r pr-2"> - {{ number_format($order->coupon_value, 2) }} Tk.</td>
                        </tr>
                        <tr class="text-sm text-right">
                            <td class="" colspan="3"></td>
                            <td class="border-b border-l bg-gray-200">Total</td>
                            <td class="border-b border-r pr-2 bg-gray-200">{{ number_format($order->payable_order_value, 2) }} Tk.</td>
                        </tr>
                        <tr class="text-sm text-right">
                            <td class="" colspan="3"></td>
                            <td class="border-b border-l bg-gray-300 font-medium">Payable</td>
                            @if ($order->is_paid)
                                <td class="border-b border-r pr-2 bg-gray-300 font-medium"> 0 Tk.</td>
                            @else
                                <td class="border-b border-r pr-2 bg-gray-300 font-medium">{{ number_format(round($order->payable_order_value), 2) }} Tk.</td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script>

    </script>
@endpush
