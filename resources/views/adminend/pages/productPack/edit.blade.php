@extends('adminend.layouts.default')
@section('title', 'Dashboard')
@section('content')
<section class="">
    <div class="container">
        <div class="my-16 lg:w-[500px] xl:w-[500px] mx-auto">
            <div class="card shadow">
                <div class="body p-4">
                    <form action="{{ route('admin.product-packs.update',$data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-item">
                            <label for="" class="form-label">Product</label>
                            <select class="form-select w-full" name="product_id">
                                <option value="">Select product</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ $data->product_id == $product->id ? "selected" : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">UOM</label>
                            <select class="form-select w-full" name="uom_id">
                                <option value="">Select UOM</option>
                                @foreach ($uoms as $uom)
                                <option value="{{ $uom->id }}" {{ $data->uom_id == $uom->id ? "selected" : '' }}>{{ $uom->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Name</label>
                            <input type="text" value="{{ $data->name }}" name="name" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Piece</label>
                            <input type="text" value="{{ $data->piece }}" name="piece" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Price</label>
                            <input type="text" value="{{ $data->price }}" name="price" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Minimum Order Qty</label>
                            <input type="text" value="{{ $data->min_order_qty }}" name="min_order_qty" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Maximum Order Qty</label>
                            <input type="text" value="{{ $data->max_order_qty }}" name="max_order_qty" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Description</label>
                            <textarea class="w-full" name="description">{{ $data->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
