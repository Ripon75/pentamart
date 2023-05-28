@extends('adminend.layouts.default')
@section('title', 'Delivery Gateway')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Show Delivery Gateway</h6>
        <div class="actions">
            <a href="{{ route('admin.deliveries.index') }}" class="action btn btn-primary">Delivery Gateways</a>
        </div>
    </div>
    <div class="page-content">
        <div class="m-5">
            <div class="">
                <h5>Delivery Gateway Single View</h5>
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
