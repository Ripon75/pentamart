@extends('adminend.layouts.default')
@section('title', 'Coupon Codes')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Coupon Code</h6>
        <div class="actions">
            <a href="{{ route('admin.coupon-codes.index') }}" class="action btn btn-primary">Coupon Codes</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('message') }}</div>
                @endif

                @if(Session::has('message'))
                    <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                @endif
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.coupon-codes.update', $data->id) }}" method="POST">
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
                                <label class="form-label">Code</label>
                                <input type="text" value="{{ $data->code }}" name="code" class="form-input" />
                                @error('code')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full" name="status">
                                    <option value="activated">Select status</option>
                                    <option value="activated" {{ $data->status == 'activated' ? "selected" : '' }}>Activated</option>
                                    <option value="inactivated" {{ $data->status == 'inactivated' ? "selected" : '' }}>Inactivated</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Discount type</label>
                                <select class="form-select w-full" name="discount_type">
                                    <option value="fixed">Select discount type</option>
                                    <option value="fixed" {{ $data->discount_type === 'fixed' ? "selected" : '' }}>Fixed</option>
                                    <option value="percentage" {{ $data->discount_type === 'percentage' ? "selected" : '' }}>Percentage</option>
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
                                        <option value="{{ $applocable['value'] }}" {{ $applocable['value'] === $data->applicable_on ? 'selected' : '' }}>
                                            {{ $applocable['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('applicable_on')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Discount amount</label>
                                <input type="number" value="{{ $data->discount_amount }}" name="discount_amount" class="w-full">
                                @error('discount_amount')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Minimum cart amount</label>
                                <input type="number" value="{{ $data->min_cart_amount }}" name="min_cart_amount" class="w-full">
                                @error('min_cart_amount')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Description</label>
                                <input type="text" value="{{ $data->description }}" name="description" class="w-full">
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Started at</label>
                                <input type="datetime-local" value="{{ date('Y-m-d\TH:i:s', strtotime($data->started_at)) }}" name="started_at" class="w-full">
                                @error('started_at')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Ended at</label>
                                <input type="datetime-local" value="{{ date('Y-m-d\TH:i:s', strtotime($data->ended_at)) }}" name="ended_at" class="w-full">
                                @error('ended_at')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
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

@push('scripts')
    <script>
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 4000 );
    </script>
@endpush
