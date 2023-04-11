@extends('adminend.layouts.default')
@section('title', 'Porducts')
@section('content')
<section class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Create Product</h6>
        <div class="actions">
            <a href="{{ route('admin.products.index') }}" class="action btn btn-primary">Products</a>
        </div>
    </div>
    <div class="page-content">
        <div class="w-[800px] lg:w-[800px] xl:w-[800px] mx-auto">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card shadow">
                <div class="body p-4">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-item ">
                            <label class="form-label">Name <span class="text-red-500 font-medium">*</span> </label>
                            <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                            @error('name')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-item ">
                            <label class="form-label">Upload Image</label>
                            <input type="file" class="form-input" name="image">
                        </div>
                        <div class="flex space-x-2">
                            <div class="form-item w-full">
                                <label for="" class="form-label">Brand</label>
                                <select class="form-select w-full form-input select-2" name="brand_id">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item w-full">
                                <label for="" class="form-label">Category <span class="text-red-500 font-medium">*</span> </label>
                                <select class="form-select w-full form-input select-2" name="category_id">
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="form-item w-full">
                                <label for="" class="form-label">Company <span class="text-red-500 font-medium">*</span> </label>
                                <select class="form-select w-full form-input select-2" name="company_id">
                                    <option value="">Select brand</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item w-full">
                                <label for="" class="form-label">Dosage Form <span class="text-red-500 font-medium">*</span> </label>
                                <select class="form-select w-full form-input select-2" name="dosage_form_id">
                                    <option value="">Select dosage form</option>
                                    @foreach ($dosageForms as $dosageForm)
                                    <option value="{{ $dosageForm->id }}">{{ $dosageForm->name }}</option>
                                    @endforeach
                                </select>
                                @error('dosage_form_id')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex space-x-2">
                             <div class="form-item w-full">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full form-input" name="status">
                                    <option value="active">Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="form-item w-full">
                               <label for="" class="form-label">Price <span class="text-red-500 font-medium">*</span> </label>
                               <input type="number" step="any" name="price" value="{{ old('price') }}" id="price" class="w-full form-input">
                               @error('price')
                                   <span class="form-helper error">{{ $message }}</span>
                               @enderror
                           </div>
                           <div class="form-item w-full">
                               <label for="" class="form-label">Offer Price</label>
                               <input type="number" step="any" name="offer_price" value="{{ old('offer_price') }}" id="offer-price" class="w-full form-input">
                           </div>
                           <div class="form-item w-full">
                               <label for="" class="form-label">Offer Percent</label>
                               <input type="number" step="any" name="offer_percent" value="{{ old('offer_percent') }}" id="offer-percent" class="w-full form-input">
                           </div>
                        </div>
                        <div class="form-item w-full">
                            <label for="" class="form-label">Current Stock</label>
                            <input type="number" step="any" name="currnet_stock" value="{{ old('currnet_stock') }}" id="offer-percent" class="w-full form-input">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Description</label>
                            <textarea class="w-full tinymce" name="description">{{ old('description') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    {{-- Select 2 cnd link --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- ckt editor cdn link --}}
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.tinymce', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'powerpaste advcode table lists checklist',
            toolbar: 'undo redo | blocks| bold italic | bullist numlist checklist | code | table'
        });
    </script>
    <script>
        $(function() {
            $('.select-2').select2({
                placeholder: "Select",
            });

            $('#offer-price').keyup(function (e) {
                var price = $('#price').val();
                var offerPrice = $(this).val();
                if (offerPrice > 0 && price > 0) {
                    var discount = price - offerPrice;

                    // cal. percent
                    var offerPercent = (discount * 100) / price;
                    $('#offer-percent').val(offerPercent);
                } else {
                    $('#offer-percent').val(0);
                }
            });

            $('#offer-percent').keyup(function (e) {
                var price = $('#price').val();
                var percent = $('#offer-percent').val();
                if (percent > 0 && price > 0) {
                    var discount = (percent * price) / 100;
                    var offerPrice = price - discount;

                    // cal. percent
                    $('#offer-price').val(offerPrice);
                } else {
                    $('#offer-price').val(0);
                }
            });
        });
    </script>
@endpush
