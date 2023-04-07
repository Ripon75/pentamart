@extends('adminend.layouts.default')
@section('title', 'Dashboard')
@section('content')
    <div class="m-5">
        <div class="">
            <h5>Product Pack Single View</h5>
        </div>
        <div class="">
            <div class="mt-2">
                Name : {{ $result->name }}
            </div>
            <div class="mt-2">
                Slug : {{ $result->slug }}
            </div>
            <div class="mt-2">
                Product : {{ ($result->product->name) ?? null }}
            </div>
            <div class="mt-2">
                UOM : {{ ($result->uom->name) ?? null }}
            </div>
            <div class="mt-2">
                Piece : {{ $result->piece }}
            </div>
            <div class="mt-2">
                Price : {{ $result->price }}
            </div>
            <div class="mt-2">
                Minimum Order Qty : {{ $result->min_order_qty }}
            </div>
            <div class="mt-2">
                Maximum Order Qty : {{ $result->max_order_qty }}
            </div>
            <div class="mt-2">
                Description : {{ $result->description }}
            </div>
            <div class="mt-2">
                Created At : {{ $result->created_at }}
            </div>
        </div>
    </div>
@endsection
