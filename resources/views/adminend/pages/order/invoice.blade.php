@extends('adminend.layouts.print')
@section('title', 'Invoice')
@section('content')


<section class="page mx-auto w-full md:full lg:w-[793px]">
    <div class="my-4 flex justify-end no-print">
        <button class="btn btn-primary" onclick="window.print()">Print</button>
    </div>
    <div class="bg-white">
        <div class="p-12">
            {{-- Header section --}}
            <div class="grid grid-cols-12 border-b pb-1 items-center gap-2">
                <span class="col-span-8">
                    <img class="h-12 w-auto" src="/images/adminend/logo.png" alt="Logo">
                </span>
                <div class="col-span-4">
                    <div class="text-black text-sm">
                        <span class="font-semibold">Helpline No:&nbsp;</span><span>+8801*********</span>
                    </div>
                    <div class="text-sm">
                        <span class="font-semibold">Email:&nbsp;</span><span>pentamart@gmail.com</span>
                    </div>
                </div>
            </div>
            {{-- Info section --}}
            <div class="grid grid-cols-12 gap-2 mt-4">
                <div class="col-span-8">
                    <div class="font-bold">Order Info</div>
                    <div>
                        <span class="text-sm font-semibold">Order ID:</span> <span class="text-sm">{{ $order->id }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-semibold">Order Date:</span> <span class="text-sm">{{ $order->created_at }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-semibold">Payment Status:</span>
                        @if ($order->is_paid)
                        <span class="text-sm">Paid</span>
                        @else
                        <span class="text-sm">Not Paid</span>
                        @endif
                    </div>
                    <div class="">
                        <span class="text-sm font-semibold">Payment Type:</span>
                        <span class="text-sm">{{ $order->paymentGateway->name ?? null }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-semibold">Total Items:</span>
                        <span class="text-sm">{{( $order->items->count()) ?? null }}</span>
                    </div>
                </div>
                <div class="col-span-4">
                    <div class="font-bold">Delivery Address</div>
                    <div>
                        <span class="text-sm font-semibold">Name:</span> <span class="text-sm">{{ ($order->user->name) ?? null }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-semibold">Phone:</span> <span class="text-sm">{{ ($order->user->phone_number) ?? null }}</span>
                    </div>
                    <div class="text-sm">
                        <span class="font-semibold">Address:&nbsp;</span><span class="font-normal">{{ $order->address }}</span>
                    </div>
                    <div class="text-sm">
                        <span class="font-semibold">District: <span class="font-normal">{{ ($order->shippingAddress->district->name) ?? null }}</span></span>
                    </div>
                </div>
            </div>
            {{-- Items list --}}
            <div class="mt-4">
                <table class="w-full">
                    <thead>
                        <tr class="text-sm border border-black">
                            <th width="32px" class="border-r border-black text-center">SN</th>
                            <th width="auto" class="border-r border-black text-left pl-1">Product</th>
                            <th width="60px" class="border-r border-black text-right pr-1">Quantity</th>
                            <th width="90px" class="border-r border-black text-right pr-1">MRP</th>
                            <th width="90px" class="border-r border-black text-right pr-1">Discount</th>
                            <th width="100px" class="border-r border-black text-right pr-1">Price</th>
                            <th width="110px" class="text-right pr-1">Item Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $key => $item)
                        @php
                            $itemQty            = $item->pivot->quantity;
                            $itemMRP            = $item->pivot->item_mrp;
                            $itemDiscount       = $item->pivot->item_discount;
                            $itemSellPrice      = $item->pivot->item_sell_price;
                            $itemTotalSellPrice = $itemSellPrice * $itemQty;
                        @endphp
                        <tr class="border border-black text-sm">
                            <td class="border-black border text-center">{{ ++$key }}</td>
                            <td class="border-black border text-left font-medium pl-1">{{ $item->name }}</td>
                            <td class="border-black border text-right pr-1 whitespace-nowrap px-1">{{ $itemQty }}</td>
                            <td class="border-black border text-right pr-1">{{ number_format($itemMRP, 2) }}</td>
                            <td class="border-black border text-right pr-1">{{ number_format($itemDiscount, 2) }}</td>
                            <td class="border-black border text-right pr-1">{{ number_format($itemSellPrice, 2) }}</td>
                            <td class="border-black border text-right pr-1">{{ number_format($itemTotalSellPrice, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                        <tr class="text-sm border border-black">
                            <td class="text-center"colspan="1">#</td>
                            <td class="font-medium border border-black pl-1 text-right pr-2" colspan="3">Total</td>
                            <td class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($order->mrp, 2) }}</td>
                            <td class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($order->discount, 2) }}</td>
                            <td class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($order->sell_price, 2) }}</td>
                        </tr>
                    </tfoot> --}}
                </table>
                <div class="grid grid-cols-12 gap-2">
                    <div class="mt-6 col-span-8">
                        <div class="">
                            <table class="w-full">
                                <tfoot class="">
                                    <span class="font-medium text-sm">Note: </span>
                                    <span class="text-xs">{{ $order->note }}</span>
                                </tfoot>
                            </table>
                        </div>
                        <div class="">
                            <table class="w-full">
                                <tfoot class=" ">
                                    <span class="font-medium text-sm">Cannot return if:</span><br>
                                    <ul class="text-xs mt-1">
                                        <li><i class="mr-2 fa-solid fa-hand-point-right"></i>The items have been opened, partially used or damaged.</li>
                                        <li><i class="mr-2 fa-solid fa-hand-point-right"></i>Any refrigerated items like insulin or products that are heat sensitive.</li>
                                        <li><i class="mr-2 fa-solid fa-hand-point-right"></i>The items have been opened, partially used or disfigured.</li>
                                        <li><i class="mr-2 fa-solid fa-hand-point-right"></i>The item’s packaging/box or seal has been remove/broken/tampered.</li>
                                        <li><i class="mr-2 fa-solid fa-hand-point-right"></i>The return window for items in an order has expired. 7 days from the delivery date.</li>
                                        <li><i class="mr-2 fa-solid fa-hand-point-right"></i>Mentioned on the product details page that the item is non-returnable.</li>
                                    </ul>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="w-full col-span-4">
                        <table class="w-full mt-8">
                            <tfoot class="">
                                <tr class="text-sm text-right">
                                    <td class="text-left font-medium" colspan="4"></td>
                                    <td class="border border-black pr-1 font-medium">Total</td>
                                    <td class="border pr-1 border-black">{{ number_format($order->mrp, 2) }} tk.</td>
                                </tr>
                                <tr class="text-sm text-right">
                                    <td class="" colspan="4"></td>
                                    <td class="border border-black pr-1 font-medium">Shipping</td>
                                    <td class="border pr-1 border-black">
                                        {{ number_format($order->delivery_charge, 2) }} tk.
                                    </td>
                                </tr>
                                <tr class="text-sm text-right">
                                    <td class="" colspan="4"></td>
                                    <td class="border border-black pr-1 font-medium">Items Discount</td>
                                    <td class="border pr-1 border-black"> -
                                        {{ number_format($order->discount, 2) }}tk.
                                    </td>
                                </tr>
                                @if($order->coupon)
                                    <tr class="text-sm text-right">
                                        <td class="" colspan="4"></td>
                                        <td class="border border-black pr-1 font-medium">Coupon Discount</td>
                                        <td class="border pr-1 border-black"> - {{ number_format($order->coupon_value, 2) }} tk.</td>
                                    </tr>
                                @endif
                                <tr class="text-sm text-right">
                                    <td class="" colspan="4"></td>
                                    <td class="border border-black pr-1 font-medium">Total</td>
                                    <td class="border pr-1 border-black">{{ number_format($order->net_price, 2) }} tk.</td>
                                </tr>
                                <tr class="text-sm text-right">
                                    <td class="" colspan="4"></td>
                                    <td class="border border-black font-bold pr-1">Payable</td>
                                    @if ($order->is_paid)
                                        <td class="border pr-1 border-black font-bold"> 0 Tk.</td>
                                    @else
                                        <td class="border pr-1 border-black font-bold">{{ number_format(round($order->payable_price), 2) }} tk.</td>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script>

    </script>
@endpush
