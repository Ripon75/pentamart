@extends('frontend.layouts.default')
@section('title', 'Products')
@section('content')
    <section class="page-section page-top-gap">
        <div class="container">
            <nav class="breadcrumb-wrapper mb-4">
                <ol class="list-reset">
                    <li class="item"><a href="/" class="item-link">Home</a></li>
                    <li class="item"><span class="divider">/</span></li>
                    <li class="last-item">{{ $pageTitle }}</li>
                </ol>
            </nav>
            <div class="grid grid-cols-4 gap-8">
                {{-- Filter Column --}}
                <div id="category-filter" class="col-span-4 sm:col-span-4 lg:col-span-1 hidden sm:hidden lg:block">
                    <div class="filter-card">
                        @if (count($brands))
                            <div class="filter-box">
                                <div class="box-wrapper">
                                    <span class="box-title">Brand</span>
                                </div>
                                <div class="filter-list">
                                    @foreach ($brands as $brand)
                                        <label class="item">
                                            <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                                                class="focus:ring-0 input-checkbox"
                                                {{ in_array($brand->id, $filterBrandIds) ? 'checked' : '' }} />
                                            <span class="ml-3 text-sm">{{ $brand->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ====toolbar===== --}}
                <div class="col-span-4 sm:col-span-4 md:col-span-4 lg:col-span-3 xl:col-span-3">
                    <div class="">
                        {{-- =====product thumb========== --}}
                        <div class="">
                            <div
                                class="product-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-2 sm:gap-2 md:gap-2 lg:gap-2 xl:gap-2 2xl:gap-2">
                                @foreach ($products as $product)
                                    <div>
                                        <x-frontend.product-thumb type="default" :product="$product" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- ========Scroll============ --}}
                    {{-- <div class="flex items-center justify-center mt-8">
                        <i id="product-loading-icon" class="text-4xl fa-solid fa-spinner fa-spin mr-2"></i>
                    </div> --}}
                    {{-- ========Pagination============ --}}
                    @if ($products->hasPages())
                        <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                            {{ $products->appends(request()->input())->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@once
    @push('scripts')
        <script>
            // Category Menu for Medicine Corner
            function toggleFilter() {
                var filterCategory = document.getElementById('category-filter');
                if (filterCategory.style.display == "block") { // if is menuBox displayed, hide it
                    filterCategory.style.display = "none";
                } else { // if is menuBox hidden, display it
                    filterCategory.style.display = "block";
                }
            };

            var searchKey = '{{ request()->get('search_key') ?? '' }}';
            var route = "{{ route('category.page', $id) }}?page={{ $products->currentPage() }}";

            if (searchKey) {
                route = `${route}&search_key=${searchKey}`;
            }

            // const filterInputOrder     = $("#input-short-order");
            const filterInputBrands = $('input[name="brands[]"]');

            $(function() {
                // filterInputOrder.on("change", (event) => {
                //     filterProducts(route);
                // });

                filterInputBrands.on("click", (event) => {
                    filterProducts(route);
                });
            });

            function filterProducts(route) {
                var selectedFilterBrandIds = getFilterBrandIds();
                // var order = filterInputOrder.val();

                // if (order) {
                //     route = `${route}&order=${order}`;
                // }
                if (selectedFilterBrandIds) {
                    route = `${route}&filter_brand_ids=${selectedFilterBrandIds}`;
                }
                window.location.href = route;
            }

            function getFilterBrandIds() {
                var selectedBrandIds = null;
                $.each($('input[name="brands[]"]:checked'), function() {
                    const id = $(this).val();
                    selectedBrandIds = selectedBrandIds ? `${selectedBrandIds},${id}` : id;
                });
                return selectedBrandIds;
            }
        </script>

        {{-- On scroll product load --}}
        {{-- <script>
        var onScrollProductRoute = "{{ route('category.page', [$slug, 'true']) }}";
        var order = "{{ request()->query('order') }}";
        var currentPage = {{ $products->currentPage() }};
        var lastPage = {{ $products->lastPage() }};
        var productLoddingIcon = $('#product-loading-icon').hide();
        var canCall = true;
        currentPage++;

        $(window).on('scroll', function() {
            if (currentPage <= lastPage && canCall) {
                var scrollLeft = $(document).height() - $(window).scrollTop();
                if (scrollLeft <= 1200) {
                    productLoddingIcon.show();
                    getProductThumbsOnScroll();
                }
            }
        });

        function getProductThumbsOnScroll() {
            canCall = false;
            axios.get(onScrollProductRoute, {
                params: {
                    page: currentPage,
                    order: order
                }
            })
            .then((response) => {
                var products = response.data;
                $('.product-grid').append(products);
                currentPage++;
                canCall = true;
                productLoddingIcon.hide();
            })
            .catch((error) => {
                console.log(error);
            });
        }
    </script> --}}
    @endpush
@endonce
