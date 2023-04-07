@extends('adminend.layouts.default')
@section('title', 'Categories')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Create Category</h6>
        <div class="actions">
            <a href="{{ route('admin.categories.index') }}" class="action btn btn-primary">Categories</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf

                            <div class="form-item ">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Parent</label>
                                <select class="form-select w-full" name="parent_id">
                                    <option value="">Select parent</option>
                                    @foreach ($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Attribute Family</label>
                                <select class="form-select w-full" name="family_id">
                                    <option value="">Select</option>
                                    @foreach ($families as $family)
                                    <option value="{{ $family->id }}" {{ old('family_id') == $family->id ? 'selected' : '' }}>
                                        {{ $family->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Attribute</label>
                                <select class="form-select w-full attribute select-2" name="attribute_ids[]" multiple>
                                    <option value="">Select</option>
                                    @foreach ($attributes as $attribute)
                                    <option value="{{ $attribute->id }}">
                                        {{ $attribute->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Menufacturer</label>
                                <select class="form-select w-full company select-2" name="company_ids[]" multiple>
                                    <option value="">Select</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">
                                        {{ $company->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full" name="status">
                                    <option value="draft">Select Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="activated">Activated</option>
                                    <option value="inactivated">Inactivated</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Color</label>
                                <input type="text" name="color" class="w-full">
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
    </div>
</div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function() {
            $('.attribute').select2({
                placeholder: "Select some attribute",
            });
            $('.company').select2({
                placeholder: "Select some menufacturer",
            });
        })
    </script>
@endpush

