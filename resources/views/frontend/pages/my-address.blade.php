@extends('frontend.layouts.default')
@section('title', 'My-Address')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            {{-- =======List========= --}}
            <div class="col-span-1 hidden sm:hidden md:hidden lg:block xl:block 2xl:block">
                <x-frontend.customer-nav/>
            </div>
            {{-- =============== --}}
            <div class="col-span-3">
                <div class="flex space-x-2 sm:space-x-2 md:space-x-2 lg:space-x-0 xl:space-x-0 2xl:space-x-0">
                    <div class="relative block sm:block md:block lg:hidden xl:hidden 2xl:hidden">
                        <button id="category-menu" onclick="menuToggleCategory()" class="h-[46px] w-14 bg-white flex items-center justify-center rounded border-2 ">
                            <i class="text-xl fa-solid fa-ellipsis-vertical"></i>
                        </button>
                          {{-- ===Mobile menu for order===== --}}
                        <div id="category-list-menu" style="display: none" class="absolute left-0 w-60">
                            <x-frontend.customer-nav/>
                        </div>
                    </div>
                    <div class="mb-4 flex-1">
                        <x-frontend.header-title
                            type="else"
                            title="Address"
                            bgImageSrc=""
                            bgColor="#102967"
                        />
                    </div>
                </div>
                <div class="card p-0 sm:p-0 md:p-2 lg:p-4 xl:p-4 2xl:p-4">
                    <div class="mb-4 text-right">
                        <a href="{{ route('my.address.create') }}">
                            <button title="Add Address" class="btn btn-md btn-secondary">Add Address</button>
                        </a>
                    </div>
                    <div class="w-full overflow-x-scroll">
                        <table class="table-auto w-full text-xs sm:text-xs md:text-sm">
                            <thead class="">
                                <tr class="bg-gray-100">
                                    <th class="text-left border p-2">Title</th>
                                    <th class="text-left border p-2">Address</th>
                                    <th class="text-left border p-2">Phone</th>
                                    <th class="text-left border p-2">Area</th>
                                    <th class="text-center border p-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $data)
                                <tr>
                                    <td class="border p-2">{{ $data->title }}</td>
                                    <td class="border p-2">{{ $data->address }}</td>
                                    <td class="border p-2">{{ $data->phone_number }}</td>
                                    <td class="border p-2">{{ ($data->area->name) ?? null }}</td>
                                    <td class="text-center border p-2">
                                        <a href="{{ route('my.address.edit', $data->id) }}" class="text-center btn btn-sm btn-icon-only"><i class="fa-solid fa-pen"></i></a>
                                        {{-- <a href="{{ route('my.address.destroy', $data->id) }}" class="text-center btn btn-sm btn-icon-only bg-red-500 hover:bg-red-700 hover:text-white text-white">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a> --}}
                                    </td>
                                </tr>
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
        // Category Menu for Address
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
