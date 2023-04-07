@extends('sellercenter.layouts.default')
@section('title', 'Payment refund')
@section('content')
<section class="">
    <div class="container">
        <div class="my-16 lg:w-[500px] xl:w-[500px] mx-auto">
            <div class="card shadow">
                <div class="body p-4">
                    <form action="{{ route('seller.orders.refund.store') }}" method="POST">
                        @csrf

                        <div class="form-item">
                            <label class="form-label">Payment ID</label>
                            <input type="text" value="{{ $order->transaction->payment_id ?? '' }}" name="payment_id" class="form-input" readonly/>
                            @error('payment_id')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label">Payment Gateway TRX ID</label>
                            <input type="text" value="{{ $order->transaction->payment_gateway_trxid ?? '' }}" name="payment_gateway_trxid" class="form-input" readonly/>
                            @error('payment_gateway_trxid')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label">Price</label>
                            <input type="text" value="{{ $order->transaction->amount ?? '' }}" name="price" class="form-input"/>
                            @error('price')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-input"/>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Reason Note</label>
                            <textarea name="note" rows="2" cols="50"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
