@extends('sellercenter.layouts.default')
@section('title', 'Products')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Product</h6>
        <div class="actions">
            <a href="{{ route('seller.products.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('error'))
            <div class="alert mb-8 error">{{ Session::get('error') }}</div>
        @endif
        @if(Session::has('message'))
            <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif
        <form action="{{ route('seller.products.index') }}" method="GET">
            <div class="action-bar mb-4 flex flex-wrap items-end space-x-2 space-y-2 bg-white pb-2">
                <div class="flex flex-col ml-2">
                    <label for="">ID</label>
                    <input type="number" class="border border-gray-300 rounded w-36 h-10" name="id"
                        value="{{ request()->input('id') }}" min="1">
                </div>
                <div class="flex flex-col">
                    <label for="">Name</label>
                    <input type="text" class="border border-gray-300 rounded w-48 h-10" name="name"
                        value="{{ request()->input('name') }}">
                </div>
                <div class="flex flex-col">
                    <label for="">Counter Type</label>
                    <input type="text" class="border border-gray-300 rounded w-36 h-10" name="counter_type"
                        value="{{ request()->input('counter_type') }}">
                </div>
                <div class="flex flex-col">
                    <label for="">Status</label>
                    <input type="text" class="border border-gray-300 rounded w-36 h-10" name="status"
                        value="{{ request()->input('status') }}">
                </div>
                 <div class="flex flex-col">
                    <label for="">Start Date</label>
                    <input type="date" class="border border-gray-300 rounded w-36 h-10" name="start_date"
                        value="{{ request()->input('start_date') }}">
                </div>
                <div class="flex flex-col">
                    <label for="">End Date</label>
                    <input type="date" class="border border-gray-300 rounded w-36 h-10" name="end_date"
                        value="{{ request()->input('end_date') }}">
                </div>
                <button class="btn btn-outline-success" type="submit">Search</button>
                <a href="{{ route('seller.products.index') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
            </div>
        </form>
        <div>
            <table class="table w-full">
                <thead>
                    <tr class="">
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>MRP</th>
                    <th>Sellign Price</th>
                    <th>Counter Type</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result as $data)
                    <tr>
                        <td class="text-center">{{ $data->id }}</td>
                        <td>
                            <img src="{{$data->image_src}}" style="width: 70px; height:40px" alt="Product Image">
                        </td>
                        <td>{{ $data->name }} ({{ $data->dosageForm->name ?? NULL }})</td>
                        <td class="text-right">{{ $data->mrp }}</td>
                        <td class="text-right">{{ $data->selling_price }}</td>
                        <td class="text-center">
                            <button class="border px-2 py-1 rounded text-white bg-orange-400 text-sm">
                                {{ $data->counter_type === '1' ? 'otc' : $data->counter_type }}
                            </button>
                        </td>
                        <td class="text-center">
                            @if ($data->status === 'activated')
                                <button class="border px-2 py-1 rounded text-white bg-green-400 text-sm">
                                    {{ $data->status }}
                                </button>
                            @else
                                <button class="border px-2 py-1 rounded text-white bg-red-400 text-sm">
                                    {{ $data->status }}
                                </button>
                            @endif
                        </td>
                        <td>
                            @if ($data->created_at)
                                {{ date('d-m-Y', strtotime($data->created_at)); }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="flex space-x-2 justify-center">
                                <a class="btn btn-success btn-sm" href="{{ route('seller.products.edit', $data->id) }}">Edit</a>
                                <form id="product-delete-form-{{ $data->id }}" action="{{ route('seller.products.delete', $data->id) }}" method="Post">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="button"
                                        class="btn-product-delete btn hover:bg-red-700 bg-red-500 btn-sm text-white"
                                        data-product-id="{{ $data->id }}">
                                        Delete
                                    </button>
                                </form>
                                <a class="btn btn-primary btn-sm" href="{{ route('seller.logs.index', [ 'product_id' => $data->id ]) }}">Price Logs</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($result->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $result->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

    <script>
        var btnProductDelete  = $('.btn-product-delete');
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 4000 );

        $(function() {
            btnProductDelete.click(function() {
                var productId         = $(this).data('product-id');
                var productDeleteForm = $(`#product-delete-form-${productId}`);
                sweetAlert(productDeleteForm);
            });
        });

        // Sweet alert notification
        function sweetAlert(productDeleteForm) {
            Swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, deleted it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    productDeleteForm.submit();
                }
            });
        }
    </script>
@endpush

