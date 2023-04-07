@extends('adminend.layouts.default')
@section('title', 'Dosage Forms')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Dosage Form</h6>
        <div class="actions">
            <a href="{{ route('admin.dosage-forms.index') }}" class="action btn btn-primary">Dosage Forms</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.dosage-forms.update', $data->id) }}" method="POST">
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
                                    <option value="{{ ($parent->id) ?? 0 }}" {{ $data->parent_id == $parent->id ? "selected" : '' }}>{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full" name="status">
                                    <option value="draft">Select Status</option>
                                    <option value="draft" {{ $data->status == 'draft' ? "selected" : '' }}>Draft</option>
                                    <option value="activated" {{ $data->status == 'activated' ? "selected" : '' }}>Activated</option>
                                    <option value="inactivated" {{ $data->status == 'inactivated' ? "selected" : '' }}>Inactivated</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Description</label>
                                <textarea class="w-full" name="description">{{ $data->description }}</textarea>
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
