@extends('frontend.layouts.default')
@section('title', 'My-Dashboard')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            {{-- =======List========= --}}
            <div class="col-span-1 hidden sm:hidden md:hidden lg:block xl:block 2xl:block">
                <x-frontend.customer-nav/>
            </div>
            {{-- =============== --}}
            <div class="col-span-1 sm:col-span-1 md:col-span-1 lg:col-span-3 xl:col-span-3 2xl:col-span-3">
                <div class="flex space-x-2 sm:space-x-2 md:space-x-2 lg:space-x-0 xl:space-x-0 2xl:space-x-0">
                    <div class="relative block sm:block md:block lg:hidden xl:hidden 2xl:hidden">
                        <button id="category-menu" onclick="menuToggleCategory()" class="h-[46px] w-14 bg-white flex items-center justify-center rounded border-2 ">
                            <i class="text-xl fa-solid fa-ellipsis-vertical"></i>
                        </button>
                          {{-- ===Mobile menu for dashboard===== --}}
                        <div id="category-list-menu" style="display: none" class="absolute left-0 w-60">
                            <x-frontend.customer-nav/>
                        </div>
                    </div>
                </div>
                <div class="card p-1 sm:p-1 md:p-2 lg:p-4 xl:p-4 2xl:p-4">
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-2 sm:gap-2 md:gap-2 lg:gap-4 xl:gap-4 2xl:gap-4">
                        <div class="card border flex-1 bg-sky-400 p-4">
                            <div class="">
                                <span class="text-primary font-medium">Total Order</span>
                            </div>
                            <div class="flex items-center space-x-2 mt-2">
                                <span class="text-primary h-8 w-8 rounded flex items-center justify-center text-xl"><i class="fa-solid fa-cart-plus"></i></span>
                                <span class="text-secondary text-lg font-medium">{{ count($orders) }}</span>
                            </div>
                        </div>
                        <div class="card border flex-1 bg-sky-400 p-4">
                            <div class="">
                                <span class="text-primary font-medium">Total Spend</span>
                            </div>
                            <div class="flex items-center space-x-2 mt-2">
                                <span class="text-primary h-8 w-8 rounded flex items-center justify-center text-xl"><i class="fa-regular fa-money-bill-1"></i></span>
                                <span class="text-secondary text-lg font-medium">
                                    {{ number_format($totalAmount, 2) }} Tk.
                                </span>
                            </div>
                        </div>
                        <div class="hidden card border flex-1 bg-sky-400 p-4">
                            <div class="">
                                <span class="text-primary font-medium">Total Point</span>
                            </div>
                            <div class="flex items-center space-x-2 mt-2">
                                <span class="text-primary h-8 w-8 rounded flex items-center justify-center text-xl"><i class="fa-regular fa-sun"></i></span>
                                <span class="text-secondary text-lg font-medium">550</span>
                            </div>
                        </div>
                        <div class="hidden card border flex-1 bg-sky-400 p-4">
                            <div class="">
                                <span class="text-primary font-medium">Total Reviews</span>
                            </div>
                            <div class="flex items-center space-x-2 mt-2">
                                <span class="text-primary h-8 w-8 rounded flex items-center justify-center text-xl"><i class="fa-solid fa-user-pen"></i></span>
                                <span class="text-secondary text-lg font-medium">7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>

    // Category Menu for User Dashboard
    function menuToggleCategory() {
        var categoryList = document.getElementById('category-list-menu');
        if(categoryList.style.display == "none") { // if is menuBox displayed, hide it
            categoryList.style.display = "block";
        }
        else { // if is menuBox hidden, display it
            categoryList.style.display = "none";
        }
    }
</script>
@endpush
