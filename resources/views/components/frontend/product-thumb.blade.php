@if ($type === 'default')
    <div data-aos="fade-up" data-aos-anchor-placement="top-bottom"  class="product-thumb block h-full bg-white rounded-md transition duration-150">
        <div class="rounded-md border-2 h-full">
            <div class="relative">
                <div class="absolute top-0 right-0 p-2 z-20">
                    @if ($product->offer_price > 0)
                        <span
                            class="pt-[2px] px-2 bg-red-500 text-white text-sm text-center inline-block align-middle rounded shadow-md">-
                            {{ number_format($product->offer_percent, 0) }}
                            <span>%</span>
                        </span>
                    @endif
                </div>
                <div class="absolute bottom-0 pl-2 z-20">
                    <div class="flex space-x-2">
                        <div class="">
                            @if ($product->current_stock)
                                <span
                                    class="bg-green-100 text-green-500 text-xs sm:text-xs md:text-xs text-center inline-block align-middle rounded px-2 py-0.5">
                                    In Stock
                                </span>
                            @else
                                <span
                                    class = "bg-red-50 text-red-500 text-xs sm:text-xs md:text-xs text-center inline-block align-middle rounded px-2 py-0.5">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="thumb-image-wrapper aspect-w-1 aspect-h-1">
                    @if ($product->img_src)
                    <a class="p-2 sm:p-2 md:p-6 lg:p-6 xl:p-8 2xl:p-8" href="{{ route('products.show', [$product->id, $product->slug]) }}">
                        <img class="rounded-t-md w-full h-full object-fill max-w-xs hover:scale-110 transition duration-300 ease-in-out"
                            src="{{ $product->img_src }}" />
                    </a>
                    @endif
                </div>
            </div>

            <div class="content px-3 py-2 bg-gray-50 rounded-b-md flex-1">
                {{-- @if ($product->brand_id)
                    <a href="{{ route('brand.page', [$product->brand_id, $product->brand->slug ?? '']) }}" class="block h-6 pt-1 text-xs text-gray-400 line-clamp-1">
                        {{ $product->brand->name }}
                    </a>
                @else
                <div class="h-6"></div>
                @endif --}}

                @if ($product->name)
                    <a href="{{ route('products.show', [$product->id, $product->slug]) }}" class="block h-5 font-medium text-primary text-sm line-clamp-2" title="{{ $product->name }}">
                        {{ $product->name }}
                    </a>
                @else
                    <div class="h-5"></div>
                @endif

                @if ($product->category_id)
                    <a href="{{ route('category.page', [$product->category_id, $product->category->slug ?? '']) }}" class="block h-4 line-clamp-1 text-gray-600 text-xs font-medium italic" title="{{ $product->category->name }}">
                        {{ $product->category->name }}
                    </a>
                @endif
                {{-- Price show for type default --}}
                <div class="prices mt-1 text-xs sm:text-xs md:text-sm lg:text-base xl:text-base 2xl:text-base flex space-x-4">
                    @php
                        $productPrice      = $product->mrp;
                        $productOfferPrice = $product->offer_price;
                    @endphp
                    @if ($product->offer_price > 0)
                        <span>
                            {{ $currency }}
                            <span id="header-product-price-label-{{ $product->id }}" class="text-primary">
                                {{ $productOfferPrice }}
                            </span>
                        </span>
                        <span id="header-product-mrp-label-{{ $product->id }}" class="line-through text-gray-500 self-end">
                            {{ $currency }} {{ $productPrice }}
                        </span>
                    @else
                        <span>
                            {{ $currency }}
                            <span id="header-product-price-label-{{ $product->id }}" class="text-primary">
                                {{ $productPrice }}
                            </span>
                            <span id="header-product-mrp-label-{{ $product->id }}" class="line-through text-gray-500 self-end">
                            </span>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@elseif ($type === 'list')
    <div class="border-b last:border-b-0">
        <a href="#" class="block">
            <div class="flex items-center">
                <div class="thumb-image-wrapper w-28 h-28 p-2">
                    <img class="w-full h-full object-center object-cover"
                        src="{{ $product->img_src }}" />
                </div>
                <div class="content px-3 py-2 flex-1">
                    {{-- Show brand name --}}
                    @if ($product->brand_id)
                        <a href="{{ route('brand.page', [$product->brand_id, $product->brand->slug ?? '']) }}" class="block text-xs text-gray-400">{{ $product->brand->name }}</a>
                    @endif
                    {{-- Show product name --}}
                    <a href="{{ route('products.show', [$product->id, $product->slug]) }}" class="block text-primary text-base md:text-sm lg:text-sm xl:text-base font-medium">
                        {{ $product->name }}
                    </a>

                    {{-- Show category name --}}
                    @if ($product->category_id)
                        <a href="{{ route('category.page', [$product->category_id, $product->category->slug]) }}" class="block text-gray-600 text-xs font-medium italic">
                            {{ $product->category->name ?? null }}
                        </a>
                    @endif

                    {{-- Price show --}}
                    <div class="prices mt-2 flex space-x-4">
                        @if ($product->offer_price > 0)
                        <span class="text-primary text-sm">{{ $currency }} {{ $product->offer_price }}</span>
                        <span class="line-through text-sm text-gray-500 self-end">{{ $currency }} {{ $product->mrp }}</span>
                        @else
                        <span class="text-primary">{{ $currency }} {{ $product->mrp }}</span>
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
                    src="{{ $product->img_src }}">
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
