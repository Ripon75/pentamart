<div class="product-search-box relative">
    {{-- Hidden field --}}
    <input id="input-product-id" type="hidden" name="product_id" value="">
    <input id="input-product-name" type="hidden" name="product_name" value="">
    <input id="input-product-image-src" type="hidden" name="product_image_src" value="">
    <input id="input-product-mrp" type="hidden" name="product_mrp" value="">
    <input id="input-product-selling-price" type="hidden" name="product_selling_price" value="">
    <input id="input-product-pack-size" type="hidden" name="product_pack_size" value="">
    <input id="input-product-pack-name" type="hidden" name="product_pack_name" value="">
    <input id="input-product-uom" type="hidden" name="uom" value="">
    <input id="input-product-num-of-pack" type="hidden" name="num_of_pack" value="">
    {{-- End hidden field --}}
    <input id="input-product-search" type="text" placeholder="Product search and select"
        class="rounded border w-full" autocomplete="off">
    <div class="search-result hidden bg-white border rounded-b
        absolute left-0 right-0 top-full z-30 shadow-md -mt-1">
        <div class="search-list flex flex-col divide-y h-72 overflow-y-auto">
        </div>
    </div>
</div>

@push('scripts')
    <script>
        var searchInput           = $('#input-product-search');
        var inputProductId        = $('#input-product-id');
        var inputProductName      = $('#input-product-name');
        var inputProductImageSRC  = $('#input-product-image-src');
        var inputProductMRP       = $('#input-product-mrp');
        var inputProductSallPrice = $('#input-product-selling-price');
        var inputProductPackSize  = $('#input-product-pack-size');
        var inputProductPackName  = $('#input-product-pack-name');
        var inputProductUOM       = $('#input-product-uom');
        var inputProductNumOfPack = $('#input-product-num-of-pack');
        var searchResult          = $('.search-result');
        var searchResultList      = $('.search-list');
        var searchItem            = $('.search-item');
        var debounceTime          = 750;

        $(function() {
            // If click outside of the model search box hide the search result list
            $(document).click(function(e) {
                var container = $('.product-search-box');
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    searchResult.hide();
                }
            });
            searchInput.keyup(__debounce(function(e) {
                var key = e.which;
                var searchKeywords = $(this).val();

                if (searchKeywords.length >= 3) {
                    productSearch(searchKeywords);
                    searchResult.show();
                }
                if (searchKeywords.length < 3) {
                    searchResult.hide();
                }
                // If press Enter key goto the product search page
                if (key == 13) // the enter key code
                {
                    window.location.href = `/products?search_key=${searchKeywords}`;
                }
            }, debounceTime));

            $('.search-list').on('click', '.search-item', function(e) {
                var productId        = $(this).data('product-id');
                var productName      = $(this).data('product-name');
                var productImageSRC  = $(this).data('product-image-src');
                var productMRP       = $(this).data('product-mrp');
                var productSalePrice = $(this).data('product-selling-price');
                var productPackSize  = $(this).data('product-pack-size');
                var productPackName  = $(this).data('product-pack-name');
                var productUOM       = $(this).data('product-uom');
                var productNumOfPack = $(this).data('product-num-of-pack');

                inputProductId.val(productId);
                inputProductName.val(productName);
                inputProductImageSRC.val(productImageSRC);
                inputProductMRP.val(productMRP);
                inputProductSallPrice.val(productSalePrice);
                inputProductPackSize.val(productPackSize);
                inputProductPackName.val(productPackName);
                inputProductUOM.val(productUOM);
                inputProductNumOfPack.val(productNumOfPack);
                searchInput.val(productName);

                searchResult.hide();

                onSearchProductSelect(productPackSize, productNumOfPack, productUOM);

            });
        })

        function productSearch(keywords) {
            axios.get('/api/product/search', {
                params: {
                    search_query: keywords,
                    search_limit: 10
                }
            })
            .then((response) => {
                var result = [];
                if (response.data.success) {
                    result = response.data.result;
                    renderSearchResult(result);
                }
            })
            .catch((error) => {
                console.log(error);
            });
        }

        function renderSearchResult(data) {
            searchResultList.html('');
            for (let index = 0; index < data.length; index++) {
                const product        = data[index];
                const dosageFormName = product.dosage_form ? product.dosage_form.name : '';
                const genericName    = product.generic ? product.generic.name : '';

                var itemHTML = `
                    <div
                        class="search-item hover:bg-gray-200 transition duration-150 ease-in-out border-b border-dashed flex space-x-2 p-2 pr-3 items-center" data-product-id="${product.id}"
                        data-product-id="${product.id}"
                        data-product-name="${product.name}"
                        data-product-image-src="${product.image_src}"
                        data-product-mrp="${product.mrp}"
                        data-product-selling-price="${product.selling_price}"
                        data-product-pack-size="${product.pack_size}"
                        data-product-pack-name="${product.pack_name}"
                        data-product-uom="${product.uom}"
                        data-product-num-of-pack="${product.num_of_pack}"
                        >
                        <div class="w-14 h-14">
                            <img class="w-full h-full" src="${product.image_src}" alt="">
                        </div>
                        <div class="flex-1 flex flex-col">
                            <h4 class="text-xs text-gray-500">${dosageFormName}</h4>
                            <h2 class="text-base text-primary">${product.name}</h2>
                            <span class="text-xxs text-gray-500">${genericName}</span>
                        </div>
                        <div class="flex justify-center items-center text-sm">
                            <span class="text-gray-500">${product.mrp} tk</span>
                        </div>
                    </div>`;

                searchResultList.append(itemHTML);
            }
            searchResult.show();
        }

    </script>
@endpush
