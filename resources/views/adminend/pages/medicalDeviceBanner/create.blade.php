@extends('adminend.layouts.default')
@section('title', 'Dashboard')
@section('content')
<section class="">
    <div class="container">
        <div class="my-16 lg:w-[500px] xl:w-[500px] mx-auto">
            <div class="card shadow">
                <div class="body p-4">
                    <form action="{{ route('admin.medical.device.banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-item">
                            <label for="" class="form-label">Pre Title</label>
                            <input type="text" value="{{ old('pre_title') }}" name="pre_title" class="w-full">
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Title</label>
                            <input type="text" value="{{ old('title') }}" name="title" class="w-full">
                            @error('title')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Post Title</label>
                            <input type="text" value="{{ old('post_title') }}" name="post_title" class="w-full">
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
                            <label for="" class="form-label">BG Color</label>
                            <input type="text" value="{{ old('bg_color') }}" name="bg_color" class="w-full">
                        </div>
                        <div class="form-item mr-1">
                            <label class="form-label">Link</label>
                            <textarea rows="2" cols="50" name="link">{{ old('link') }}</textarea>
                            @error('link')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label for="" class="form-label">Upload File</label>
                            <input type="file" name="file" class="w-full">
                            @error('file')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
