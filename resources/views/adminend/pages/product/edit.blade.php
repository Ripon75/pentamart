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
                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('message') }}</div>
                @endif
                @if(Session::has('message'))
                    <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                @endif
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.products.update',$data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-item ">
                                <label class="form-label">Name <span class="text-red-500 font-medium">*</span></label>
                                <input type="text" value="{{ $data->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="">Upload Image</label>
                                <input type="file" class="form-input" name="image">
                                 @if ($data->image_src)
                                    <img src="{{$data->image_src}}" style="width: 70px; height:40px" alt="Product Image">
                                @endif
                            </div>

                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Brand</label>
                                    <select class="form-select w-full form-input select-2" name="brand_id">
                                        <option value="">Select brand</option>
                                        @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $data->brand_id == $brand->id ? "selected" : '' }}>{{ $brand->name }}</option>
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
                                        <option value="{{ $category->id }}" {{ $data->category_id == $category->id ? "selected" : '' }}>
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
                                        <option value="active" {{ $data->status == 'active' ? "selected" : '' }}>Activated</option>
                                        <option value="inactive" {{ $data->status == 'inactive' ? "selected" : '' }}>Inactivated</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Price <span class="text-red-500 font-medium">*</span></label>
                                    <input id="price" type="number" step="any" value="{{ $data->price }}" name="price" class="w-full form-input">
                                    @error('price')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Offer price</label>
                                    <input id="offer-price" type="number" min="0" step="any" value="{{ $data->offer_price }}" name="offer_price" class="w-full form-input">
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Offer percent</label>
                                    <input id="offer-percent" type="number" min="0" step="any" value="{{ $data->offer_percent }}" name="offer_percent" class="w-full form-input">
                                </div>
                            </div>
                            <div class="form-item w-full">
                                <label for="" class="form-label">Current stock</label>
                                <input type="number" value="{{ $data->current_stock }}" name="current_stock" class="w-full form-input">
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Description</label>
                                <textarea class="w-full tinymce" name="description">{{ $data->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
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
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 4000 );

        $(function() {
            $('.select-2').select2({
                placeholder: "Select",
            });

            $('#selling-price').keyup(function (e) {
                var mrp = $('#mrp').val();
                var sellingPrice = $(this).val();
                if (sellingPrice > 0 && mrp > 0) {
                    var discount = mrp - sellingPrice;

                    // cal. percent
                    var sellingPercent = (discount * 100) / mrp;
                    $('#selling-percent').val(sellingPercent);
                } else {
                    $('#selling-percent').val(0);
                }
            });

            $('#selling-percent').keyup(function (e) {
                var mrp = $('#mrp').val();
                var percent = $('#selling-percent').val();
                if (percent > 0 && mrp > 0) {
                    var discount = (percent * mrp) / 100;
                    var sellingPrice = mrp - discount;

                    // cal. percent
                    $('#selling-price').val(sellingPrice);
                } else {
                    $('#selling-price').val(0);
                }
            });
        });
    </script>
@endpush
