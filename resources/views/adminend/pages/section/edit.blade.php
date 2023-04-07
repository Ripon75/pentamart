@extends('adminend.layouts.default')
@section('title', 'Sections')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Edit Section</h6>
        <div class="actions">
            <a href="{{ route('admin.sections.index') }}" class="action btn btn-primary">Sections</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.sections.update', $section->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-item">
                                <label for="" class="form-label">Name</label>
                                <input type="text" value="{{ $section->name }}" name="name" class="w-full">
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Title</label>
                                <input type="text" value="{{ $section->title }}" name="title" class="w-full">
                                @error('title')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Link</label>
                                <textarea name="link">{{ $section->link }}</textarea>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full" name="status">
                                    <option value="activated">Select Status</option>
                                    <option value="draft" {{ $section->status === 'draft' ? "selected" : '' }}>Draft</option>
                                    <option value="activated" {{ $section->status === 'activated' ? "selected" : '' }}>Activated</option>
                                    <option value="inactivated" {{ $section->status === 'inactivated' ? "selected" : '' }}>Inactivated</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Products</label>
                                <select class="form-select w-full select-2" name="productIDs[]" multiple>
                                    <option value="">Select Products</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ in_array($product->id, $selectedProductIDs) ? "selected" : '' }}>
                                        {{ $product->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('productIDs')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $('.select-2').select2({
                placeholder: "Select some products",
            });
        });
    </script>
@endpush
