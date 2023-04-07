@extends('adminend.layouts.print')
@section('title', 'Shipping Label')
@section('content')

<section class="page mx-auto">
    <div class="my-4 flex justify-end no-print">
        <button class="btn btn-primary" onclick="window.print()">Print</button>
    </div>
    <div class="bg-white">
        <div class="p-8">
            {{-- Header section --}}
            <div class="flex border-2 border-black items-center justify-between p-2">
                <img class="h-12 w-auto" src="/images/logos/logo-full-color.svg" alt="">
                <div class="flex flex-col items-center">
                    <label class="font-medium">Order Date</label>
                    <div class="text-right">
                        <span class="">{{ $order->created_at->format('Y-m-d') }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 mb-4">
                <table class="w-full">
                    <tbody class="table w-full">
                        <tr class="border-2 border-black text-sm">
                            <td class="w-32 font-semibold">Order Id</td>
                            <td class="w-48">{{ $order->id }}</td>
                        </tr>
                        <tr class="border-2 border-black text-sm">
                            <td class="w-32 border border-black"><span class="font-semibold">Total payable amount</span><br><span class="text-xs">(Incl. delivery charge)</span></td>
                            @if ($order->is_paid)
                                <td class="w-48 border border-black">0 Tk.</td>
                            @else
                                <td class="w-48 border border-black">{{ number_format(round($order->payable_order_value), 2); }} Tk.</td>
                            @endif
                        </tr>
                        @if ($order->items)
                            <tr class="border-2 border-black text-sm">
                                <td class="w-32 border border-black font-semibold">Payment type</td>
                                @if ($order->is_paid)
                                <td class="w-48 border border-black">Paid</td>
                                @else
                                <td class="w-48 border border-black">{{ $order->paymentGateway->name ?? '' }}</td>
                                @endif
                            </tr>
                        @endif
                        <tr class="border-2 border-black text-sm">
                                @if ($order->items)
                                <td class="w-32 border border-black font-semibold">Customer name</td>
                                <td class="w-48 border border-black">{{ $order->user->name ?? '' }}</td>
                            </tr>
                        @endif
                        @if ($order->items)
                        <tr class="border-2 border-black text-sm">
                            <td class="w-32 border border-black font-semibold">Phone</td>
                            <td class="w-48 border border-black">{{ $order->user->phone_number ?? '' }}</td>
                        </tr>
                        @endif
                        @if ($order->items)
                            <tr class="border-2 border-black text-sm">
                                <td class="w-32 border border-black font-semibold">Address</td>
                                <td class="w-48 border border-black">{{ $order->shippingAddress->address ?? '' }}</td>
                            </tr>
                        @endif
                        <tr class="border-2 border-black text-sm">
                            <td class="w-80 text-center border border-black" colspan="2">Thank you for trusting Medicart</td>
                        </tr>
                        <tr class="border-2 border-black text-sm">
                            <td class="w-32 border border-black font-semibold">Contact us</td>
                            <td class="w-48 border border-black text-xs">
                                Helpline No: 09609080706 <br>
                                Email: contact@medicart.health
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script>

    </script>
@endpush
