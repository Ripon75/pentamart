@extends('adminend.layouts.default')
@section('title', 'Payment Gateway')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Edit Payment Gateway</h6>
        <div class="actions">
            <a href="{{ route('admin.payments.index') }}" class="action btn btn-primary">Payment Gateways</a>
        </div>
    </div>
    <div class="page-content">
        <div class="m-5">
            <div class="">
                <h5>Payment Gateway Single View</h5>
            </div>
            <div class="">
                <div class="mt-2">
                    Name : {{ $result->name }}
                </div>
                <div class="mt-2">
                    Slug : {{ $result->slug }}
                </div>
                <div class="mt-2">
                    Code : {{ $result->code }}
                </div>
                <div class="mt-2">
                    Status : {{ $result->status }}
                </div>
                <div class="mt-2">
                    Description : {{ $result->description }}
                </div>
                <div class="mt-2">
                    Created At : {{ $result->created_at }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
