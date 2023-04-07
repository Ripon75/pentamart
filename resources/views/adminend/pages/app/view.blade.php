@extends('adminend.layouts.default')
@section('title', 'Order History')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Order</h6>
        <div class="actions">
            <button class="prntBtn btn btn-primary" onclick="printDiv('table-report')">Print</button>
        </div>
    </div>
    <div class="page-content">
        <div class="action-bar mb-4 bg-primary-lightest border p-4">
            <div class="grid place-items-center">
                <a href="{{ route('admin.app.update') }}" class="btn btn-success">Update</a>
            </div>
        </div>
        <div class="mt-8" id="table-report">
            <table class="table-report w-full">
            </table>
        </div>
    </div>
</div>
@endsection

