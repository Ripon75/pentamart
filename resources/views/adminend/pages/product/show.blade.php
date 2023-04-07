@extends('adminend.layouts.default')
@section('title', 'Priducts')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Create Product</h6>
        <div class="actions">
            <a href="{{ route('admin.products.index') }}" class="action btn btn-primary">Products</a>
        </div>
    </div>
    <div class="page-content">
        <div class="m-5">
            <div class="">
                <h5>Product Single View</h5>
            </div>
            <div class="mt-5">
                <div class="mt-2">
                    Name : {{ $result->name }}
                </div>
                <div class="mt-2">
                    Slug : {{ $result->slug }}
                </div>
                <div class="mt-2">
                    Brand : {{ ($result->brand->name) ?? null }}
                </div>
                <div class="mt-2">
                    Generic : {{ ($result->generic->name) ?? null }}
                </div>
                <div class="mt-2">
                    Dosage Form : {{ ($result->dosageForm->name) ?? null }}
                </div>
                {{-- <div class="mt-2">
                    Category : {{ ($result->category->name) ?? null }}
                </div> --}}
                <div class="mt-2">
                    MRP : {{ $result->mrp }}
                </div>
                <div class="mt-2">
                    Status : {{ $result->status }}
                </div>
                <div class="mt-2">
                    Description : {{ $result->description }}
                </div>
                <div class="mt-2">
                    Meta Title : {{ $result->meta_title }}
                </div>
                <div class="mt-2">
                    Meta Keyword : {{ $result->meta_keywords }}
                </div>
                <div class="mt-2">
                    Meta Description : {{ $result->meta_description }}
                </div>
                <div class="mt-2">
                    Created At : {{ $result->created_at }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
