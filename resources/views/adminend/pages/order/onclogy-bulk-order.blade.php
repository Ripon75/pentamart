@extends('adminend.layouts.default')
@section('title', 'Order Bulk Create')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title"> Onclogy Bulk Order</h6>
        <div class="actions">
            <a href="{{ route('admin.products.index') }}" class="action btn btn-primary">Products</a>
        </div>
    </div>
    <div class="page-content">
        <div class="px-8 py-4">
            <div class="py-4 flex items-center justify-between">
                <h3 class="font-bold text-lg">Onclogy Bulk Order</h3>
            </div>
            @if(Session::has('error'))
                <div class="alert mb-8 error">{{ Session::get('message') }}</div>
            @endif

            @if(Session::has('message'))
                <div class="alert mb-8 success">{{ Session::get('message') }}</div>
            @endif
            <div>
                <div class="flex justify-center items-center border-2 border-gray-300 border-dashed rounded-lg h-20">
                    <div class="w-1/3">
                        <form action="{{ route('admin.orders.bulk.onclogy.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex justify-between items-center">
                                <input type="file" name="uploaded_file" id="file" accept=".csv">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                @error('uploaded_file')
                    <span class="form-helper error text-red-400">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>
@endsection
