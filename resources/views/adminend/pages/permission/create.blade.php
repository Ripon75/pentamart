@extends('adminend.layouts.default')
@section('title', 'Permissions')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Create Permission</h6>
        <div class="actions">
            <a href="{{ route('admin.permissions') }}" class="action btn btn-primary">Permissions</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.permissions.store') }}" method="POST">
                            @csrf

                            <div class="">
                                {{-- role --}}
                                <div class="">
                                    <div class="form-item ">
                                        <label class="form-label">Name</label>
                                        <input type="text" value="{{ old('display_name') }}" name="display_name" class="form-input" />
                                        @error('display_name')
                                            <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-item">
                                        <label for="" class="form-label">Description</label>
                                        <input type="text" name="description" value="{{ old('description') }}" class="w-full">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
