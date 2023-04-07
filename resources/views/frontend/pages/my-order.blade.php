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
                            bgColor="#102967"
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
                                                $payableTotal = round($order->payable_order_value);
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
                                            @if (!$order->is_paid && !($order->current_status_id == 3 || $order->current_status_id == 8 || $order->current_status_id == 9))
                                                <button
                                                    type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal"
                                                    class="btn-select-payment-method-active btn btn-xxs bg-green-500 hover:bg-green-600 text-white hover:text-white"
                                                    data-payment-method-order-id="{{ $order->id }}">
                                                    Payment
                                                </button>
                                            @else
                                                <button data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    class="btn-select-payment-method-disable btn btn-xxs text-gray-600 disabled:opacity-60">
                                                    Payment
                                                </button>
                                            @endif
                                            <!-- Modal -->
                                            <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
                                                id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog relative w-full pointer-events-none">
                                                    <div class="border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                                                        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                                                            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Payment</h5>
                                                            <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body relative p-4">
                                                            <div class="flex justify-center">
                                                                <div class="mb-3 xl:w-96">
                                                                    <select class="rounded w-full" id="input-selected-payment-method-id">
                                                                        <option value="">Select Method</option>
                                                                        @foreach ($paymentGateways as $pg)
                                                                            <option value="{{ $pg->id }}">{{ $pg->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="text-right">
                                                                        <button id="btn-selected-payment-method-submit" class="btn btn-md mt-4 btn-success">
                                                                            Submit
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Order details --}}
                                            <a href="{{ route('my.order.show', $order->id) }}" class="">
                                                <button title="View" class="btn btn-sm btn-icon-only">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                            </a>

                                            {{-- Prescription --}}
                                            @if (count($order->prescriptions) > 0)
                                                <button class="btn btn-xxs bg-green-400 hover:bg-green-500 text-gray-600 hover:text-gray-600">
                                                    <a class="text-gray-600 hover:text-gray-600" href="{{ route('show.prescription', $order->id) }}">Rx</a>
                                                </button>
                                            @else
                                                <button class="btn-prescription btn btn-xxs text-gray-600 disabled:opacity-60">
                                                    Rx
                                                </button>
                                            @endif
                                            {{-- Reorder --}}
                                            <button class="btn btn-xxs bg-orange-400 hover:bg-orange-500 text-white hover:text-white">
                                                <a href="{{ route('my.order.reorder', $order->id) }}" class="text-white hover:text-white">Reorder</a>
                                            </button>
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
                    location.href=`order/payment/${selectedOrderID}?payment_method_id=${selectedPaymentMethodId}`;
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
