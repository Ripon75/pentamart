@extends('adminend.layouts.default')
@section('title', 'Banners')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Create Banner</h6>
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
                            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-item">
                                    <label for="" class="form-label">Pre title</label>
                                    <input type="text" value="{{ old('pre_title') }}" name="pre_title" class="w-full">
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Pre title link</label>
                                    <input type="text" value="{{ old('pre_title_link') }}" name="pre_title_link" class="w-full">
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Title</label>
                                    <input type="text" value="{{ old('title') }}" name="title" class="w-full">
                                    @error('title')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Title link</label>
                                    <input type="text" value="{{ old('title_link') }}" name="title_link" class="w-full">
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Post title</label>
                                    <input type="text" value="{{ old('post_title') }}" name="post_title" class="w-full">
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Post title link</label>
                                    <input type="text" value="{{ old('post_title_link') }}" name="post_title_link" class="w-full">
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Box link</label>
                                    <textarea rows="2" cols="50" name="box_link">{{ old('box_link') }}</textarea>
                                    <span class="text-xs">/brands/beurer?percent=10</span>
                                    <span class="text-xs">/offers/categories/medical-devices/?percent=20&sub_category=meter-system</span>
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Position</label>
                                    <select class="form-select w-full" name="position">
                                        <option value="">Select position</option>
                                        @foreach ($positions as $position)
                                        <option value="{{ $position['value'] }}" {{ old('position') == $position['value'] ? 'selected' : '' }}>
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
                                    <input type="text" value="{{ old('serial') }}" name="serial" class="w-full">
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Caption</label>
                                    <input type="text" value="{{ old('caption') }}" name="caption" class="w-full">
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">BG color</label>
                                    <input type="text" value="{{ old('caption') }}" name="bg_color" class="w-full">
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-select w-full" name="status">
                                        <option value="activated">Select Status</option>
                                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="activated" {{ old('status') === 'activated' ? 'selected' : '' }}>Activated</option>
                                        <option value="inactivated" {{ old('status') === 'inactivated' ? 'selected' : '' }}>Inactivated</option>
                                    </select>
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Upload File for Web</label>
                                    <input type="file" name="web_file" class="w-full">
                                    @error('web_file')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Upload File for Mobile</label>
                                    <input type="file" name="mobile_file" class="w-full">
                                    @error('mobile_file')
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
    </div>
</div>
@endsection
