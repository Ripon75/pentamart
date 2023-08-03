@extends('adminend.layouts.default')
@section('title', 'Sliders')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Slider</h6>
        <div class="actions">
            <a href="{{ route('admin.sliders.index') }}" class="action btn btn-primary">Sliders</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ $slider->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full form-input" name="status">
                                    <option value="active">Select</option>
                                    <option value="active" {{ $slider->status == 'active' ? "selected" : '' }}>Active</option>
                                    <option value="inactive" {{ $slider->status == 'inactive' ? "selected" : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Web Image</label>
                                <input type="file" name="web_img_src" class="w-full">
                                @if ($slider->web_img_src)
                                    <img class="w-56 h-16 mt-2" src="{{ $slider->web_img_src }}" alt="{{ $slider->name }}">
                                @endif
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Mobile Image</label>
                                <input type="file" name="mobile_img_src" class="w-full">
                                @if ($slider->mobile_img_src)
                                    <img class="w-44 h-16 mt-2" src="{{ $slider->mobile_img_src }}" alt="{{ $slider->name }}">
                                @endif
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
