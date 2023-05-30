@extends('adminend.layouts.default')
@section('title', 'Coupon Codes')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Show Coupon Code</h6>
        <div class="actions">
            <a href="{{ route('admin.coupons.index') }}" class="action btn btn-primary">Coupons</a>
        </div>
    </div>
    <div class="page-content">
        <div class="m-5">
            <div class="">
                <h5>Coupon Single View</h5>
            </div>
            <div class="">
                <div class="mt-2">
                    <span class="font-bold">Name :</span> {{ $coupon->name }}
                </div>
                <div class="mt-2">
                    <span class="font-bold">Code :</span> {{ $coupon->code }}
                </div>
                <div class="mt-2">
                    <span class="font-bold">Status :</span> {{ $coupon->status }}
                </div>
                <div class="mt-2">
                    <span class="font-bold">Discount Type :</span> {{ $coupon->discount_type }}
                </div>
                <div class="mt-2">
                    <span class="font-bold">Discount Amount :</span> {{ $coupon->discount_amount }}
                </div>
                <div class="mt-2">
                    <span class="font-bold">Code :</span> {{ $coupon->min_cart_amount }}
                </div>
                <div class="mt-2">
                    <span class="font-bold">Min Cart Amount :</span> {{ $coupon->description }}
                </div>
                <div class="mt-2">
                    <span class="font-bold">Start Date :</span> {{ $coupon->started_at->format('Y-m-d') }}
                </div>
                <div class="mt-2">
                    <span class="font-bold">End Date :</span> {{ $coupon->ended_at->format('Y-m-d') }}
                </div>
                <div class="mt-2">
                    <span class="font-bold">Created At :</span> {{ $coupon->created_at->format('Y-m-d') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

