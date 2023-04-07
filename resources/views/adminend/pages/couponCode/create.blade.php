@extends('adminend.layouts.default')
@section('title', 'Coupon codes')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Create Coupon Code</h6>
        <div class="actions">
            <a href="{{ route('admin.coupon-codes.index') }}" class="action btn btn-primary">Coupon Codes</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.coupon-codes.store') }}" method="POST">
                            @csrf

                            <div class="form-item ">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item ">
                                <label class="form-label">Code</label>
                                <input type="text" value="{{ old('code') }}" name="code" class="form-input" />
                                @error('code')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full" name="status">
                                    <option value="activated">Select Status</option>
                                    <option value="activated" {{ old('status') === 'activated' ? 'selected' : ''}}>Activated</option>
                                    <option value="inactivated" {{ old('status') === 'inactivated' ? 'selected' : ''}}>Inactivated</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Discount Type</label>
                                <select class="form-select w-full" name="discount_type">
                                    <option value="">Select discount type</option>
                                    <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Fixed</option>
                                    <option value="percentage" {{ old('discount_type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                </select>
                                @error('discount_type')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Applicable ON</label>
                                <select class="form-select w-full" name="applicable_on">
                                    <option value="">Select Applicable Type</option>
                                    @foreach ($applicableOn as $applocable)
                                        <option value="{{ $applocable['value'] }}">
                                            {{ $applocable['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('applicable_on')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Discount Amount</label>
                                <input type="number" name="discount_amount" value="{{ old('discount_amount') }}" class="w-full">
                                 @error('discount_amount')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Minimum cart amount</label>
                                <input type="number" name="min_cart_amount" value="{{ old('min_cart_amount') }}" class="w-full">
                                @error('min_cart_amount')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Started at</label>
                                <input type="date" name="started_at" class="w-full">
                                @error('started_at')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Ended at</label>
                                <input type="date" name="ended_at" class="w-full">
                                @error('ended_at')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Description</label>
                                <input type="text" name="description" value="{{ old('description') }}" class="w-full">
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
