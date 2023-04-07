@extends('adminend.layouts.default')
@section('title', 'Order Status')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Edit Order Status</h6>
        <div class="actions">
            <a href="{{ route('admin.order-statuses.index') }}" class="action btn btn-primary">Order Status</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.order-statuses.update', $orderStatus->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ $orderStatus->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Customer visibility</label>
                                <select class="form-select w-full" name="customer_visibility">
                                    <option value="">Select customer visibility</option>
                                    <option value="1" {{ $orderStatus->customer_visibility == 1 ? "selected" : ''}}>True</option>
                                    <option value="0" {{ $orderStatus->customer_visibility == 0 ? "selected" : ''}}>False</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Seller visibility</label>
                                <select class="form-select w-full" name="seller_visibility">
                                    <option value="0">Select seller visibility</option>
                                    <option value="1" {{ $orderStatus->seller_visibility == 1 ? "selected" : ''}}>True</option>
                                    <option value="0" {{ $orderStatus->seller_visibility == 0 ? "selected" : ''}}>False</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Description</label>
                                <textarea class="w-full" name="description">{{ $orderStatus->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
