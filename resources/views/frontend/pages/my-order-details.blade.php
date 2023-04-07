@extends('frontend.layouts.default')
@section('title', 'My-Order-details')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            {{-- =======List========= --}}
            <div class="col-span-1 hidden sm:hidden md:hidden lg:block xl:block 2xl:block">
                <x-frontend.customer-nav/>
            </div>
            {{-- =============== --}}
            <div class="col-span-3">
                <div class="flex space-x-2 sm:space-x-2 md:space-x-2 lg:space-x-0 xl:space-x-0 2xl:space-x-0">
                    <div class="relative block sm:block md:block lg:hidden xl:hidden 2xl:hidden">
                        <button id="category-menu" onclick="menuToggleCategory()" class="h-[46px] w-14 bg-white flex items-center justify-center rounded border-2">
                            <i class="text-xl fa-solid fa-ellipsis-vertical"></i>
                        </button>
                          {{-- ===Mobile menu for order details===== --}}
                        <div id="category-list-menu" style="display: none" class="absolute left-0 w-60">
                            <x-frontend.customer-nav/>
                        </div>
                    </div>
                    <div class="mb-4 flex-1">
                        <x-frontend.header-title
                            type="else"
                            title="Order #{{ $order->id }}"
                            bg-Color="#102967"
                        />
                    </div>
                </div>
                @if (!$order->is_paid && !($order->current_status_id == 3 || $order->current_status_id == 8 || $order->current_status_id == 9))
                    <div class="my-4 rounded bg-white p-4">
                        <form class="flex flex-row-reverse" action="{{ route('my.order.payment', $order->id) }}">
                            {{-- Paid option --}}
                            <div>
                                <button class="btn bg-green-400 hover:bg-green-500 text-gray-600 ml-4">
                                    Make Payment
                                </button>
                            </div>
                            <div class="flex flex-col">
                                <select name="payment_method_id" class="border-gray-300 focus:ring-0 focus:outline-none rounded">
                                    <option value="">Select Payment method</option>
                                    @foreach ($paymentGateways as $pg)
                                        <option value="{{ $pg->id }}">{{ $pg->name }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method_id')
                                    <span class="form-helper error text-red-500 text-sm my-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                @endif
                <div class="bg-white">
                    <div class="p-2 md:p-12">
                        {{-- Info section --}}
                        <div class="flex-wrap md:flex justify-between">
                            <div>
                                <div class="font-bold">Order Info</div>
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
                                <div class="font-bold">Delivery Address</div>
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
                                        <th width="110px" class="border-r border-black text-right pr-1">MRP (Tk.)</th>
                                        <th width="110px" class="border-r border-black text-right pr-1">Discount (Tk.)</th>
                                        <th width="120px" class="text-right pr-1">Sub Total (Tk.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $key => $item)
                                        <tr class="border border-black text-sm">
                                            <td width="40px" class="border-black border text-center">{{ ++$key }}</td>
                                            <td width="auto" class="text-xs md:text-sm border-black border text-left font-medium pl-1">
                                                {{ $item->name }} (Pack size: {{ $item->pivot->pack_size }})
                                            </td>
                                            <td width="100px" class="border-black border text-right pr-1">
                                                {{ $item->pivot->quantity }}
                                            </td>
                                            @php
                                                $itemQuantity      = $item->pivot->quantity;
                                                $itemTotalMRP      = $item->pivot->item_mrp * $itemQuantity;
                                                $itemTotalPrice    = $item->pivot->price * $itemQuantity;
                                                $itemTotalDiscount = $itemTotalMRP - $itemTotalPrice;
                                            @endphp
                                            <td width="100px" class="border-black border text-right pr-1">
                                                {{ number_format($itemTotalMRP, 2) }}
                                            </td>
                                            <td width="100px" class="border-black border text-right pr-1">
                                                {{ number_format($itemTotalDiscount, 2) }}
                                            </td>
                                            <td width="100px" class="border-black border text-right pr-1">
                                                {{ number_format($itemTotalPrice, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="text-sm border border-black">
                                        <td class="text-center"colspan="1">#</td>
                                        <td class="font-medium border border-black pl-1 text-right pr-2" colspan="2">Total</td>
                                        <td class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($order->order_items_mrp, 2) }}</td>
                                        <td class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($order->total_items_discount, 2) }}</td>
                                        <td class="font-medium border border-black pl-1 text-right pr-1">{{ number_format($order->order_items_value, 2) }}</td>
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

                                <div class="w-full col-start-5 col-span-8 md:col-span-4">
                                    <table class="w-full mt-8">
                                        <tfoot class="">
                                            <tr class="text-sm text-right">
                                                <td class="text-left font-medium" colspan="4"></td>
                                                <td class="border border-black pr-1 font-medium">Total</td>
                                                <td class="border pr-1 border-black">{{ number_format($order->order_items_mrp, 2) }} Tk.</td>
                                            </tr>
                                            <tr class="text-sm text-right">
                                                <td class="" colspan="4"></td>
                                                <td class="border border-black pr-1 font-medium">Shipping</td>
                                                <td class="border pr-1 border-black">
                                                    {{ number_format((float)$order->delivery_charge, 2) }} Tk.
                                                </td>
                                            </tr>
                                            <tr class="text-sm text-right">
                                                <td class="" colspan="4"></td>
                                                <td class="border border-black pr-1 font-medium">Items Discount</td>
                                                <td class="border pr-1 border-black"> -
                                                    @if ($order->coupon && $order->coupon->applicable_on === 'products')
                                                        <span class="line-through">
                                                            {{ number_format($order->total_items_discount, 2) }}Tk.
                                                        </span>
                                                    @else
                                                        {{ number_format($order->total_items_discount, 2) }}Tk.
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($order->coupon)
                                                <tr class="text-sm text-right">
                                                    <td class="" colspan="4"></td>
                                                    <td class="border border-black pr-1 font-medium">Coupon Discount</td>
                                                    <td class="border pr-1 border-black"> - {{ number_format($order->coupon_value, 2) }} Tk.</td>
                                                </tr>
                                            @endif
                                            @if($order->total_special_discount > 0)
                                                <tr class="text-sm text-right">
                                                    <td class="" colspan="4"></td>
                                                    <td class="border border-black pr-1 font-medium">Special Discount</td>
                                                    <td class="border pr-1 border-black"> - {{ number_format($order->total_special_discount, 2) }} Tk.</td>
                                                </tr>
                                            @endif
                                            <tr class="text-sm text-right">
                                                <td class="" colspan="4"></td>
                                                <td class="border border-black pr-1 font-medium">Grand Total</td>
                                                <td class="border pr-1 border-black">{{ number_format($order->payable_order_value, 2) }} Tk.</td>
                                            </tr>
                                            <tr class="text-sm text-right">
                                                <td class="" colspan="4"></td>
                                                <td class="border border-black font-bold pr-1">Payable</td>
                                                @if ($order->is_paid)
                                                    <td class="border-b border-r pr-2 bg-gray-300 font-bold"> 0 Tk.</td>
                                                @else
                                                    <td class="border pr-1 border-black font-bold">{{ number_format(round($order->payable_order_value), 2) }} Tk.</td>
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
