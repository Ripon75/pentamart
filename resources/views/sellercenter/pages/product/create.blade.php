@extends('sellercenter.layouts.default')
@section('title', 'Porducts')
@section('content')
<section class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Create Product</h6>
        <div class="actions">
            <a href="{{ route('seller.products.index') }}" class="action btn btn-primary">Products</a>
        </div>
    </div>
    <div class="page-content">
        <div class="w-[800px] lg:w-[800px] xl:w-[800px] mx-auto">

            @if(Session::has('error'))
                <div class="alert mb-8 error">{{ Session::get('message') }}</div>
            @endif
            @if(Session::has('message'))
                <div class="alert mb-8 success">{{ Session::get('message') }}</div>
            @endif

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
                    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
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
                                <label for="" class="form-label">Generic <span class="text-red-500 font-medium">*</span> </label>
                                <select class="form-select w-full form-input select-2" name="generic_id">
                                    <option value="">Select generic</option>
                                    @foreach ($generics as $generic)
                                    <option value="{{ $generic->id }}">{{ $generic->name }}</option>
                                    @endforeach
                                </select>
                                @error('generic_id')
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
                                <label for="" class="form-label">Category</label>
                                <select class="form-select w-full select-2 form-input" name="category_ids[]" multiple>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-item w-full">
                                <label for="" class="form-label">POS Product ID</label>
                                <input type="number" value="{{ old('pos_product_id') }}" name="pos_product_id" class="form-input" />
                            </div>
                        </div>
                        <div class="flex space-x-2">
                             <div class="form-item w-full">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full form-input" name="status">
                                    <option value="activated">Select Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="activated">Activated</option>
                                    <option value="inactivated">Inactivated</option>
                                </select>
                            </div>
                            <div class="form-item w-full">
                                <label for="" class="form-label">Counter Type</label>
                                <select class="form-select form-input w-full" name="counter_type">
                                    <option value="none">Select</option>
                                    <option value="none">None</option>
                                    <option value="otc">OTC</option>
                                    <option value="prescribe">Prescribe</option>
                                </select>
                            </div>
                            <div class="form-item w-full">
                                <label for="" class="form-label">Single Sell Allow</label>
                                <select class="form-select form-input w-full" name="is_single_sell_allow">
                                    <option value="0">Select</option>
                                    <option value="1">YES</option>
                                    <option value="0">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="form-item w-full">
                               <label for="" class="form-label">MRP <span class="text-red-500 font-medium">*</span> </label>
                               <input type="number" step="any" name="mrp" value="{{ old('mrp') }}" id="mrp" class="w-full form-input">
                               @error('mrp')
                                   <span class="form-helper error">{{ $message }}</span>
                               @enderror
                           </div>
                           <div class="form-item w-full">
                               <label for="" class="form-label">Offer Price</label>
                               <input type="number" step="any" name="selling_price" value="{{ old('selling_price') }}" id="selling-price" class="w-full form-input">
                           </div>
                           <div class="form-item w-full">
                               <label for="" class="form-label">Offer Percent</label>
                               <input type="number" step="any" name="selling_percent" value="{{ old('selling_percent') }}" id="selling-percent" class="w-full form-input">
                           </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="form-item w-full">
                                <label class="form-label">Pack Size <span class="text-red-500 font-medium">*</span> </label>
                                <input type="number" name="pack_size" value="{{ old('pack_size') }}" class="form-input" />
                                @error('pack_size')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item w-full">
                                <label class="form-label">Max Number of Pack <span class="text-red-500 font-medium">*</span> </label>
                                <input type="number" name="num_of_pack" value="{{ old('num_of_pack') }}" class="form-input" />
                                @error('num_of_pack')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item w-full">
                                <label class="form-label">Pack Name <span class="text-red-500 font-medium">*</span> </label>
                                <input type="text" name="pack_name" value="{{ old('pack_name') }}" class="form-input" />
                                @error('pack_name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="form-item w-full">
                                <label class="form-label">UoM <span class="text-red-500 font-medium">*</span> </label>
                                <input type="text" name="uom" value="{{ old('uom') }}" class="form-input" />
                                @error('uom')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item w-full">
                                    <label class="form-label">Refrigerated</label>
                                    <select class="form-select w-full form-input" name="is_refrigerated">
                                        <option value="0">Select</option>
                                        <option value="1">YES</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                                <div class="form-item w-full">
                                    <label class="form-label">Eexpress Delivery</label>
                                    <select class="form-select w-full form-input" name="is_express_delivery">
                                        <option value="0">Select</option>
                                        <option value="1">YES</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-item w-full">
                            <label for="" class="form-label">Tags</label>
                            <input class="form-input" type="text" name="tag_names" placeholder="Ex: tag name 1, tag name 2, ....">
                        </div>
                        <div class="form-item w-full">
                            <label for="" class="form-label">Symptoms</label>
                            <select class="form-select w-full select-2 form-input" name="symptom_ids[]" multiple>
                                @foreach ($symptoms as $symptom)
                                    <option
                                        value="{{ $symptom->id }}">
                                        {{ $symptom->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('symptom_ids')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Description</label>
                            <textarea class="w-full tinymce" name="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="w-full form-input">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Meta Keyword</label>
                            <textarea class="w-full form-input" name="meta_keywords">{{ old('meta_keywords') }}</textarea>
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Meta Description</label>
                            <textarea class="w-full tinymce" name="meta_description">{{ old('meta_description') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
