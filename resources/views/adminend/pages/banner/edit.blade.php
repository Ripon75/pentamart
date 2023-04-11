@extends('adminend.layouts.default')
@section('title', 'Banners')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Banners</h6>
        <div class="actions">
            <a href="{{ route('admin.banners') }}" class="action btn btn-primary">Banners</a>
        </div>
    </div>
    <div class="page-content">
        <section class="">
            <div class="container">
                <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                    <div class="card shadow">
                        <div class="body p-4">
                            <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-item">
                                    <label for="" class="form-label">Title</label>
                                    <input type="text" value="{{ $banner->title }}" name="title" class="w-full">
                                    @error('title')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Box link</label>
                                    <textarea rows="2" cols="50" name="box_link">{{ $banner->box_link }}</textarea>
                                    <span class="text-xs">/brands/beurer?percent=10</span>
                                    <span class="text-xs">/offers/categories/medical-devices/?percent=20&sub_category=meter-system</span>
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Position</label>
                                    <select class="form-select w-full" name="position">
                                        <option value="">Select position</option>
                                        @foreach ($positions as $position)
                                        <option value="{{ $position['value'] }}" {{ $position['value'] == $banner->position ? "selected" : ''}}>
                                            {{ $position['label'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('position')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Serial</label>
                                    <input type="text" value="{{ $banner->serial }}" name="serial" class="w-full">
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">BG color</label>
                                    <input type="text" value="{{ $banner->bg_color }}" name="bg_color" class="w-full">
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-select w-full" name="status">
                                        <option value="active">Select Status</option>
                                        <option value="active" {{ $banner->status === 'active' ? "selected" : '' }}>Active</option>
                                        <option value="inactive" {{ $banner->status === 'inactive' ? "selected" : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Upload File for Web</label>
                                    <input type="file" name="web_file" class="w-full">
                                    <img src="{{ $banner->img_src }}" alt="Bannaer" class="h-24 w-28 mt-1">
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Upload File for Mobile</label>
                                    <input type="file" name="mobile_file" class="w-full">
                                    <img src="{{ $banner->mobile_img_src }}" alt="Bannaer" class="h-20 w-24 mt-1">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
