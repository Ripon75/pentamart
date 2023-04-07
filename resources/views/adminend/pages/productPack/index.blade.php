@extends('adminend.layouts.default')
@section('title', 'Pack Sizes')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Product Pack</h6>
        <div class="actions">
            <a href="{{ route('admin.product-packs.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('error'))
        <div class="alert mb-8 error">{{ Session::get('message') }}</div>
        @endif

        @if(Session::has('success'))
        <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th>ID</th>
                    <th>Product</th>
                    <th>UOM</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Piece</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($result as $data)
                    <tr>
                        <td class="text-center">{{ $data->id }}</td>
                        <td>{{ ($data->product->name) ?? null }}</td>
                        <td>{{ ($data->uom->name) ?? null }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ number_format((float)$data->price, 2, '.', ''); }}</td>
                        <td>{{ $data->piece }}</td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.product-packs.edit', $data->id) }}">Edit</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.product-packs.show', $data->id) }}">Show</a>
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

@push('scripts')
    <script>
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 4000 );
    </script>
@endpush
