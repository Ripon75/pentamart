@extends('adminend.layouts.default')
@section('title', 'Brands')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Show Brand</h6>
        <div class="actions">
            <a href="{{ route('admin.brands.index') }}" class="action btn btn-primary">Brands</a>
        </div>
    </div>
    <div class="page-content">
        <div class="m-5">
            <div class="">
                <h5>Brand Single View</h5>
            </div>
            <div class="">
                <div class="mt-2">
                    Name : {{ $result->name }}
                </div>
                <div class="mt-2">
                    Slug : {{ $result->slug }}
                </div>
                <div class="mt-2">
                    Company : {{ $result->company->name ?? null }}
                </div>
                <div class="mt-2">
                    Logo Path : {{ $result->logo_path }}
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
