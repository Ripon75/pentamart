@extends('frontend.layouts.default')
@section('title', 'My-Order')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            {{-- =======List========= --}}
            <div class="col-span-1 hidden sm:hidden md:hidden lg:block xl:block 2xl:block">
                <x-frontend.customer-nav/>
            </div>
            {{-- =============== --}}
            <div class="col-span-3">
                <div class="flex space-x-2 sm:space-x-2 md:space-x-2 lg:space-x-0 xl:space-x-0 2xl:space-x-0">
                    <div class="relative block sm:block md:block lg:hidden xl:hidden 2xl:hidden">
                        <button id="category-menu" onclick="menuToggleCategory()" class="h-[46px] w-14 bg-white flex items-center justify-center rounded border-2 ">
                            <i class="text-xl fa-solid fa-ellipsis-vertical"></i>
                        </button>
                          {{-- ===Mobile menu for order===== --}}
                        <div id="category-list-menu" style="display: none" class="absolute left-0 w-60">
                            <x-frontend.customer-nav/>
                        </div>
                    </div>
                    <div class="mb-4 flex-1">
                        @if(Session::has('error'))
                            <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                        @endif
                        <x-frontend.header-title
                            type="else"
                            title="Order"
                            bgImageSrc=""
                            bgColor="#00798c"
                        />
                    </div>
                </div>
                <div class="card p-0 sm:p-0 md:p-2 lg:p-4 xl:p-4 2xl:p-4">
                    <div class="w-full overflow-x-scroll">
                        <table class="table-auto w-full text-xs sm:text-xs md:text-sm">
                            <thead class="">
                                <tr class="bg-gray-100">
                                    <th class="text-left border p-2">Order ID</th>
                                    <th class="text-right border p-2">Items</th>
                                    <th class="text-right border p-2">Price</th>
                                    <th class="text-center border p-2">Status</th>
                                    <th class="text-left border p-2">Submitted at</th>
                                    <th class="text-center border p-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="border p-2">{{ $order->id }}</td>
                                        <td class="border border-l-0 p-2 text-right">{{ count($order->items) }}</td>
                                        <td class="border border-l-0 p-2 text-right">
                                            <span>{{ $currency }}</span>
                                            @php
                                                $payableTotal = round($order->payable_price);
                                            @endphp
                                            <span class="ml-1">{{ number_format($payableTotal, 2) }}</span>
                                        </td>
                                        @php
                                            $statusSlug = $order->currentStatus->slug ?? null;
                                            $label      = 'N/A';
                                            $bgColor    = '#f94449';
                                            $fontColor  = '#ffff';
                                            if ($statusSlug) {
                                                $status = $order->getStatus($statusSlug);
                                                if ($status) {
                                                    $label     = $status['label'];
                                                    $bgColor   = $status['color']['background'];
                                                    $fontColor = $status['color']['font'];
                                                }
                                            }
                                        @endphp
                                        <td class="border border-l-0 p-2 text-center">
                                            @if ($order->currentStatus)
                                                <span class="rounded border px-2 py-1 text-xs"
                                                    style="background-color:{{ $bgColor }};color:{{ $fontColor }};">
                                                    {{ ($order->currentStatus->name) ?? null }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="border border-l-0 p-2">{{ $order->created_at }}</td>
                                        <td class="border border-l-0 p-2 flex flex-wrap space-y-1 md:space-y-0 space-x-2 items-center justify-center">
                                            {{-- Order details --}}
                                            <a href="{{ route('my.order.show', $order->id) }}" class="">
                                                <button title="View" class="btn px-2 py-1">
                                                    {{-- <i class="fa-regular fa-eye"></i> --}}
                                                    Show
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- ========Pagination============ --}}
                        @if ($orders->hasPages())
                            <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                                {{ $orders->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script>
        setTimeout(function(){
            $("div.alert").remove();
        }, 5000 );

        var alertTime                      = "{{ config('crud.alear_time') }}";
        var btnPrescription                = $('.btn-prescription');
        var btnSelectPaymentMethodDisable  = $('.btn-select-payment-method-disable');
        var btnSelectPaymentMethodActive   = $('.btn-select-payment-method-active');
        var btnSelectedPaymentMethodSubmit = $('#btn-selected-payment-method-submit');
        var inputSelectedPaymentMethodId   = $('#input-selected-payment-method-id');
        var selectedOrderID                = null;

        // Disable button
        btnPrescription.prop("disabled", true);
        btnSelectPaymentMethodDisable.prop("disabled", true);

        $(function() {
            // Get selected order id
            btnSelectPaymentMethodActive.click(function() {
                selectedOrderID = $(this).data('payment-method-order-id');
            });

            // Event payment method submit method
            btnSelectedPaymentMethodSubmit.click(function() {
                var selectedPaymentMethodId = inputSelectedPaymentMethodId.val();
                if (!selectedPaymentMethodId) {
                    __showNotification('error', 'Please select payment method', alertTime);
                    return false;
                }
                if (selectedOrderID && selectedPaymentMethodId) {
                    location.href=`order/payment/${selectedOrderID}?pg_id=${selectedPaymentMethodId}`;
                }
            });
        });

        // Category Menu for User order
        function menuToggleCategory() {
            var categoryList = document.getElementById('category-list-menu');
            if(categoryList.style.display == "none") { // if is menuBox displayed, hide it
                categoryList.style.display = "block";
            }
            else { // if is menuBox hidden, display it
                categoryList.style.display = "none";
            }
        }
    </script>
@endpush
