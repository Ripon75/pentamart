@extends('frontend.layouts.default')
@section('title', 'Products')
@section('content')
    <section class="page-section page-top-gap">
        <div class="container">
            <div class="grid grid-cols-4 gap-8">
                {{-- Filter Column --}}
                <div id="filter-category" class="col-span-4 sm:col-span-4 lg:col-span-1 hidden sm:hidden lg:block">
                    <div class="filter-card">
                        @if (count($categories))
                            <div class="filter-box">
                                <div class="box-wrapper">
                                <span class="box-title">Categories</span>
                                </div>
                                <div class="filter-list">
                                    @foreach ($categories as $category)
                                    <label class="item">
                                        <input
                                            type="checkbox"
                                            name="categories[]"
                                            value="{{ $category->id }}"
                                            class="focus:ring-0 input-checkbox"
                                            {{ in_array($category->id, $filterCategoryIds) ? 'checked' : '' }}/>
                                        <span class="ml-3 text-sm">{{ $category->name }}</span>
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
                            <div class="product-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-2 sm:gap-2 md:gap-2 lg:gap-2 xl:gap-2 2xl:gap-2">
                                @foreach ($products as $product)
                                <div class="">
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
         // Toggle filter for Mobile menu brands
        function toggleFilter() {
            var filterCategory = document.getElementById('filter-category');
            if(filterCategory.style.display == "block") { // if is menuBox displayed, hide it
                filterCategory.style.display = "none";
            }
            else { // if is menuBox hidden, display it
                filterCategory.style.display = "block";
            }
        };

        var searchKey = '{{ request()->get('search_key') ?? '' }}';
        var route     = "{{ route('brand.page', $id) }}?page={{ $products->currentPage() }}";

        if (searchKey) {
            route = `${route}&search_key=${searchKey}`;
        }

        const filterInputOrder        = $("#input-short-order");
        const filterInputCategories   = $('input[name="categories[]"]');

        $(function() {
            filterInputOrder.on("change", (event) => {
                filterProducts(route);
            });

            filterInputCategories.on("click", (event) => {
                filterProducts(route);
            });
        });

        function filterProducts(route) {
            var selectedFilterCategoryIds = getFilterCategoryIds();
            var order                     = filterInputOrder.val();

            if (order) {
                route = `${route}&order=${order}`;
            }
            if (selectedFilterCategoryIds) {
                route = `${route}&filter_category_ids=${selectedFilterCategoryIds}`;
            }
            window.location.href = route;
        }

        function getFilterCategoryIds() {
            var selectedCategoryIds = null;
            $.each($('input[name="categories[]"]:checked'), function() {
                const id = $(this).val();
                selectedCategoryIds = selectedCategoryIds ? `${selectedCategoryIds},${id}` : id ;
            });
            return selectedCategoryIds;
        }
    </script>

    {{-- On scroll product load --}}
    <script>
        // var onScrollProductRoute = "{{ route('brand.page', [$id, 'true']) }}";
        // var productLoddingIcon = $('#product-loading-icon').hide();
        // var order = "{{ request()->query('order') }}";
        // var currentPage = {{ $products->currentPage() }};
        // var lastPage = {{ $products->lastPage() }};
        // var canCall = true;
        // currentPage++;

        $(window).on('scroll', function() {
            // if (currentPage <= lastPage && canCall) {
            //     var scrollLeft = $(document).height() - $(window).scrollTop();
            //     if (scrollLeft <= 1200) {
            //         productLoddingIcon.show();
            //         getProductThumbsOnScroll();
            //     }
            // }
        });

        // function getProductThumbsOnScroll() {
        //     canCall = false;
        //     axios.get(onScrollProductRoute, {
        //         params: {
        //             page: currentPage,
        //             order: order
        //         }
        //     })
        //     .then((response) => {
        //         var products = response.data;
        //         $('.product-grid').append(products);
        //         currentPage++;
        //         canCall = true;
        //         productLoddingIcon.hide();
        //     })
        //     .catch((error) => {
        //         console.log(error);
        //     });
        // }
    </script>
    @endpush
@endonce
