@if ($type === 'default')
    <div data-aos="fade-up" data-aos-anchor-placement="top-bottom"  class="product-thumb block h-full bg-white rounded-md transition duration-150">
        <div class="rounded-md border-2 h-full">
            <div class="relative">
                <div class="absolute top-0 right-0 p-2 z-20">
                    @if ($product->selling_price > 0)
                    @php
                        $mrp            = $product->mrp;
                        $discountAmount = $product->mrp - $product->selling_price;

                        $discountPercent = ($discountAmount/$mrp) * 100
                    @endphp
                    <span
                        class="pt-[2px] px-2 bg-red-500 text-white text-sm text-center inline-block align-middle rounded shadow-md">-
                        {{ number_format($discountPercent, 0) }}
                        <span>%</span>
                    </span>
                    @endif
                </div>
                <div class="absolute bottom-0 pl-2 z-20">
                    <div class="flex space-x-2">
                        <div class="">
                            <span
                                class="bg-green-100 text-green-500 text-xs sm:text-xs md:text-xs text-center inline-block align-middle rounded px-2 py-0.5">
                                In Stock
                            </span>
                            {{-- <span
                                class="bg-red-50 text-red-500 text-xs sm:text-xs md:text-xs text-center inline-block align-middle rounded px-2 py-0.5">
                                Out of Stock
                            </span> --}}
                        </div>
                    </div>
                </div>
                <div class="thumb-image-wrapper aspect-w-1 aspect-h-1">
                    @if ($product->image_src)
                    <a class="p-2 sm:p-2 md:p-6 lg:p-6 xl:p-8 2xl:p-8" href="{{ route('products.show', [$product->id, $product->slug]) }}">
                        <img class="rounded-t-md w-full h-full object-fill max-w-xs hover:scale-110 transition duration-300 ease-in-out"
                            src="{{ $product->image_src }}" />
                    </a>
                    @endif
                </div>
            </div>

            <div class="content px-3 py-2 bg-gray-50 rounded-b-md flex-1">
                @if ($product->dosageForm)
                    <a href="{{ route('dosage-forms.show', $product->dosageForm->slug) }}" class="block h-6 pt-1 text-xs text-gray-400 line-clamp-1">
                        {{ $product->dosageForm->name }} Brand
                    </a>
                @else
                <div class="h-6"></div>
                @endif

                @if ($product->name)
                    <a href="{{ route('products.show', [$product->id, $product->slug]) }}" class="block h-10 font-medium text-primary text-sm line-clamp-2" title="{{ $product->name }}">
                        {{ $product->name }}
                    </a>
                @else
                    <div class="h-10"></div>
                @endif

                @if ($product->generic)
                    <a href="{{ route('generics.show', $product->generic->slug) }}" class="block h-4 line-clamp-1 text-gray-600 text-xs font-medium italic" title="{{ $product->generic->name }}">
                        Category
                    </a>
                @endif
                {{-- Price show for type default --}}
                <div class="prices mt-1 text-xs sm:text-xs md:text-sm lg:text-base xl:text-base 2xl:text-base flex space-x-4">
                    @php
                        $productMRP          = 0;
                        $productSellingPrice = 0;
                        $productMRP          = $product->mrp;
                        $productSellingPrice = $product->selling_price;
                    @endphp
                    @if ($product->selling_price > 0)
                        <span>
                            {{ $currency }}
                            <span id="header-product-price-label-{{ $product->id }}" class="text-secondary">
                                {{ $productSellingPrice }}
                            </span>
                        </span>
                        <span id="header-product-mrp-label-{{ $product->id }}" class="line-through text-gray-500 self-end">
                            {{ $currency }} {{ $productMRP }}
                        </span>
                    @else
                        <span>
                            {{ $currency }}
                            <span id="header-product-price-label-{{ $product->id }}" class="text-secondary">
                                {{ $productMRP }}
                            </span>
                            <span id="header-product-mrp-label-{{ $product->id }}" class="line-through text-gray-500 self-end">
                            </span>
                        </span>
                    @endif
                </div>
                {{-- <div data-test="test-div" class="qty-div flex space-x-2 items-center mt-1">
                    <div class="flex-1">
                        <select data-test="test-select" class="selected-pack rounded w-full text-xs"
                            data-header-product-mrp="{{ $product->mrp }}"
                            data-header-product-selling-price="{{ $product->selling_price }}"
                            data-header-product-id="{{ $product->id }}">
                            @if ($product->is_single_sell_allow)
                                @for ($i = 1 ; $i <= $product->num_of_pack ; $i++)
                                    <option
                                        value="{{ $i }}">
                                        {{ $i }} {{ $product->uom }}
                                    </option>
                                @endfor
                            @else
                                @for ($i = 1 ; $i <= $product->num_of_pack ; $i++)
                                    <option
                                        value="{{ $i * $product->pack_size }}">
                                        {{ $i * $product->pack_size }} {{ $product->uom }}
                                    </option>
                                @endfor
                            @endif
                        </select>
                    </div>
                    <div>
                        <button data-product-id="{{ $product->id }}"
                            data-mc-on-previous-url="{{ url()->current() }}"
                            @guest data-bs-toggle="modal" data-bs-target="#loginModalCenter" @endguest
                            class="btn-add-to-cart h-[34px] flex items-center justify-center text-xs sm:text-xs md:text-base lg:text-base xl:text-base 2xl:text-base bg-primary whitespace-nowrap px-4 text-white rounded w-full">
                            <i style="display: none" class="loadding-icon fa-solid fa-spinner fa-spin mr-2"></i>
                            <span class="hidden sm:hidden md:block lg:block xl:block 2xl:block">
                                <i class="add-to-cart-icon fa-solid fa-cart-plus mr-2"></i>
                            </span>
                            Add
                        </button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@elseif ($type === 'list')
    <div class="border-b last:border-b-0">
        <a href="#" class="block">
            <div class="flex items-center">
                <div class="thumb-image-wrapper w-28 h-28 p-2">
                    <img class="w-full h-full object-center object-cover"
                        src="{{ $product->image_src }}" />
                </div>
                <div class="content px-3 py-2 flex-1">
                    @if ($product->dosageForm)
                        <a href="{{ route('dosage-forms.show', $product->dosageForm->slug) }}" class="block text-xs text-gray-400">{{ $product->dosageForm->name }}</a>
                    @endif
                    <a href="{{ route('products.show', [$product->id, $product->slug]) }}" class="block text-primary text-base md:text-sm lg:text-sm xl:text-base font-medium">
                        {{ $product->name }}
                    </a>

                    {{-- Show comapany name --}}
                    @if ($product->company_id)
                        <a href="{{ route('companies.show', $product->company->slug) }}" class="block text-gray-600 text-xs font-medium italic">
                            {{ $product->company->name ?? null }}
                        </a>
                    @else
                        @if ($product->brand && $product->brand->company)
                            <a href="{{ route('companies.show', $product->brand->company->slug) }}" class="block text-gray-600 text-xs font-medium italic">
                                {{ $product->brand->company->name }}
                            </a>
                        @endif
                    @endif

                    {{-- Price show --}}
                    <div class="prices mt-2 flex space-x-4">
                        @if ($product->selling_price > 0)
                        <span class="text-secondary text-sm">{{ $currency }} {{ $product->selling_price }}</span>
                        <span class="line-through text-sm text-gray-500 self-end">{{ $currency }} {{ $product->mrp }}</span>
                        @else
                        <span class="text-secondary">{{ $currency }} {{ $product->mrp }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
@else
    <div class="block border rounded-md shadow bg-gray-50">
        <div class="product-thumb">
            <div class="aspect-w-1 aspect-h-1">
                <img class="rounded-t-md w-full h-full object-center object-cover"
                    src="{{ $product->image_src }}">
            </div>
            <div
                class="text-center p-4 rounded-b-md bg-gray-50 text-primary-dark hover:text-primary-dark">
                <a href="{{ route('products.show', [$product->id, $product->slug]) }}" class="inline-block text-sm font-medium">{{ $product->name  }}</a>
                <h2 class="text-sm">{{ $currency }} {{ $product->mrp }} </h2>
            </div>
        </div>
    </div>
@endif

@once
@push('scripts')
<script>
    AOS.init();
</script>
@endpush
@endonce
