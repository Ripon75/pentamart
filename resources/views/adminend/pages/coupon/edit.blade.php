@extends('adminend.layouts.default')
@section('title', 'Coupons')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Coupon</h6>
        <div class="actions">
            <a href="{{ route('admin.coupons.index') }}" class="action btn btn-primary">Coupons</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[600px] mx-auto">

                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                @endif

                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label class="form-label">Name</label>
                                    <input type="text" value="{{ $coupon->name }}" name="name" class="form-input"/>
                                    @error('name')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label class="form-label">Code</label>
                                    <input type="text" value="{{ $coupon->code }}" name="code" class="form-input"/>
                                    @error('code')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-select w-full form-input" name="status">
                                        <option value="active">Select</option>
                                        <option value="active" {{ $coupon->status == 'active' ? "selected" : '' }}>Active</option>
                                        <option value="inactive" {{ $coupon->status == 'inactive' ? "selected" : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Discount type</label>
                                    <select class="form-select w-full form-input" name="discount_type">
                                        <option value="fixed">Select</option>
                                        <option value="fixed" {{ $coupon->discount_type === 'fixed' ? "selected" : '' }}>Fixed</option>
                                        <option value="percentage" {{ $coupon->discount_type === 'percentage' ? "selected" : '' }}>Percentage</option>
                                    </select>
                                    @error('discount_type')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Minimum cart amount</label>
                                    <input type="number" value="{{ $coupon->min_cart_amount }}" name="min_cart_amount" class="w-full form-input">
                                    @error('min_cart_amount')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Discount amount</label>
                                    <input type="number" value="{{ $coupon->discount_amount }}" name="discount_amount" class="w-full form-input">
                                    @error('discount_amount')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Started at</label>
                                    <input type="datetime-local" value="{{ date('Y-m-d\TH:i:s', strtotime($coupon->started_at)) }}" name="started_at" class="form-input">
                                    @error('started_at')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Ended at</label>
                                    <input type="datetime-local" value="{{ date('Y-m-d\TH:i:s', strtotime($coupon->ended_at)) }}" name="ended_at" class="form-input">
                                    @error('ended_at')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
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

@push('scripts')
    <script>
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 4000 );
    </script>
@endpush
