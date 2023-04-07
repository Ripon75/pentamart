@extends('adminend.layouts.default')
@section('title', 'Dashboard')
@section('content')
<section class="">
    <div class="container">
        <div class="my-16 lg:w-[500px] xl:w-[500px] mx-auto">
            <div class="card shadow">
                <div class="body p-4">
                    <form action="{{ route('admin.brand.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-item">
                            <label for="" class="form-label">Brand name</label>
                            <input type="text" name="name" value="{{ $banner->name }}" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Title</label>
                            <input type="text" name="title" value="{{ $banner->title }}" class="w-full">
                            @error('title')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Status</label>
                            <select class="form-select w-full" name="status">
                                <option value="draft">Select Status</option>
                                <option value="draft" {{ $banner->status == 'draft' ? "selected" : '' }}>Draft</option>
                                <option value="activated" {{ $banner->status == 'activated' ? "selected" : '' }}>Activated</option>
                                <option value="inactivated" {{ $banner->status == 'inactivated' ? "selected" : '' }}>Inactivated</option>
                            </select>
                        </div>
                        <div class="form-item mr-1">
                            <label class="form-label">Link</label>
                            <textarea rows="2" cols="50" name="link">{{ $banner->link }}</textarea>
                            @error('link')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Upload File</label>
                            <input type="file" name="file" class="w-full">
                            <img src="{{ $banner->img_src }}" alt="Banner" class="w-36 h-36 mt-2">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
