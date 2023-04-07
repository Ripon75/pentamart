@extends('adminend.layouts.default')
@section('title', 'Generics')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Generic</h6>
        <div class="actions">
            <a href="{{ route('admin.generics.index') }}" class="action btn btn-primary">Generics</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.generics.update', $data->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-item ">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ $data->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item ">
                                <label class="form-label">Strengh</label>
                                <input type="text" value="{{ $data->strength }}" name="strength" class="form-input" />
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
