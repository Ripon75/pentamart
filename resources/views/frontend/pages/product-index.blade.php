@extends('frontend.layouts.default')
@section('title', 'Products')
@section('content')
    <section class="page-section page-top-gap">
        <div class="container">
            @if (!Request::get('search_key'))
                <nav class="breadcrumb-wrapper mb-4">
                    <ol class="list-reset">
                        <li class="item"><a href="/" class="item-link">Home</a></li>
                        <li class="item"><span class="divider">/</span></li>
                        <li class="last-item">All Product</li>
                    </ol>
                </nav>
            @endif
            <div class="grid grid-cols-4 gap-4 sm:gap-4 md:gap-8">
                {{-- Filter Column --}}
                <div id="filter-category" class=" col-span-4 sm:col-span-4 lg:col-span-1 hidden sm:hidden lg:block">
                    <div class="filter-card">

                        @if (count($brands))
                            <div class="filter-box">
                                <div class="box-wrapper">
                                    <span class="box-title">Subsidaries</span>
                                </div>
                                <div class="filter-list">
                                    @foreach ($brands as $brand)
                                        <label class="item">
                                            <input type="checkbox" name="brands[]" value="{{ $brand['id'] }}"
                                                class="focus:ring-0 input-checkbox"
                                                {{ in_array($brand['id'], $filterBrandIds) ? 'checked' : '' }} />
                                            <span class="ml-3 text-sm">{{ $brand->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (count($categories))
                            <div class="filter-box">
                                <div class="box-wrapper">
                                    <span class="box-title">Categories</span>
                                </div>
                                <div class="filter-list">
                                    @foreach ($categories as $category)
                                        <label class="item">
                                            <input type="checkbox" name="categories[]" value="{{ $category['id'] }}"
                                                class="focus:ring-0 input-checkbox"
                                                {{ in_array($category['id'], $filterCategoryIds) ? 'checked' : '' }} />
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
                            <div
                                class="product-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-2 sm:gap-2 md:gap-2 lg:gap-2 xl:gap-2 2xl:gap-2">
                                @foreach ($products as $product)
                                    <div class="">
                                        <x-frontend.product-thumb type="default" :product="$product" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

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
            // Toggle filter for Mobile menu
            function toggleFilter() {
                var filterCategory = document.getElementById('filter-category');
                if (filterCategory.style.display == "block") { // if is menuBox displayed, hide it
                    filterCategory.style.display = "none";
                } else { // if is menuBox hidden, display it
                    filterCategory.style.display = "block";
                }
            };

            var route = "{{ route('products.index') }}?page={{ $products->currentPage() }}";

            const filterInputBrands = $('input[name="brands[]"]');
            const filterInputCategories = $('input[name="categories[]"]');

            $(function() {
                filterInputCategories.on("click", (event) => {
                    filterProducts(route);
                });

                filterInputBrands.on("click", (event) => {
                    filterProducts(route);
                });
            });

            function filterProducts(route) {
                var selectedFilterCategoryIds = getFilterCategoryIds();
                var selectedFilterBrandIds = getFilterBrandIds();

                if (selectedFilterCategoryIds) {
                    route = `${route}&filter_category_ids=${selectedFilterCategoryIds}`;
                }
                if (selectedFilterBrandIds) {
                    route = `${route}&filter_brand_ids=${selectedFilterBrandIds}`;
                }
                window.location.href = route;
            }

            function getFilterCategoryIds() {
                var selectedCategoryIds = null;
                $.each($('input[name="categories[]"]:checked'), function() {
                    const id = $(this).val();
                    selectedCategoryIds = selectedCategoryIds ? `${selectedCategoryIds},${id}` : id;
                });
                return selectedCategoryIds;
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
    @endpush
@endonce
