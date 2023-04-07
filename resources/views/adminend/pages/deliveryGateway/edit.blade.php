@extends('adminend.layouts.default')
@section('title', 'Delivery Gateways')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Delivery Gateway</h6>
        <div class="actions">
            <a href="{{ route('admin.deliveries.index') }}" class="action btn btn-primary">Delivery Gateways</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.deliveries.update', $data->id) }}" method="POST">
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
                                @error('code')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Price</label>
                                <input type="number" value="{{ $data->price }}" name="price" class="w-full">
                                @error('price')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Minimum delivery time</label>
                                <input type="number" name="min_delivery_time" value="{{ $data->min_delivery_time }}" class="w-full">
                                @error('min_delivery_time')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Maximum delivery time</label>
                                <input type="number" name="max_delivery_time" value="{{ $data->max_delivery_time }}" class="w-full">
                                @error('max_delivery_time')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Delivery time unit</label>
                                <input type="text" name="delivery_time_unit" value="{{ $data->delivery_time_unit }}" class="w-full">
                                @error('delivery_time_unit')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
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
