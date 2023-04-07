@extends('sellercenter.layouts.default')
@section('title', 'Product Price Logs')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Product Price Logs</h6>
    </div>
    <div class="page-content">
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th>ID</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Old MRP</th>
                    <th>New MRP</th>
                    <th>Old Selling Price</th>
                    <th>New Selling Price</th>
                    <th>Logged At</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($productPriceLogs as $key => $data)
                    <tr>
                        <td class="text-center">{{ ++$key }}</td>
                        <td>{{ $data->user->name ?? '' }}</td>
                        <td>{{ $data->product->name ?? '' }}</td>
                        <td class="text-right">{{ $data->old_mrp ?? 'N/A' }}</td>
                        <td class="text-right">{{ $data->new_mrp ?? 'N/A' }}</td>
                        <td class="text-right">{{ $data->old_selling_price ?? 'N/A' }}</td>
                        <td class="text-right">{{ $data->new_selling_price ?? 'N/A' }}</td>
                        <td>{{ $data->logged_at ? $data->logged_at->format('d-m-Y H:i:s') : '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($productPriceLogs->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $productPriceLogs->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection