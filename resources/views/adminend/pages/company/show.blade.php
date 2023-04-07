@extends('adminend.layouts.default')
@section('title', 'Companies')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Show Company</h6>
        <div class="actions">
            <a href="{{ route('admin.companies.index') }}" class="action btn btn-primary">companies</a>
        </div>
    </div>
    <div class="page-content">
        <div class="m-5">
            <div class="">
                <h5>Company Single View</h5>
            </div>
            <div class="">
                <div class="mt-2">
                    Name : {{ $result->name }}
                </div>
                <div class="mt-2">
                    Slug : {{ $result->slug }}
                </div>
                <div class="mt-2">
                    Parent : {{ $result->parent->name ?? null }}
                </div>
                <div class="mt-2">
                    Logo Path : {{ $result->logo_path }}
                </div>
                <div class="mt-2">
                    Created At : {{ $result->created_at }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
