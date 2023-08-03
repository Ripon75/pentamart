@extends('adminend.layouts.default')
@section('title', 'Products')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Product</h6>
        <div class="actions">
            <a href="{{ route('admin.products.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">

        {{-- Show flash message --}}
        @if(Session::has('success'))
            <div class="alert mb-8 success">{{ Session::get('success') }}</div>
        @endif

        <form action="{{ route('admin.products.index') }}" method="GET">
            <div class="action-bar mb-4 flex flex-wrap items-end space-x-2 space-y-2 bg-white pb-2">
                <div class="flex flex-col ml-2">
                    <label for="">ID</label>
                    <input type="number" class="border border-gray-300 rounded w-36 h-10" name="id"
                        value="{{ request()->input('id') }}">
                </div>
                <div class="flex flex-col">
                    <label for="">Name</label>
                    <input type="text" class="border border-gray-300 rounded w-48 h-10" name="name"
                        value="{{ request()->input('name') }}">
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
                <a href="{{ route('admin.products.index') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
            </div>
        </form>
        <div>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Buy Price</th>
                        <th>MRP</th>
                        <th>Discount</th>
                        <th>Offer Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td class="text-center">{{ $product->id }}</td>
                        <td>
                            <img src="{{$product->img_src}}" style="width: 70px; height:40px" alt="Product Image">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td class="text-right">{{ $product->buy_price }}</td>
                        <td class="text-right">{{ $product->mrp }}</td>
                        <td class="text-right">{{ $product->discount }}</td>
                        <td class="text-right">{{ $product->offer_price }}</td>
                        <td class="text-right">{{ $product->current_stock }}</td>
                        <td class="text-center">
                            @if ($product->status === 'active')
                                <button class="border px-2 py-1 rounded text-white bg-green-400 text-sm">
                                    {{ $product->status }}
                                </button>
                            @else
                                <button class="border px-2 py-1 rounded text-white bg-red-400 text-sm">
                                    {{ $product->status }}
                                </button>
                            @endif
                        </td>
                        <td>
                            @if ($product->created_at)
                                {{ date('d-m-Y', strtotime($product->created_at)); }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="flex space-x-2 items-center justify-center">
                                <a class="btn btn-success btn-sm" href="{{ route('admin.products.edit', $product->id) }}">Edit</a>
                                <form id="product-delete-form-{{ $product->id }}" action="{{ route('admin.products.delete', $product->id) }}" method="Post">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="button"
                                        class="btn-product-delete btn hover:bg-red-700 bg-red-500 btn-sm text-white"
                                        data-product-id="{{ $product->id }}">
                                        <i class="trash-icon text-sm sm:text-sm md:text-base lg:text-base xl:text-base 2xl:text-base text-white fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($products->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $products->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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

