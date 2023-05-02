@extends('adminend.layouts.default')
@section('title', 'Brands')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Brand</h6>
        <div class="actions">
            <a href="{{ route('admin.brands.index') }}" class="action btn btn-primary">Brand</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ $brand->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full" name="status">
                                    <option value="active">Select</option>
                                    <option value="active" {{ $brand->status == 'active' ? "selected" : '' }}>Active</option>
                                    <option value="inactive" {{ $brand->status == 'inactive' ? "selected" : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Top Brand</label>
                                <select class="form-select w-full" name="is_top">
                                    <option value="0">Select</option>
                                    <option value="1" {{ $brand->is_top == '1' ? "selected" : '' }}>YES</option>
                                    <option value="0" {{ $brand->is_top == '0' ? "selected" : '' }}>NO</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Image</label>
                                <input type="file" name="img_src" class="w-full">
                                @if ($brand->img_src)
                                    <img class="w-28 h-28 mt-2" src="{{ $brand->img_src }}" alt="{{ $brand->name }}">
                                @endif
                                @error('img_src')
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
