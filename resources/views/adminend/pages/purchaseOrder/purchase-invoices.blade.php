@extends('adminend.layouts.print')
@section('title', 'Purchase Invoice')
@section('content')

<div class="page">
    <div class="page-toolbar sticky top-0 z-10">
        <h6 class="title">Purchase Invoice List</h6>
        <div class="actions">
            <a onclick="window.print()" class="action btn btn-primary">Print</a>
        </div>
    </div>
    <div class="page-content">
        <section class="page mx-auto w-full md:full lg:w-[793px]">
            @foreach ($purchahseOrders as $order)
                <div class="bg-white mt-4">
                    <div style="page-break-after: always;" class="p-10">
                        {{-- Header section --}}
                        <div class="grid grid-cols-12 border-b pb-1 items-center gap-2">
                            <span class="col-span-8">
                                <img class="h-12 w-auto" src="/images/logos/logo-full-color.svg" alt="Logo">
                            </span>
                            <div class="col-span-4">
                                <div class="text-black text-sm">
                                    <span class="font-semibold">Helpline No:&nbsp;</span><span>09609080706</span>
                                </div>
                                <div class="text-sm">
                                    <span class="font-semibold">Email:&nbsp;</span><span>contact@medicart.health</span>
                                </div>
                            </div>
                        </div>
                        {{-- Info section --}}
                        <div class="grid grid-cols-12 gap-2 mt-4">
                            <div class="col-span-8">
                                <div class="font-bold">Purchase Info</div>
                                <div>
                                    <span class="text-sm font-semibold">Purchase ID:</span> <span class="text-sm">{{ $order->id }}</span>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold">Purchase Date:</span> <span class="text-sm">{{ $order->created_at }}</span>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold">Total Items:</span> <span class="text-sm">{{( $order->purchaseItems->count()) ?? null }}</span>
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
                                        <th width="90px" class="border-r border-black text-right pr-1">MRP (Tk.)</th>
                                        <th width="110px" class="text-right pr-1">Purchase Price (Tk.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->purchaseItems as $key => $item)
                                    <tr class="border border-black text-sm">
                                        <td class="border-black border text-center">{{ ++$key }}</td>
                                        <td class="border-black border text-left font-medium pl-1">
                                            {{ $item->item->name }}
                                        </td>
                                        <td class="border-black border text-right pr-1">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="border-black border text-right pr-1">
                                            @php
                                                $itemMRP = $item->mrp * $item->quantity;
                                            @endphp
                                            {{ number_format($itemMRP, 2) }}
                                        </td>
                                        <td class="border-black border text-right pr-1">
                                            @php
                                                $itemUnitPrice = $item->quantity * $item->purchased_price;
                                            @endphp
                                            {{ number_format($itemUnitPrice, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    </div>
</div>

@endsection
