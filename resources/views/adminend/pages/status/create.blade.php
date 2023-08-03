@extends('adminend.layouts.default')
@section('title', 'Status')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Create Status</h6>
        <div class="actions">
            <a href="{{ route('admin.statuses.index') }}" class="action btn btn-primary">Order Status</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">

                {{-- Show flash success or error message --}}
                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                @endif

                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.statuses.store') }}" method="POST">
                            @csrf

                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-input"/>
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">BG Color</label>
                                <input type="text" value="{{ old('bg_color') }}" name="bg_color" class="form-input" placeholder="#ffffff"/>
                            </div>
                            <div class="form-item">
                                <label class="form-label">Text Color</label>
                                <input type="text" value="{{ old('text_color') }}" name="text_color" class="form-input" placeholder="#000000"/>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full rounded-md border-gray-300" name="status">
                                    <option value="active">Select</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
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
