@extends('adminend.layouts.default')
@section('title', 'Prescriptions')
@section('content')
<div class="page">
    {{-- page header --}}
    <div class="page-toolbar">
        <h6 class="title">All Orders</h6>
        <div class="actions">
            <a href="{{ route('admin.orders.index') }}" class="action btn btn-primary">Orders</a>
        </div>
    </div>
    <div class="page-content">
        <div class="m-5">
            @if (count($prescriptions) > 0)
                @foreach ($prescriptions as $prescription)
                    <div class="">
                        <img src="{{ $prescription->img_src }}" alt="" height="800" width="800"> <br> <br>
                    </div>
                @endforeach
            @else
                <div class="text-center">
                    No prescription heare
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
