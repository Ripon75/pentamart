@extends('adminend.layouts.default')
@section('title', 'Payment Gateways')
@section('content')
<div class="page">
     {{-- Page header --}}
     <div class="page-toolbar">
        <h6 class="title">Edit Payment Gateway</h6>
        <div class="actions">
            <a href="{{ route('admin.payments.index') }}" class="action btn btn-primary">Payment Gateways</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.payments.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ $data->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Code</label>
                                <input type="text" value="{{ $data->code }}" name="code" class="w-full">
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Icon Name</label>
                                <input type="text" name="icon" class="w-full" value="{{ $data->icon }}">
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full" name="status">
                                    <option value="">Select Status</option>
                                    <option value="draft" {{ $data->status == 'draft' ? "selected" : '' }}>Draft</option>
                                    <option value="activated" {{ $data->status == 'activated' ? "selected" : '' }}>Activated</option>
                                    <option value="inactivated" {{ $data->status == 'inactivated' ? "selected" : '' }}>Inactivated</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Description</label>
                                <textarea class="w-full" name="description">{{ $data->description }}</textarea>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Upload File</label>
                                <input type="file" name="file" class="w-full">
                                <img src="{{ $data->img_src }}" alt="PG" class="w-16 h-16 mt-1">
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
