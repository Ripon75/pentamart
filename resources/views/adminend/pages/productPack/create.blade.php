@extends('adminend.layouts.default')
@section('title', 'Dashboard')
@section('content')
<section class="">
    <div class="container">
        <div class="my-16 lg:w-[500px] xl:w-[500px] mx-auto">
            <div class="card shadow">
                <div class="body p-4">
                    <form action="{{ route('admin.product-packs.store') }}" method="POST">
                        @csrf

                        <div class="form-item">
                            <label for="" class="form-label">Product</label>
                            <select class="form-select w-full" name="product_id">
                                <option value="">Select product</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">UOM</label>
                            <select class="form-select w-full" name="uom_id">
                                <option value="">Select UOM</option>
                                @foreach ($uoms as $uom)
                                <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Piece</label>
                            <input type="text" name="piece" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Price</label>
                            <input type="text" name="price" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Minimum Order Qty</label>
                            <input type="text" name="min_order_qty" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Maximum Order Qty</label>
                            <input type="text" name="max_order_qty" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Description</label>
                            <textarea class="w-full" name="description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
