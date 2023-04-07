@extends('adminend.layouts.default')
@section('title', 'Generics')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Show Generic</h6>
        <div class="actions">
            <a href="{{ route('admin.generics.index') }}" class="action btn btn-primary">Generics</a>
        </div>
    </div>
    <div class="page-content">
        <div class="m-5">
                <div class="">
                    <h5>Generic Single View</h5>
                </div>
                <div class="">
                    <div class="mt-2">
                        Name : {{ $result->name }}
                    </div>
                    <div class="mt-2">
                        Slug : {{ $result->slug }}
                    </div>
                    <div class="mt-2">
                        Srength : {{ $result->strength }}
                    </div>
                    <div class="mt-2">
                        Created At : {{ $result->created_at }}
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
