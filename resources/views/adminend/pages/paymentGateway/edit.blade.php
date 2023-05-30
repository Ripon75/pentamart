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

                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                @endif

                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.payments.update', $pg->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ $pg->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full" name="status">
                                    <option value="">Select Status</option>
                                    <option value="active" {{ $pg->status == 'active' ? "selected" : '' }}>Active</option>
                                    <option value="inactive" {{ $pg->status == 'inactive' ? "selected" : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Upload File</label>
                                <input type="file" name="img_src" class="w-full">
                                @if ($pg->img_src)
                                    <img src="{{ $pg->img_src }}" alt="PG" class="w-16 h-16 mt-1">
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
