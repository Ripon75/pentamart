@extends('frontend.layouts.default')
@section('title', 'Products')
@section('content')
    <section class="page-section page-top-gap">
        <div class="container">
            <nav class="breadcrumb-wrapper mb-4">
                <ol class="list-reset">
                    <li class="item"><a href="/" class="item-link">Home</a></li>
                    <li class="item"><span class="divider">/</span></li>
                    <li class="last-item">Offer</li>
                </ol>
            </nav>
            <div class="grid grid-cols-4 gap-4 sm:gap-4 md:gap-8">
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
                {{-- ====toolbar===== --}}
                <div class="col-span-4 sm:col-span-4 md:col-span-4 lg:col-span-3 xl:col-span-3">
                    <div class="">
                        {{-- =====product thumb========== --}}
                        <div class="">
                            <div class="product-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-2 sm:gap-2 md:gap-2 lg:gap-2 xl:gap-2 2xl:gap-2">
                                @foreach ($products as $product)
                                <div>
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
    </section>
@endsection

@once
    @push('scripts')
    <script>
        // Category Menu for Medicine Corner
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
        var route     = "{{ route('offers.products') }}?page={{ $products->currentPage() }}";

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
        var onScrollProductRoute = "{{ route('offers.products', ['true']) }}";
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
