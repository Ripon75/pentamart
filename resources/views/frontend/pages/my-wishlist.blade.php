@extends('frontend.layouts.default')
@section('title', 'My-Wishlist')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            <div class="col-span-4">
                <div class="card p-0 sm:p-0 md:p-2 lg:p-4 xl:p-4 2xl:p-4">
                    <div class="w-full overflow-x-scroll">
                        <table class="table-auto w-full text-xs sm:text-xs md:text-sm">
                            <thead class="">
                                <tr class="bg-secondary">
                                    <th class="text-left border p-2 w-20">Image</th>
                                    <th class="text-left border p-2">Product</th>
                                    <th class="text-left border p-2">Brand</th>
                                    <th class="text-left border p-2">Category</th>
                                    <th class="text-center border p-2 w-40">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $data)
                                    @if ($data->product)
                                        <tr id="row-{{ $data->id }}">
                                            <td class="border p-1">
                                                <img class="w-10 h-10" src="{{ $data->product->image_src }}" alt="Product Image">
                                            </td>
                                            <td class="border p-1">{{ $data->product->name }}</td>
                                            <td class="border p-1">{{ ($data->product->category->name) ?? null }}</td>
                                            <td class="border p-1">{{ ($data->product->brand->name) ?? null }}</td>
                                            <td class="border p-1">
                                                <div class="flex space-x-2 justify-center">
                                                    <button>
                                                        <a href="{{ route('products.show',[$data->product->id, $data->product->slug]) }}" class="btn p-1">
                                                            {{-- <i class="fa-regular fa-eye"></i> --}}
                                                            Show
                                                        </a>
                                                    </button>
                                                    <button class="delete-cart-item-btn btn btn-sm btn-icon-only bg-red-500 hover:bg-red-700 text-white"
                                                        data-item-id="{{ $data->id }}">
                                                        <i class="loadding-icon text-xs fa-solid fa-spinner fa-spin mr-2"></i>
                                                        <i class="trash-icon text-xs text-white fa-regular fa-trash-can"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script>
        var deleteBtn    = $('.delete-cart-item-btn');
        var iconLoadding = $('.loadding-icon');
        var iconTrash    = $('.trash-icon');

        iconTrash.show()
        iconLoadding.hide();

        $(function() {
            deleteBtn.click(function() {
                var itemID = $(this).data('item-id');

                __removeWishlistItem(itemID, $(this));
            });
        });

        // --------------------------------------------
         // Remove single cart item
         // --------------------------------------------
         function __removeWishlistItem(itemID, btn) {
            btn.find(iconLoadding).show();
            btn.find(iconTrash).hide();

            axios.post('/my/wishlist/remove', {
                    item_id: itemID
                })
                .then(function (response) {
                    $(`#row-${itemID}`).remove()
                })
                .catch(function (error) {
                    btn.find(iconLoadding).hide();
                    btn.find(iconTrash).show();
                })
                .then(function () {
                    // always executed
                });
        }
         // Category Menu for User wishlist
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
