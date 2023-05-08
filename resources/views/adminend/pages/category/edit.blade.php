@extends('adminend.layouts.default')
@section('title', 'Categories')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Category</h6>
        <div class="actions">
            <a href="{{ route('admin.categories.index') }}" class="action btn btn-primary">Categories</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-item ">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ $category->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full" name="status">
                                    <option value="active">Select</option>
                                    <option value="active" {{ $category->status == 'active' ? "selected" : '' }}>Active</option>
                                    <option value="inactive" {{ $category->status == 'inactive' ? "selected" : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Top</label>
                                <select class="form-select w-full" name="is_top">
                                    <option value="0">Select</option>
                                    <option value="1" {{ $category->is_top == '1' ? "selected" : '' }}>YES</option>
                                    <option value="0" {{ $category->is_top == '0' ? "selected" : '' }}>NO</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Image</label>
                                <input type="file" name="img_src" class="w-full">
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
            $('.attribute').select2({
                placeholder: "Select some attribute",
            });
            $('.company').select2({
                placeholder: "Select some menufacturer",
            });
        })
    </script>
@endpush
