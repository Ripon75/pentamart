@extends('adminend.layouts.default')
@section('title', 'Offer BSGS Show')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Offers</h6>
        <div class="actions">
            <a href="{{ route('admin.offers.bsgs.index') }}" class="action btn btn-primary">Offers</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="grid grid-cols-12 gap-2">
                <div class="card shadow body p-4 col-span-4 mt-4">
                    <table class="table-auto w-full">
                        <thead class="">
                            <tr class="bg-gray-100">
                                <th class="text-left border p-2">Offer Name</th>
                                <th class="text-left border p-2">Start Date</th>
                                <th class="text-left border p-2">End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2"> {{ $offer->name }} </td>
                                <td class="border p-2"> {{ $offer->start_date }} </td>
                                <td class="border p-2"> {{ $offer->end_date }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Order details update -->
                <div class="card shadow body p-4 col-span-8 mt-4">
                    <table class="table-auto w-full">
                        <thead class="">
                            <tr class="bg-gray-100">
                                <th class="text-left border p-2">Image</th>
                                <th class="text-left border p-2">Buy Product</th>
                                <th class="text-left border p-2">Buy Qty</th>
                                <th class="text-left border p-2">Image</th>
                                <th class="text-left border p-2">Get Product</th>
                                <th class="text-left border p-2">Get Qty</th>
                            </tr>
                        </thead>
                        <tbody class="items-table-body">
                            @foreach ($offer->productsBSGSBuy as $product)
                            <tr>
                                <td class="text-center border p-2" style="width: 70px; height:40px">
                                    <img src="{{ $product->image_src }}" alt="Product Image">
                                </td>
                                <td class="border p-2"> {{ $product->pivot->buy_product_id }} </td>
                                <td class="border p-2"> 
                                    {{ $product->pivot->buy_qty ?? null }}
                                </td>
                                <td class="text-center border p-2" style="width: 70px; height:40px">
                                    <img src="{{ $product->image_src }}" alt="Product Image">
                                </td>
                                <td class="border p-2">
                                    <span class="ml-1">{{ $product->pivot->get_product_id }}</span>
                                </td>
                                <td class="border p-2">
                                    {{ $product->pivot->get_qty ?? null }}
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
@endsection