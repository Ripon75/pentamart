@extends('adminend.layouts.default')
@section('title', 'Coupon codes')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Coupon Code</h6>
        <div class="actions">
            <a href="{{ route('admin.coupon-codes.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('error'))
            <div class="alert mb-8 error">{{ Session::get('message') }}</div>
        @endif

        @if(Session::has('message'))
            <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif
        <form action="{{ route('admin.coupon-codes.index') }}" method="GET">
            @csrf
            <div class="action-bar mb-4 flex items-end space-x-2">
                <div class="flex flex-col">
                    <label for="">Name</label>
                    <input type="text" class="border border-gray-300 rounded w-48 h-10" name="name"
                        value="{{ request()->input('name') }}">
                </div>
                <div class="flex flex-col">
                    <label for="">Code</label>
                    <input type="text" class="border border-gray-300 rounded w-36 h-10" name="code"
                        value="{{ request()->input('code') }}">
                </div>
                <div class="flex flex-col">
                    <label for="">Discount Type</label>
                    <input type="text" class="border border-gray-300 rounded w-36 h-10" name="discount_type"
                        value="{{ request()->input('discount_type') }}">
                </div>
                <div class="flex flex-col">
                    <label for="">Status</label>
                    <input type="text" class="border border-gray-300 rounded w-36 h-10" name="status"
                        value="{{ request()->input('status') }}">
                </div>
                <button class="btn btn-outline-success" type="submit">Search</button>
                <a href="{{ route('admin.coupon-codes.index') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
            </div>
        </form>
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Discount Type</th>
                    <th>Discount amount</th>
                    <th>Minimum cart amount</th>
                    <th>Stataus</th>
                    <th>Applicable ON</th>
                    <th>Started at</th>
                    <th>Ended at</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $data)
                    <tr>
                        <td class="text-center">{{ $data->id }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->code }}</td>
                        <td>{{ $data->discount_type }}</td>
                        <td class="text-right">{{ $data->discount_amount }}</td>
                        <td class="text-right">{{ $data->min_cart_amount }}</td>
                        <td class="text-center">{{ $data->status }}</td>
                        <td>{{ $data->applicable_on }}</td>
                        <td>{{ $data->started_at->format('Y-m-d') ?? null }}</td>
                        <td>{{ $data->ended_at->format('Y-m-d') ?? null }}</td>
                        <td>
                            <a class="btn btn-success btn-sm" href="{{ route('admin.coupon-codes.edit', $data->id) }}">Edit</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.coupon-codes.show', $data->id) }}">Show</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($coupons->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $coupons->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 4000 );
    </script>
@endpush
