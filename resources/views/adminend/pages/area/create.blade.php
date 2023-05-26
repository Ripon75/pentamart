@extends('adminend.layouts.default')
@section('title', 'Area')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Create Area</h6>
        <div class="actions">
            <a href="{{ route('admin.areas.index') }}" class="action btn btn-primary">Areas</a>
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
                        <form action="{{ route('admin.areas.store') }}" method="POST">
                            @csrf

                            <div class="form-item ">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                                @error('name')
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
