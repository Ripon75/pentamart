@extends('frontend.layouts.default')
@section('title', 'My-Order-details')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            <div class="col-span-4">
                <div class="bg-white">
                    <div class="p-2 md:p-6">
                        <div class="flex-wrap md:flex justify-between">
                            <div>
                                <div>
                                    <span class="text-sm font-medium">Order ID:</span> <span class="text-sm">{{ $order->id }}</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium">Order Date:</span> <span class="text-sm">{{ $order->created_at }}</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium">Payment Status:</span>
                                    @if ($order->is_paid)
                                    <span class="text-sm">Paid</span>
                                    @else
                                    <span class="text-sm">Not Paid</span>
                                    @endif
                                </div>
                                <div class="">
                                    <span class="text-sm font-medium">Payment Type:</span>
                                    <span class="text-sm">{{ $order->paymentGateway->name ?? null }}</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium">Total Items:</span> <span class="text-sm">{{( $order->items->count()) ?? null }}</span>
                                </div>
                            </div>
                            <div class="mt-2 md:mt-0 text-left md:text-right">
                                {{-- <div class="font-bold">Delivery Address</div> --}}
                                <div>
                                    <span class="text-sm font-medium">Name:</span> <span class="text-sm">{{ ($order->user->name) ?? null }}</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium">Phone:</span> <span class="text-sm">{{ ($order->user->phone_number) ?? null }}</span>
                                </div>
                                <div class="flex flex-col text-sm">
                                    <span class="w-full md:w-60 font-medium">Address: <span class="font-normal">{{ ($order->shippingAddress->address) ?? null }}</span></span>
                                    <span class="font-medium">Area: <span class="font-normal">{{ ($order->shippingAddress->area->name) ?? null }}</span></span>
                                </div>
                            </div>
                        </div>
                        {{-- Items list --}}
                        <div class="mt-4">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-xs md:text-sm border border-black">
                                        <th width="32px" class="border-r border-black text-center">SN</th>
                                        <th width="auto" class="border-r border-black text-left pl-1">Product</th>
                                        <th width="100px" class="border-r border-black text-right pr-1">Quantity</th>
                                        <th width="110px" class="border-r border-black text-right pr-1">MRP</th>
                                        <th width="110px" class="border-r border-black text-right pr-1">Discount</th>
                                        <th width="110px" class="border-r border-black text-right pr-1">Price</th>
                                        <th width="120px" class="text-right pr-1">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $key => $item)
                                        <tr class="border border-black text-sm">
                                            <td width="40px" class="border-black border text-center">{{ ++$key }}</td>
                                            <td width="auto" class="text-xs md:text-sm border-black border text-left font-medium pl-1">
                                                {{ $item->name }}
                                            </td>
                                            @php
                                                $currency           = config('crud.currency');
                                                $quantity           = $item->pivot->quantity;
                                                $itemMRP            = $item->pivot->item_mrp;
                                                $itemDiscount       = $item->pivot->item_discount;
                                                $itemSellPrice      = $item->pivot->item_sell_price;
                                                $itemTitalSellPrice = $itemSellPrice * $quantity;
                                            @endphp
                                            <td width="100px" class="border-black border text-right pr-1">
                                                {{ $quantity }}
                                            </td>
                                            <td width="100px" class="border-black border text-right pr-1">
                                                {{ number_format($itemMRP, 2) }}
                                            </td>
                                            <td width="100px" class="border-black border text-right pr-1">
                                                {{ number_format($itemDiscount, 2) }}
                                            </td>
                                            <td width="100px" class="border-black border text-right pr-1">
                                                {{ number_format($itemSellPrice, 2) }}
                                            </td>
                                            <td width="100px" class="border-black border text-right pr-1">
                                                {{ number_format($itemTitalSellPrice, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="text-sm border border-black">
                                        <td class="text-center"colspan="1">#</td>
                                        <td class="font-medium border border-black pl-1 text-right pr-2" colspan="3">Total</td>
                                        <td class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($order->mrp, 2) }}</td>
                                        <td class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($order->discount, 2) }}</td>
                                        <td class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($order->sell_price, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="grid grid-cols-12 gap-0 md:gap-2">
                                <div class="mt-6 col-span-12 md:col-span-8 order-last md:order-first">
                                    <div class="">
                                        <table class="w-full">
                                            <tfoot class="">
                                                <span class="font-medium text-sm">Note: </span>
                                                <span class="text-xs">{{ $order->note }}</span>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="w-full col-start-5 col-span-8 md:col-span-4">
                                    <table class="w-full mt-8">
                                        <tfoot class="">
                                            <tr class="text-sm text-right">
                                                <td class="text-left font-medium" colspan="4"></td>
                                                <td class="border border-black pr-1 font-medium">Total</td>
                                                <td class="border pr-1 border-black">
                                                    {{ number_format($order->mrp, 2) }} {{ $currency }}
                                                </td>
                                            </tr>
                                            <tr class="text-sm text-right">
                                                <td class="" colspan="4"></td>
                                                <td class="border border-black pr-1 font-medium">Shipping</td>
                                                <td class="border pr-1 border-black">
                                                    {{ number_format((float)$order->delivery_charge, 2) }} {{ $currency }}
                                                </td>
                                            </tr>
                                            <tr class="text-sm text-right">
                                                <td class="" colspan="4"></td>
                                                <td class="border border-black pr-1 font-medium">Items Discount</td>
                                                <td class="border pr-1 border-black"> -
                                                    {{ number_format($order->discount, 2) }} {{ $currency }}
                                                </td>
                                            </tr>
                                            @if($order->coupon)
                                                <tr class="text-sm text-right">
                                                    <td class="" colspan="4"></td>
                                                    <td class="border border-black pr-1 font-medium">Coupon Discount</td>
                                                    <td class="border pr-1 border-black">
                                                        - {{ number_format($order->coupon_value, 2) }} {{ $currency }}
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr class="text-sm text-right">
                                                <td class="" colspan="4"></td>
                                                <td class="border border-black font-bold pr-1">Payable</td>
                                                @if ($order->is_paid)
                                                    <td class="border-b border-r pr-2 bg-gray-300 font-bold"> 0 {{ $currency }}</td>
                                                @else
                                                    <td class="border pr-1 border-black font-bold">
                                                        {{ number_format(round($order->payable_price), 2) }} {{ $currency }}
                                                    </td>
                                                @endif
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script>
        // Category Menu for User order
        function menuToggleCategory() {
            var categoryList = document.getElementById('category-list-menu');
            if(categoryList.style.display == "none") { // if is menuBox displayed, hide it
                categoryList.style.display = "block";
            }
            else { // if is menuBox hidden, display it
                categoryList.style.display = "none";
            }
        }
    </script>
@endpush
