@extends('adminend.layouts.default')
@section('title', 'Brands')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Create Brand</h6>
        <div class="actions">
            <a href="{{ route('admin.brands.index') }}" class="action btn btn-primary">Brands</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="my-16 lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.brands.store') }}" method="POST">
                            @csrf

                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Company</label>
                                <select class="form-select w-full" name="company_id">
                                    <option value="">Select company</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : ''}}>
                                        {{ $company->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full" name="status">
                                    <option value="draft">Select Status</option>
                                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="activated" {{ old('status') === 'activated' ? 'selected' : '' }}>Activated</option>
                                    <option value="inactivated" {{ old('status') === 'inactivated' ? 'selected' : '' }}>Inactivated</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Logo Path</label>
                                <input type="file" name="logo_path" class="w-full">
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Description</label>
                                <textarea class="w-full" name="description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
