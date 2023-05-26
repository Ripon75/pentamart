@extends('adminend.layouts.default')
@section('title', 'Coupons')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Create Coupon</h6>
        <div class="actions">
            <a href="{{ route('admin.coupons.index') }}" class="action btn btn-primary">Coupons</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="w-[600px] lg:w-[600px] xl:w-[600px] mx-auto">

                {{-- Show error message --}}
                 @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                @endif

                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.coupons.store') }}" method="POST">
                            @csrf

                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label class="form-label">Name</label>
                                    <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                                    @error('name')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label class="form-label">Code</label>
                                    <input type="text" value="{{ old('code') }}" name="code" class="form-input" />
                                    @error('code')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-select w-full rounded-md border-gray-300" name="status">
                                        <option value="active">Select</option>
                                        <option value="active" {{ old('status') === 'active' ? 'selected' : ''}}>Active</option>
                                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : ''}}>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Discount Type</label>
                                    <select class="form-select w-full rounded-md border-gray-300" name="discount_type">
                                        <option value="">Select</option>
                                        <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="percentage" {{ old('discount_type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    </select>
                                    @error('discount_type')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Minimum cart amount</label>
                                    <input type="number" name="min_cart_amount" value="{{ old('min_cart_amount') }}" class="form-input">
                                    @error('min_cart_amount')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Discount Amount</label>
                                    <input type="number" name="discount_amount" value="{{ old('discount_amount') }}" class="form-input">
                                     @error('discount_amount')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Applicable ON</label>
                                    <select class="form-select w-full rounded-md border-gray-300" name="applicable_on">
                                        <option value="">Select</option>
                                        <option value="cart">Cart</option>
                                        <option value="delivery_fee">Delivery Fee</option>
                                    </select>
                                    @error('applicable_on')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Description</label>
                                    <input type="text" name="description" value="{{ old('description') }}" class="form-input">
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Ended at</label>
                                    <input type="date" name="ended_at" class="form-input">
                                    @error('ended_at')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Started at</label>
                                    <input type="date" name="started_at" class="form-input">
                                    @error('started_at')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
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
