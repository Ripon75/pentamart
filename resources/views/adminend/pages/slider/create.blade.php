@extends('adminend.layouts.default')
@section('title', 'Sliders')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Create Slider</h6>
        <div class="actions">
            <a href="{{ route('admin.sliders.index') }}" class="action btn btn-primary">Sliders</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="my-16 lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
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
                                <select class="form-select w-full form-input" name="status">
                                    <option value="active">Select</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Large Image</label>
                                <input type="file" name="large_src" class="w-full">
                                @error('large_src')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Small Image</label>
                                <input type="file" name="small_src" class="w-full">
                                @error('small_src')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
