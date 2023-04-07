<div class="flex space-x-8">
    {{-- For buy product --}}
    <div class="product-search-box relative flex flex-1 space-x-4">
        {{-- Hidden field --}}
        <input id="input-product-id" type="hidden" value="">
        <input id="input-product-name" type="hidden" value="">
        <input id="input-product-image-src" type="hidden" value="">
        {{-- Search input field --}}
        <input id="input-product-search" type="text" placeholder="Product search and select"
            class="rounded border w-full">
        {{-- Quantity input field --}}
        <input id="product-quantity" class="rounded w-24" type="number" min="1" value="1">
    
        {{-- Search result for  --}}
        <div class="search-result hidden bg-white border rounded-b
            absolute left-0 right-0 top-full z-30 shadow-md -mt-1">
            <div class="search-list flex flex-col divide-y h-72 overflow-y-auto">
            </div>
        </div>
    </div>
    
    {{-- For get product --}}
    <div class="product-search-box_bsgs relative flex flex-1 space-x-4">
        {{-- Hidden field --}}
        <input id="input-product-id-bsgs" type="hidden" value="">
        <input id="input-product-name-bsgs" type="hidden" value="">
        <input id="input-product-image-src-bsgs" type="hidden" value="">
    
        {{-- Search input fild --}}
        <input id="input-product-search-bsgs" type="text" placeholder="Product search and select"
            class="rounded border w-full">
        {{-- Quantity input field --}}
        <input id="product-quantity-bsgs" class="rounded w-24" type="number" min="1" value="1">
    
        {{-- Search result --}}
        <div class="search-result-bsgs hidden bg-white border rounded-b
            absolute left-0 right-0 top-full z-30 shadow-md -mt-1">
            <div class="search-list-bsgs flex flex-col divide-y h-72 overflow-y-auto">
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        // For quantity
        var searchInput          = $('#input-product-search');
        var inputProductId       = $('#input-product-id');
        var inputProductName     = $('#input-product-name');
        var inputProductImageSRC = $('#input-product-image-src');
        var searchResult         = $('.search-result');
        var searchResultList     = $('.search-list');
        // For BSGS
        var searchInputBSGS          = $('#input-product-search-bsgs');
        var inputProductIdBSGS       = $('#input-product-id-bsgs');
        var inputProductNameBSGS     = $('#input-product-name-bsgs');
        var inputProductImageSRCBSGS = $('#input-product-image-src-bsgs');
        var searchResultBSGS         = $('.search-result-bsgs');
        var searchResultListBSGS     = $('.search-list-bsgs');

        var debounceTime             = 750;

        $(function() {
            // If click outside of the model search box hide the search result list
            $(document).click(function(e) {
                var container = $('.product-search-box');
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    searchResult.hide();
                }
            });
            // For BSGS
            $(document).click(function(e) {
                var container = $('.product-search-box_bsgs');
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    searchResultBSGS.hide();
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

            // For BSGS
            searchInputBSGS.keyup(__debounce(function(e) {
                var key = e.which;
                var searchKeywords = $(this).val();

                if (searchKeywords.length >= 3) {
                    productSearchBSGS(searchKeywords);
                    searchResultBSGS.show();
                }
                if (searchKeywords.length < 3) {
                    searchResultBSGS.hide();
                }
                // If press Enter key goto the product search page
                if (key == 13) // the enter key code
                {
                    window.location.href = `/products?search_key=${searchKeywords}`;
                }
            }, debounceTime));

            $('.search-list').on('click', '.search-item', function(e) {
                var productId           = $(this).data('product-id');
                var productName         = $(this).data('product-name');
                var productImageSRC     = $(this).data('product-image-src');

                inputProductId.val(productId);
                inputProductName.val(productName);
                inputProductImageSRC.val(productImageSRC);
                searchInput.val(productName);

                searchResult.hide();

            });

            $('.search-result-bsgs').on('click', '.search-item', function(e) {
                var productId           = $(this).data('product-id');
                var productName         = $(this).data('product-name');
                var productImageSRC     = $(this).data('product-image-src');

                searchInputBSGS.val(productName);
                inputProductIdBSGS.val(productId);
                inputProductNameBSGS.val(productName);
                inputProductImageSRCBSGS.val(productImageSRC);

                searchResultBSGS.hide();
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

        // For BSGS
        function productSearchBSGS(keywords) {
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
                    renderSearchResultBSGS(result);
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

        // For BSGS
        function renderSearchResultBSGS(data) {
            searchResultListBSGS.html('');
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

                searchResultListBSGS.append(itemHTML);
            }
            searchResultBSGS.show();
        }
    </script>
@endpush
