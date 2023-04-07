@extends('adminend.layouts.default')
@section('title', 'Order status')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Order Status</h6>
        <div class="actions">
            <a href="{{ route('admin.order-statuses.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        {{-- Show flash success or error message --}}
        @if(Session::has('error'))
            <div class="alert mb-8 error">{{ Session::get('message') }}</div>
        @endif

        @if(Session::has('message'))
            <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif

        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th class="w-20">ID</th>
                    <th>Name</th>
                    <th class="w-40">Customer Visibility</th>
                    <th class="w-40">Seller Visibility</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($orderStatuses as $orderStatus)
                    <tr>
                        <td class="text-center">{{ $orderStatus->id }}</td>
                        <td>{{ $orderStatus->name }}</td>
                        <td class="text-center">{{ $orderStatus->customer_visibility == 1 ? 'True' : 'False' }}</td>
                        <td class="text-center">{{ $orderStatus->seller_visibility == 1 ? 'True' : 'False' }}</td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.order-statuses.edit', $orderStatus->id) }}">Edit</a>
                            {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.order-statuses.show', $orderStatus->id) }}">Show</a> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            {{-- @if ($orderStatuses->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $orderStatuses->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
                </div>
            @endif --}}
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

