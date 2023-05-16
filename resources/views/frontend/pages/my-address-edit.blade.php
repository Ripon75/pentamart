@extends('frontend.layouts.default')
@section('title', 'My-Address-Edit')
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
                </div>
                <div class="card p-4">
                    <form class="w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2"
                        action="{{ route('my.address.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if(Session::has('message'))
                            <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                        @endif

                        <div class="form-item">
                            <label class="form-label">Address Title <span class="text-red-500 font-medium">*</span></label>
                            <input class="form-input" type="text" value="{{ $data->title }}" name="title" disabled/>
                            <span class="text-red-300">@error('title') {{ $message }} @enderror</span>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Address <span class="text-red-500 font-medium">*</span></label>
                            <input class="form-input" type="text" value="{{ $data->address }}" name="address"/>
                            <span class="text-red-300">@error('address') {{ $message }} @enderror</span>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Alternative Phone Number</label>
                            <input class="form-input" type="number" value="{{ $data->phone_number }}" name="phone_number"/>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Area <span class="text-red-500 font-medium">*</span></label>
                            <select class="form-input select-2-areas" name="area_id">
                                <option value="">Select</option>
                                @foreach ($areas as $area)
                                <option value="{{ $area->id }}" {{ $area->id == $data->area_id ? "selected" : '' }}>{{ $area->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-red-300">@error('area_id') {{ $message }} @enderror</span>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-md btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 5000 );

        $(() => {
            // Select-2 for area
            $('.select-2-areas').select2({
                placeholder: "Select area",
            });
        });

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
