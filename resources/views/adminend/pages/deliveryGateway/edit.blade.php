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

                {{-- Show error message --}}
                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                @endif

                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.deliveries.update', $dg->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ $dg->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Price</label>
                                <input type="number" value="{{ $dg->price }}" name="price" class="form-input">
                                @error('price')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Promo Price</label>
                                <input type="number" value="{{ $dg->promo_price }}" name="promo_price" class="form-input">
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Minimum time</label>
                                <input type="number" name="min_time" value="{{ $dg->min_time }}" class="form-input">
                                @error('min_time')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Maximum time</label>
                                <input type="number" name="max_time" value="{{ $dg->max_time }}" class="form-input">
                                @error('max_time')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Time unit</label>
                                <select class="form-select form-input" name="time_unit">
                                    <option value="days">Select</option>
                                    <option value="hours" {{ $dg->time_unit == 'hours' ? "selected" : '' }}>Hours</option>
                                    <option value="days" {{ $dg->time_unit == 'days' ? "selected" : '' }}>Days</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select form-input" name="status">
                                    <option value="inactive">Select</option>
                                    <option value="active" {{ $dg->status == 'active' ? "selected" : '' }}>Active</option>
                                    <option value="inactive" {{ $dg->status == 'inactive' ? "selected" : '' }}>Inactive</option>
                                </select>
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
