@extends('adminend.layouts.default')
@section('title', 'Products')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Edit Product</h6>
        <div class="actions">
            <a href="{{ route('admin.products.index') }}" class="action btn btn-primary">Products</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="w-[800px] mx-auto">

                {{-- Show flash message --}}
                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                @endif

                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label class="form-label">Name <span class="text-red-500 font-medium">*</span></label>
                                    <input type="text" value="{{ $product->name }}" name="name" class="form-input" />
                                    @error('name')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="">Upload Image</label>
                                    <input type="file" class="form-input" name="image_src">
                                     @if ($product->image_src)
                                        <img src="{{$product->image_src}}" class="w-16 h-14" alt="{{ $product->name }}">
                                    @endif
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Brand</label>
                                    <select class="form-select w-full form-input select-2" name="brand_id">
                                        <option value="">Select brand</option>
                                        @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? "selected" : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Category <span class="text-red-500 font-medium">*</span></label>
                                    <select class="form-select w-full form-input select-2" name="category_id">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? "selected" : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-select w-full form-input" name="status">
                                        <option value="active">Select Status</option>
                                        <option value="active" {{ $product->status == 'active' ? "selected" : '' }}>Active</option>
                                        <option value="inactive" {{ $product->status == 'inactive' ? "selected" : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Current stock</label>
                                    <input type="number" value="{{ $product->current_stock }}" name="current_stock" class="w-full form-input">
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Price <span class="text-red-500 font-medium">*</span></label>
                                    <input id="input-price" type="number" step="any" value="{{ $product->price }}" name="price" class="w-full form-input">
                                    @error('price')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Offer price</label>
                                    <input id="input-offer-price" type="number" min="0" step="any" value="{{ $product->offer_price }}" name="offer_price" class="w-full form-input">
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Offer percent</label>
                                    <input id="input-offer-percent" type="number" min="0" step="any" value="{{ $product->offer_percent }}" name="offer_percent" class="w-full form-input">
                                </div>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Description</label>
                                <textarea class="w-full tinymce" name="description">{{ $product->description }}</textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Select 2 cdn link --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- CKT editor cdn link --}}
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.tinymce', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'powerpaste advcode table lists checklist',
            toolbar: 'undo redo | blocks| bold italic | bullist numlist checklist | code | table'
        });
    </script>
    <script>
        var inputPrice        = $('#input-price');
        var inputOfferPrice   = $('#input-offer-price');
        var inputOfferPercent = $('#input-offer-percent');

        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 4000 );

        $(function() {
            $('.select-2').select2({
                placeholder: "Select",
            });

            inputOfferPrice.keyup(function (e) {
                var price = inputPrice.val();
                var offerPrice = $(this).val();
                if (offerPrice > 0 && price > 0) {
                    var discount = price - offerPrice;

                    // cal. percent
                    var offerPercent = ((discount * 100) / price).toFixed(2);
                    inputOfferPercent.val(offerPercent);
                } else {
                    inputOfferPercent.val(0);
                }
            });

            inputOfferPercent.keyup(function (e) {
                var price = inputPrice.val();
                var percent = inputOfferPercent.val();
                if (percent > 0 && price > 0) {
                    var discount   = (percent * price) / 100;
                    var offerPrice = price - discount;

                    // cal. percent
                    inputOfferPrice.val(offerPrice);
                } else {
                    inputOfferPrice.val(0);
                }
            });
        });
    </script>
@endpush
