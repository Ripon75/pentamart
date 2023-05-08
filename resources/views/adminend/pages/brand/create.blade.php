@extends('adminend.layouts.default')
@section('title', 'Brands')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Create Brand</h6>
        <div class="actions">
            <a href="{{ route('admin.brands.index') }}" class="action btn btn-primary">Brands</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="my-16 lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full" name="status">
                                    <option value="active">Select</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Top</label>
                                <select class="form-select w-full" name="is_top">
                                    <option value="draft">Select</option>
                                    <option value="1" {{ old('is_top') == '1' ? 'selected' : '' }}>YES</option>
                                    <option value="0" {{ old('is_top') == '0' ? 'selected' : '' }}>NO</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Image</label>
                                <input type="file" name="img_src" class="w-full">
                                @error('img_src')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
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
