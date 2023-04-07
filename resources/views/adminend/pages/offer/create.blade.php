@extends('adminend.layouts.default')
@section('title', 'Dashboard')
@section('content')
<section class="">
    <div class="container">
        <form action="{{ route('admin.offers.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-12 gap-2">
                <div class="col-span-4">
                    @if(Session::has('message'))
                        <div class="alert mb-8 mt-2 success">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                        <fieldset class="bg-white shadow-sm border rounded p-4">
                            <legend class="bg-gray-50 text-gray-400">Basic Offer</legend>
                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
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
                <div class="card shadow body p-4 col-span-8 mt-4">
                    <label for="">Add products</label>
                    <div class="flex w-full space-x-2 mb-4">
                        <div class="flex-1">
                            <x-adminend.product-search/>
                        </div>
                        <div class="w-20">
                            <input id="product-quantity" class="rounded w-full" type="number" min="1" value="1">
                        </div>
                        <button id="btn-add-product" type="button" class="btn btn-success w-16">Add</button>
                    </div>
                    <table class="table-auto w-full">
                        <thead class="">
                            <tr class="bg-gray-100">
                                <th class="text-left border p-2">Image</th>
                                <th class="text-left border p-2">Product</th>
                                <th class="text-left border p-2">Unit Price</th>
                                <th class="text-left border p-2" title="Discount Amount">Dis. Amount</th>
                                <th class="text-left border p-2" title="Discount Percent">Dis. Percent</th>
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
</section>
@endsection

@push('scripts')
    <script>
        $('#product-quantity').hide();
        var btnAddProduct = $('#btn-add-product');
        var inputDiscountAmount = $('.input-discount-amount');

        $(function() {
            btnAddProduct.click(function() {
                var searchText  = $('#input-product-search').val();
                var productName = $('#input-product-name').val();
                if (!productName || !searchText) {
                    __showNotification('error', 'Please select product', 1000);
                    return false;
                } else {
                    renderSelectedProduct();
                    searchInput.val('');
                }
            });

            // Remove order item
            $('.items-table-body').on('click', '.delete-order-item-btn', function() {
                $(this).parent().parent().remove();
            });

            $('.items-table-body').on('keyup', '.input-discount-amount', function() {
                var value = $(this).val();
                var productPrice = $(this).data('unit-price');

                var discountPercent = calDiscountPercent(productPrice, value);

                var changeinputId = $(this).data('change-input-id');
                $(`#${changeinputId}`).val(discountPercent);
            });

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
        var productId        = $('#input-product-id').val();
        var productName      = $('#input-product-name').val();
        var productImgSRC    = $('#input-product-image-src').val();
        var productMRP       = $('#input-product-mrp').val();
        var productSalePrice = $('#input-product-selling-price').val();
        var productPackSize  = $('#input-product-pack-size').val();
        var productPackName  = $('#input-product-pack-name').val();
        var productQty       = $('#product-quantity').val();

        var price = productSalePrice > 0 ? productSalePrice : productMRP;
        var subTotal = price * productQty * productPackSize;
        subTotal = subTotal.toFixed(2);

        var itemHTML = `
        <tr>
            <input type="hidden" name="items[${ productId }][product_id]" value="${productId}">
            <input type="hidden" name="items[${ productId }][price]" value="${price}">
            <td class="text-center border p-2" style="width: 70px; height:40px">
                <img src="${productImgSRC}" alt="Product Image">
            </td>
            <td class="border p-2"> ${productName} </td>
            <td class="border p-2 text-right">
                <span>Tk</span>
                <span class="ml-1">${price}</span>
            </td>
            <td class="border p-2">
                <input type="text"
                    name="items[${ productId }][discount_amount]"
                    id="input-discount-amount-id-${productId}"
                    data-change-input-id="input-discount-percent-id-${productId}"
                    data-unit-price="${price}"
                    data-total-item-price-label="total-price-${productId}"
                    data-item-pack-size="${productPackSize}"
                    value="0"
                    style="width:100%"
                    class="input-discount-amount border-gray-300 focus:ring-0 focus:outline-none text-center w-20 rounded">
            </td>
            <td class="border p-2">
                <input type="text"
                    name="items[${ productId }][discount_percent]"
                    id="input-discount-percent-id-${productId}"
                    data-change-input-id="input-discount-amount-id-${productId}"
                    data-unit-price="${price}"
                    data-total-item-price-label="total-price-${productId}"
                    data-item-pack-size="${productPackSize}"
                    value="0"
                    style="width:100%"
                    class="input-discount-percent border-gray-300 focus:ring-0 focus:outline-none text-center w-20 rounded">
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

    function calDiscountPercent(productPrice, discountAmount) {
        var discountPercent = 0;

        discountPercent = (discountAmount/productPrice) * 100;

        return discountPercent;
    }

    function calDiscountAmount(productPrice, discountPercent) {
        var discountAmount = 0;

        discountAmount = (productPrice * discountPercent)/100;

        return discountAmount;
    }

    </script>
@endpush
