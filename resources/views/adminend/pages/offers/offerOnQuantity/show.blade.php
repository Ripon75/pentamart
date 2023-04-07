@extends('adminend.layouts.default')
@section('title', 'Offer Quantity Show')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Offers</h6>
        <div class="actions">
            <a href="{{ route('admin.offers.quantity.index') }}" class="action btn btn-primary">Offers</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <form action="{{ route('admin.offers.quantity.update', $offer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-12 gap-2">
                    <div class="card shadow body p-4 col-span-4 mt-4">
                        <table class="table-auto w-full">
                            <thead class="">
                                <tr class="bg-gray-100">
                                    <th class="text-left border p-2">Offer Name</th>
                                    <th class="text-left border p-2">Status</th>
                                    <th class="text-left border p-2">Start Date</th>
                                    <th class="text-left border p-2">End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border p-2"> {{ $offer->name }} </td>
                                    <td class="border p-2"> {{ $offer->status }} </td>
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
                                    <th class="text-left border p-2">Product</th>
                                    <th class="text-left border p-2">Quantity</th>
                                    <th class="text-left border p-2">Unit Price</th>
                                    <th class="text-left border p-2" title="Discount Amount">Dis. Amount</th>
                                    <th class="text-left border p-2" title="Discount Percent">Dis. Percent</th>
                                </tr>
                            </thead>
                            <tbody class="items-table-body">
                                @foreach ($offer->productsQty as $product)
                                <tr>
                                    <td class="text-center border p-2" style="width: 70px; height:40px">
                                        <img src="{{ $product->image_src }}" alt="Product Image">
                                    </td>
                                    <td class="border p-2"> {{ $product->name }} </td>
                                    <td class="border p-2"> 
                                        {{ $product->pivot->quantity }}
                                    </td>
                                    <td class="border p-2 text-right">
                                        <span>Tk</span>
                                        <span class="ml-1">{{ $product->mrp }}</span>
                                    </td>
                                    <td class="border p-2">
                                        {{ $product->pivot->discount_amount ?? null }}
                                    </td>
                                    <td class="border p-2">
                                        {{ $product->pivot->discount_percent ?? null }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection