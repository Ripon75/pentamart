@extends('adminend.layouts.default')
@section('title', 'District')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Create District</h6>
        <div class="actions">
            <a href="{{ route('admin.districts.index') }}" class="action btn btn-primary">District</a>
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
                        <form action="{{ route('admin.districts.store') }}" method="POST">
                            @csrf

                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item w-full">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full rounded-md border-gray-300" name="status">
                                    <option value="active">Select</option>
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : ''}}>Active</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : ''}}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label class="form-label">Delivery Charge</label>
                                <input type="number" value="{{ old('delivery_charge') }}" name="delivery_charge" class="form-input" />
                                @error('delivery_charge')
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
