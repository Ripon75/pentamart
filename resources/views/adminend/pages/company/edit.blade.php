@extends('adminend.layouts.default')
@section('title', 'Companies')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Company</h6>
        <div class="actions">
            <a href="{{ route('admin.companies.index') }}" class="action btn btn-primary">companies</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.companies.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-item ">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ $data->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Parent</label>
                                <select class="form-select w-full" name="parent_id">
                                    <option value="">Select parent</option>
                                    @foreach ($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ $data->parent_id == $parent->id ? "selected" : '' }}>{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Logo Path</label>
                                <input type="file" value="{{ $data->logo_path }}" name="logo_path" class="w-full">
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
