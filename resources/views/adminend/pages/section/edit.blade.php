@extends('adminend.layouts.default')
@section('title', 'Sections')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Section</h6>
        <div class="actions">
            <a href="{{ route('admin.sections.index') }}" class="action btn btn-primary">Sections</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">

                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                @endif

                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.sections.update', $section->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-item">
                                <label for="" class="form-label">Name</label>
                                <input type="text" value="{{ $section->name }}" name="name" class="w-full rounded-md">
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full rounded-md" name="status">
                                    <option value="active">Select Status</option>
                                    <option value="active" {{ $section->status === 'active' ? "selected" : '' }}>Active</option>
                                    <option value="inactive" {{ $section->status === 'inactive' ? "selected" : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Products</label>
                                <select class="form-select w-full select-2" name="productIds[]" multiple>
                                    <option value="">Select Products</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ in_array($product->id, $selectedProductIds) ? "selected" : '' }}>
                                        {{ $product->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('productIds')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
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
