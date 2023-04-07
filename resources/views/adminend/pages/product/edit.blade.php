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
                            @php
                                $selectedCategoryIDs = Arr::pluck($data->categories->toArray(), 'id');
                            @endphp

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
                                    <label for="" class="form-label">Generic <span class="text-red-500 font-medium">*</span></label>
                                    <select class="form-select w-full form-input select-2" name="generic_id">
                                        <option value="">Select generic</option>
                                        @foreach ($generics as $generic)
                                        <option value="{{ $generic->id }}" {{ $data->generic_id == $generic->id ? "selected" : '' }}>
                                            {{ $generic->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('generic_id')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Company <span class="text-red-500 font-medium">*</span></label>
                                    <select class="form-select w-full form-input select-2" name="company_id">
                                        <option value="">Select brand</option>
                                        @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" {{ $data->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Dosage Form <span class="text-red-500 font-medium">*</span></label>
                                    <select class="form-select w-full form-input select-2" name="dosage_form_id">
                                        <option value="">Select dosage form</option>
                                        @foreach ($dosageForms as $dosageForm)
                                        <option value="{{ $dosageForm->id }}" {{ $data->dosage_form_id == $dosageForm->id ? 'selected' : '' }}>
                                            {{ $dosageForm->name }}
                                        </option>
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
                                    <select class="form-select w-full select-2" name="category_ids[]" multiple>
                                        @foreach ($categories as $category)
                                            <option
                                                {{ in_array($category->id, $selectedCategoryIDs) ? "selected" : '' }}
                                                value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_ids')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">POS Product ID</label>
                                    <input type="number" value="{{ $data->pos_product_id }}" name="pos_product_id" class="form-input" />
                                    @error('pos_product_id')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-select w-full form-input" name="status">
                                        <option value="draft">Select Status</option>
                                        <option value="draft" {{ $data->status == 'draft' ? "selected" : '' }}>Draft</option>
                                        <option value="activated" {{ $data->status == 'activated' ? "selected" : '' }}>Activated</option>
                                        <option value="inactivated" {{ $data->status == 'inactivated' ? "selected" : '' }}>Inactivated</option>
                                    </select>
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Counter type</label>
                                    <select class="form-select w-full form-input" name="counter_type">
                                        <option value="none">Select</option>
                                        <option value="none" {{ $data->counter_type === 'none' ? "selected" : '' }}>None</option>
                                        <option value="otc" {{ $data->counter_type === 'otc' ? "selected" : '' }}>OTC</option>
                                        <option value="prescribed" {{ $data->counter_type === 'prescribed' ? "selected" : '' }}>Prescribed</option>
                                    </select>
                                </div>
                                <div class="form-item w-full">
                                    <label class="form-label">Single Sell Allow</label>
                                    <select class="form-select w-full form-input" name="is_single_sell_allow">
                                        <option value="0">Select</option>
                                        <option value="1" {{ $data->is_single_sell_allow == '1' ? "selected" : '' }}>YES</option>
                                        <option value="0" {{ $data->is_single_sell_allow == '0' ? "selected" : '' }}>NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                    <div class="form-item w-full">
                                        <label for="" class="form-label">MRP <span class="text-red-500 font-medium">*</span></label>
                                        <input id="mrp" type="number" step="any" value="{{ $data->mrp }}" name="mrp" class="w-full form-input">
                                        @error('mrp')
                                            <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-item w-full">
                                        <label for="" class="form-label">Selling price</label>
                                        <input id="selling-price" type="number" min="0" step="any" value="{{ $data->selling_price }}" name="selling_price" class="w-full form-input">
                                    </div>
                                    <div class="form-item w-full">
                                        <label for="" class="form-label">Selling percent</label>
                                        <input id="selling-percent" type="number" min="0" step="any" value="{{ $data->selling_percent }}" name="selling_percent" class="w-full form-input">
                                    </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label class="form-label">Pack size <span class="text-red-500 font-medium">*</span></label>
                                    <input type="number" value="{{ $data->pack_size }}" name="pack_size" class="form-input" />
                                    @error('pack_size')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label class="form-label">Max Number of Pack <span class="text-red-500 font-medium">*</span></label>
                                    <input type="number" value="{{ $data->num_of_pack }}" name="num_of_pack" class="form-input" />
                                    @error('num_of_pack')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label class="form-label">Pack Name <span class="text-red-500 font-medium">*</span></label>
                                    <input type="text" value="{{ $data->pack_name }}" name="pack_name" class="form-input" />
                                    @error('pack_name')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label class="form-label">UoM <span class="text-red-500 font-medium">*</span></label>
                                    <input type="text" value="{{ $data->uom }}" name="uom" class="form-input" />
                                    @error('uom')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label class="form-label">Refrigerated</label>
                                    <select class="form-select w-full form-input" name="is_refrigerated">
                                        <option value="0">Select</option>
                                        <option value="1" {{ $data->is_refrigerated == '1' ? "selected" : '' }}>YES</option>
                                        <option value="0" {{ $data->is_refrigerated == '0' ? "selected" : '' }}>NO</option>
                                    </select>
                                </div>
                                <div class="form-item w-full">
                                    <label class="form-label">Eexpress Delivery</label>
                                    <select class="form-select w-full form-input" name="is_express_delivery">
                                        <option value="0">Select</option>
                                        <option value="1" {{ $data->is_express_delivery == '1' ? "selected" : '' }}>YES</option>
                                        <option value="0" {{ $data->is_express_delivery == '0' ? "selected" : '' }}>NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Tags</label>
                                <input type="text" class="form-input" value="{{ $tagNames }}" name="tag_names" placeholder="Ex: tag name 1, tag name 2, ....">
                            </div>
                            @php
                                $selectedsymptomIDs = Arr::pluck($data->symptoms->toArray(), 'id');
                            @endphp
                            <div class="form-item">
                                <label for="" class="form-label">Symptoms</label>
                                <select class="form-select w-full select-2" name="symptom_ids[]" multiple>
                                    @foreach ($symptoms as $symptom)
                                        <option
                                            {{ in_array($symptom->id, $selectedsymptomIDs) ? "selected" : '' }}
                                            value="{{ $symptom->id }}">
                                            {{ $symptom->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Description</label>
                                <textarea class="w-full tinymce" name="description">{{ $data->description }}</textarea>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Meta Title</label>
                                <input type="text" value="{{ $data->meta_title }}" name="meta_title" class="w-full form-input">
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Meta Keyword</label>
                                <textarea class="w-full form-input" name="meta_keywords">{{ $data->meta_keywords }}</textarea>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Meta Description</label>
                                <textarea class="w-full tinymce" name="meta_description">{{ $data->meta_description }}</textarea>
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
