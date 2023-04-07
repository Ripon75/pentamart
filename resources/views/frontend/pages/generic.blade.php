@extends('frontend.layouts.default')
@section('title', 'Generics')
@section('content')

    <!--========Category Banner========-->
    <section>
        <x-frontend.header-title
            height="250px"
            bgColor="linear-gradient( #112f7a, rgba(111, 111, 211, 0.52))"
            bgImageSrc="/images/banners/home-banner.jpg"
            :title="$generic->name"
        />
    </section>

    <section class="page-section">
        <div class="container">
            <div class="grid grid-cols-4 gap-8">
                {{-- Filter Column --}}
                <div class="col-span-1 hidden sm:hidden md:hidden lg:block xl:block">
                    <div class="filter-card">
                        <div class="title-wrapper">
                            <h1 class="title">Filter By</h1>
                        </div>

                        @if (count($categories))
                            <div class="filter-box">
                                <div class="box-wrapper">
                                <span class="box-title">Categories<i class="fa-solid fa-angle-down"></i></span>
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

                        @if (count($companies))
                            <div class="filter-box">
                                <div class="box-wrapper">
                                <span class="box-title">Manufacturer</span>
                                </div>
                                <div class="filter-list">
                                    @foreach ($companies as $company)
                                    <label class="item">
                                        <input
                                            type="checkbox"
                                            name="companies[]"
                                            value="{{ $company->id }}"
                                            class="focus:ring-0 input-checkbox"
                                            {{ in_array($company->id, $filterCompanyIds) ? 'checked' : '' }}/>
                                        <span class="ml-3 text-sm">{{ $company->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (count($dosageForms))
                            <div class="filter-box">
                                <div class="box-wrapper">
                                <span class="box-title">Dosage Forms</span>
                                </div>
                                <div class="filter-list">
                                    @foreach ($dosageForms as $dosageForm)
                                    <label class="item">
                                        <input
                                            type="checkbox"
                                            name="dosageForms[]"
                                            value="{{ $dosageForm->id }}"
                                            class="focus:ring-0 input-checkbox"
                                            {{ in_array($dosageForm->id, $filterDosageFormIds) ? 'checked' : '' }}/>
                                        <span class="ml-3 text-sm">{{ $dosageForm->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-span-4 sm:col-span-4 md:col-span-4 lg:col-span-3 xl:col-span-3">
                    <div class="">
                        {{-- ====toolbar===== --}}
                        <div class="toolbar border-b mb-8 h-12 flex justify-between items-center">
                            <div class="flex items-center">
                                <button class="block sm:block md:block lg:hidden xl:hidden bg-gray-200 border border-gray-300 h-8 w-8 rounded mr-3">
                                   <i class="fa-solid fa-filter"></i>
                               </button>
                               {{-- <span class="text-gray-800 text-sm">
                                {!! __('Showing') !!}
                                @if ($products->firstItem())
                                    <span class="font-medium">{{ $products->firstItem() }}</span>
                                    {!! __('to') !!}
                                    <span class="font-medium">{{ $products->lastItem() }}</span>
                                @else
                                    {{ $products->count() }}
                                @endif
                                {!! __('of') !!}
                                <span class="font-medium">{{ $products->total() }}</span>
                                {!! __('results') !!}
                            </span> --}}
                            </div>
                            <div class="flex space-x-2 items-center">
                                <span class="hidden sm:hidden md:block text-gray-800 text-sm">Sort by</span>
                                <select id="input-short-order" class="h-8 border border-gray-300 rounded bg-gray-200 text-xs">
                                    <option value="asc" {{ request()->get('order') === 'asc' ? "selected" : '' }}>Low to High</option>
                                    <option value="desc" {{ request()->get('order') === 'desc' ? "selected" : '' }}>High to Low</option>
                                </select>
                            </div>
                        </div>

                        {{-- ====toolbar===== --}}
                        <div class="col-span-4 sm:col-span-4 md:col-span-4 lg:col-span-3 xl:col-span-3">
                            <div class="">
                                {{-- =====product thumb========== --}}
                                <div class="">
                                    <div class="product-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-2 sm:gap-2 md:gap-2 lg:gap-2 xl:gap-2 2xl:gap-2">
                                        @foreach ($products as $product)
                                        <div data-aos="fade-up" data-aos-anchor-placement="top-bottom" class="">
                                            <x-frontend.product-thumb type="default" :product="$product" />
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-center mt-8">
                                <i id="product-loading-icon" class="text-4xl fa-solid fa-spinner fa-spin mr-2"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@once
    @push('scripts')
    <script>

        var slug      = '{{ $slug }}'
        var searchKey = '{{ request()->get('search_key') ?? '' }}';
        var route     = "{{ route('generics.show', [$slug]) }}?page={{ $products->currentPage() }}";

        if (searchKey) {
            route = `${route}&search_key=${searchKey}`;
        }

        const filterInputOrder        = $("#input-short-order");
        const filterInputCategories   = $('input[name="categories[]"]');
        const filterInputCompanies    = $('input[name="companies[]"]');
        const filterInputDosageForms  = $('input[name="dosageForms[]"]');

        $(function() {

            filterInputOrder.on("change", (event) => {
                filterProducts(route);
            });

            filterInputCategories.on("click", (event) => {
                filterProducts(route);
            });

            filterInputCompanies.on("click", (event) => {
                filterProducts(route);
            });

            filterInputDosageForms.on("click", (event) => {
                filterProducts(route);
            });
        });

        function filterProducts(route) {
            var selectedFilterCategoryIds   = getFilterCategoryIds();
            var selectedFilterCompanyIds    = getFilterCompanyIds();
            var selectedFilterDosageFormIds = getFilterDosageFormIds();
            var order                       = filterInputOrder.val();

            if (order) {
                route = `${route}&order=${order}`;
            }
            if (selectedFilterCategoryIds) {
                route = `${route}&filter_category_ids=${selectedFilterCategoryIds}`;
            }
            if (selectedFilterCompanyIds) {
                route = `${route}&filter_company_ids=${selectedFilterCompanyIds}`;
            }
            if (selectedFilterDosageFormIds) {
                route = `${route}&filter_dosageForm_ids=${selectedFilterDosageFormIds}`;
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

        function getFilterCompanyIds() {
            var selectedCompanyIds = null;
            $.each($('input[name="companies[]"]:checked'), function() {
                const id = $(this).val();
                selectedCompanyIds = selectedCompanyIds ? `${selectedCompanyIds},${id}` : id ;
            });
            return selectedCompanyIds;
        }

        function getFilterDosageFormIds() {
            var selectedDosageFormIds = null;
            $.each($('input[name="dosageForms[]"]:checked'), function() {
                const id = $(this).val();
                selectedDosageFormIds = selectedDosageFormIds ? `${selectedDosageFormIds},${id}` : id ;
            });
            return selectedDosageFormIds;
        }
    </script>

    {{-- On scroll product load --}}
    <script>
        var onScrollProductRoute = "{{ route('generics.show', [$slug, 'true']) }}";
        var productLoddingIcon = $('#product-loading-icon').hide();
        var order = "{{ request()->query('order') }}";
        var currentPage = {{ $products->currentPage() }};
        var lastPage = {{ $products->lastPage() }};
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
    </script>
    @endpush
@endonce
