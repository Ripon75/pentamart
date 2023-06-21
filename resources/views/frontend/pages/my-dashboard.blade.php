@extends('frontend.layouts.default')
@section('title', 'My-Dashboard')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            <div class="col-span-3">
                <div class="card p-4">
                    <div class="flex space-x-2 w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2 mx-auto">
                        <div class="card border flex-1 bg-sky-400 p-4">
                            <div class="">
                                <span class="text-primary font-medium">Total Order</span>
                            </div>
                            <div class="flex items-center space-x-2 mt-2">
                                <span class="text-primary h-8 w-8 rounded flex items-center justify-center text-xl"><i class="fa-solid fa-cart-plus"></i></span>
                                <span class="text-secondary text-lg font-medium">{{ $orders }}</span>
                            </div>
                        </div>
                        <div class="card border flex-1 bg-sky-400 p-4">
                            <div class="">
                                <span class="text-primary font-medium">Total Spend</span>
                            </div>
                            <div class="flex items-center space-x-2 mt-2">
                                <span class="text-primary h-8 w-8 rounded flex items-center justify-center text-xl"><i class="fa-regular fa-money-bill-1"></i></span>
                                <span class="text-secondary text-lg font-medium">
                                    {{ number_format($ordersValue, 2) }} Tk.
                                </span>
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
