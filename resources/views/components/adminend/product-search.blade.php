<div class="product-search-box relative">
    {{-- Hidden field --}}
    <input id="input-product-id" type="hidden">
    <input id="input-product-name" type="hidden">
    <input id="input-product-img-src" type="hidden">
    <input id="input-product-buy-price" type="hidden">
    <input id="input-product-mrp" type="hidden">
    <input id="input-product-offer-price" type="hidden">
    <input id="input-brand-name" type="hidden">
    <input id="input-category-name" type="hidden">
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
        var debounceTime           = 750;
        var searchInput            = $('#input-product-search');
        var inputProductId         = $('#input-product-id');
        var inputProductName       = $('#input-product-name');
        var inputProductImgSRC     = $('#input-product-img-src');
        var inputProductBuyPrice   = $('#input-product-buy-price');
        var inputProductMRP        = $('#input-product-mrp');
        var inputProductOfferPrice = $('#input-product-offer-price');
        var searchResult           = $('.search-result');
        var searchResultList       = $('.search-list');
        var searchItem             = $('.search-item');

        $(function() {
            // If click outside of the model search box hide the search result list
            $(document).click(function(e) {
                var container = $('.product-search-box');
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    searchResult.hide();
                }
            });

            // Product search
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
                var productId         = $(this).data('product-id');
                var productName       = $(this).data('product-name');
                var productImgSRC     = $(this).data('product-img-src');
                var productBuyPrice   = $(this).data('product-buy-price');
                var productMRP        = $(this).data('product-mrp');
                var productOfferPrice = $(this).data('product-offer-price');

                inputProductId.val(productId);
                inputProductName.val(productName);
                inputProductImgSRC.val(productImgSRC);
                inputProductBuyPrice.val(productBuyPrice);
                inputProductMRP.val(productMRP);
                inputProductOfferPrice.val(productOfferPrice);
                searchInput.val(productName);

                searchResult.hide();
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
                const product      = data[index];
                var   brandName    = product.brand ? product.brand.name : '';
                var   categoryName = product.category ? product.category.name : '';

                var itemHTML = `
                    <div
                        class="search-item hover:bg-gray-200 transition duration-150 ease-in-out border-b border-dashed flex space-x-2 p-2 pr-3 items-center" data-product-id="${product.id}"
                        data-product-id="${product.id}"
                        data-product-name="${product.name}"
                        data-product-img-src="${product.img_src}"
                        data-product-buy-price="${product.buy_price}"
                        data-product-mrp="${product.mrp}"
                        data-product-offer-price="${product.offer_price}">

                        <div class="w-14 h-14">
                            <img class="w-full h-full" src="${product.img_src}" alt="">
                        </div>
                        <div class="flex-1 flex flex-col">
                            <h4 class="text-xs text-gray-500">${brandName}</h4>
                            <h2 class="text-base text-primary">${product.name}</h2>
                            <span class="text-xxs text-gray-500">${categoryName}</span>
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
