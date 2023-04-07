@extends('adminend.layouts.default')
@section('title', 'Offers BSGS Create')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Offers BSGS Create</h6>
        <div class="actions">
            <a href="{{ route('admin.offers.bsgs.index') }}" class="action btn btn-primary">Offers</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <form action="{{ route('admin.offers.bsgs.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-3">
                        @if(Session::has('message'))
                            <div class="alert mb-8 mt-2 success">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert mb-8 mt-2 danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                            <fieldset class="bg-white shadow-sm border rounded p-4">
                                <legend class="bg-gray-50 text-gray-400">Offer On BSGS</legend>
                                <div class="form-item">
                                    <label class="form-label">Name</label>
                                    <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                                    @error('name')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                 <div class="form-item">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-select w-full" name="status">
                                        <option value="activated">Select Status</option>
                                        <option value="activated">Activated</option>
                                        <option value="inactivated">Inactivated</option>
                                    </select>
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">Start date</label>
                                    <input type="datetime-local" name="start_date" class="w-full">
                                    @error('start_date')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item">
                                    <label for="" class="form-label">End date</label>
                                    <input type="datetime-local" name="end_date" class="w-full">
                                    @error('end_date')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </fieldset>
                    </div>
                    <!-- Order details update -->
                    <div class="card shadow body p-4 col-span-9 mt-4">
                        <div class="flex w-full space-x-2 mb-4">
                            <div class="flex w-full space-x-4">
                                <div class="flex-1">
                                    <x-adminend.bsgs-product-search/>
                                </div>
                                <div class="">
                                    <button id="btn-add-product" type="button" class="btn btn-success w-16">Add</button>
                                </div>
                            </div>
                        </div>
                        <table class="table-auto w-full">
                            <thead class="">
                                <tr class="bg-gray-100">
                                    <th class="text-left border p-2">Image</th>
                                    <th class="text-left border p-2" title="Buy Product">Buy Products</th>
                                    <th class="text-left border p-2" title="Buy Quantity">Bye Quantity</th>
                                    <th class="text-left border p-2">Image</th>
                                    <th class="text-left border p-2" title="Discount Amount">Get Products</th>
                                    <th class="text-left border p-2" title="Discount Percent">Get Quantity</th>
                                    <th class="text-left border p-2">Action</th>
                                </tr>
                            </thead>
                            <tbody class="items-table-body">

                            </tbody>
                        </table>
                        <div class="text-right mt-2">
                            <button type="submit" class="btn btn-md btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        var itemIds        = [];
        var aleartTime    = {{ config('crud.alear_time') }};
        var btnAddProduct = $('#btn-add-product');
        $(function() {
            btnAddProduct.click(function() {
                var searchText    = $('#input-product-search').val();
                var productName   = $('#input-product-name').val();
                var productIdBSGS = $('#input-product-id-bsgs').val();
                if (!productName || !searchText || !productIdBSGS) {
                    __showNotification('error', 'Please select product', 1000);
                    return false;
                } else {
                    renderSelectedProduct();
                    searchInput.val('');
                    searchInputBSGS.val('');
                }
            });

            // Remove order item
            $('.items-table-body').on('click', '.delete-order-item-btn', function() {
                // check item already exist
                var productId = $(this).data('order-item-id');
                itemIds = jQuery.grep(itemIds, function(value) {
                    return value != productId;
                });

                $(this).parent().parent().remove();
            });

            // Event with when change discount amount
            $('.items-table-body').on('keyup', '.input-discount-amount', function() {
                var value = $(this).val();
                var productPrice = $(this).data('unit-price');

                var discountPercent = calDiscountPercent(productPrice, value);

                var changeinputId = $(this).data('change-input-id');
                $(`#${changeinputId}`).val(discountPercent);
            });

            // Event with when change discount percent
            $('.items-table-body').on('keyup', '.input-discount-percent', function() {
                var value = $(this).val();
                var productPrice = $(this).data('unit-price');

                var discountAmount = calDiscountAmount(productPrice, value);

                var changeinputId = $(this).data('change-input-id');
                $(`#${changeinputId}`).val(discountAmount);
            });
        });

        // HTML render
        function renderSelectedProduct() {
            // For quantity
            var productId     = $('#input-product-id').val();
            var productImgSRC = $('#input-product-image-src').val();
            var productName   = $('#input-product-name').val();
            var productQty    = $('#product-quantity').val();
            // For BSGS
            var productIdBSGS     = $('#input-product-id-bsgs').val();
            var productImgSRCBSGS = $('#input-product-image-src-bsgs').val();
            var productNameBSGS   = $('#input-product-name-bsgs').val();
            var productQtyBSGS    = $('#product-quantity-bsgs').val();

            var itemHTML = `
            <tr>
                <input type="hidden" name="items[${ productId }][buy_product_id]" value="${productId}">
                <input type="hidden" name="items[${ productId }][get_product_id]" value="${productIdBSGS}">

                <td class="text-center border p-2" style="width: 70px; height:40px">
                    <img src="${productImgSRC}" alt="Product Image">
                </td>
                <td class="border p-2"> ${productName} </td>
                <td class="border p-2 text-right">
                    <input value="${productQty}" type="number" name="items[${ productId }][by_qty]"
                    class="border-gray-300 focus:ring-0 focus:outline-none text-center w-20 rounded"/>
                </td>
                <td class="text-center border p-2" style="width: 70px; height:40px">
                    <img src="${productImgSRCBSGS}" alt="Product Image">
                </td>
                <td class="border p-2"> ${productNameBSGS} </td>
                <td class="border p-2 text-right">
                    <input value="${productQtyBSGS}" type="number" name="items[${ productId }][get_qty]"
                    class="border-gray-300 focus:ring-0 focus:outline-none text-center w-20 rounded"/>
                </td>
                <td class="text-center border w-16">
                    <button class="delete-order-item-btn"
                        type="button"
                        data-order-item-id="${productId}">
                        <i class="trash-icon text-xl text-gray-600 fa-regular fa-trash-can"></i>
                    </button>
                </td>
            </tr>`;

            $('.items-table-body').append(itemHTML);
        }
    </script>
@endpush
