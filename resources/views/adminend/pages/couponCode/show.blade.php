@extends('adminend.layouts.default')
@section('title', 'Coupon Codes')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Show Coupon Code</h6>
        <div class="actions">
            <a href="{{ route('admin.coupon-codes.index') }}" class="action btn btn-primary">Coupon Codes</a>
        </div>
    </div>
    <div class="page-content">
        <div class="m-5">
            <div class="">
                <h5>Coupon Single View</h5>
            </div>
            <div class="">
                <div class="mt-2">
                    Name : {{ $result->name }}
                </div>
                <div class="mt-2">
                    Code : {{ $result->code }}
                </div>
                <div class="mt-2">
                    Status : {{ $result->status }}
                </div>
                <div class="mt-2">
                    Discount type : {{ $result->discount_type }}
                </div>
                <div class="mt-2">
                    Discount : {{ $result->discount_amount }}
                </div>
                <div class="mt-2">
                    Minimum cart amount : {{ $result->min_cart_amount }}
                </div>
                <div class="mt-2">
                    Description : {{ $result->description }}
                </div>
                <div class="mt-2">
                    Started at : {{ $result->started_at }}
                </div>
                <div class="mt-2">
                    Ended at : {{ $result->ended_at }}
                </div>
                <div class="mt-2">
                    Created At : {{ $result->created_at }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

