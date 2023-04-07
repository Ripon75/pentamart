@extends('frontend.layouts.default')
@section('title', 'My-Address-Create')
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
                            title="Add Address"
                            bg-Color="#102967"
                        />
                    </div>
                </div>
                <div class="card p-4">
                    <form class="w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2" action="{{ route('my.address.other.store') }}" method="POST">
                        @csrf

                        @if(Session::has('success'))
                            <div class="alert mb-8 success">{{ Session::get('success') }}</div>
                        @endif

                        <div class="form-item">
                            <label class="form-label">Address Title <span class="text-red-500 font-medium">*</span> </label>
                            <select id="customer-address-title" class="form-select form-input w-full" name="title">
                                <option value="">Select</option>
                                <option value="Home" {{ old('title') === 'Home' ? 'selected' : '' }}>Home</option>
                                <option value="Office" {{ old('title') === 'Office' ? 'selected' : '' }}>Office</option>
                                <option value="Others" {{ old('title') === 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('title')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                            @if(Session::has('title_exist'))
                                <span class="form-helper error">{{ Session::get('title_exist') }}</span>
                            @endif
                        </div>
                        <div id="customer-others-title-div" class="form-item mr-1">
                            <label for="">Your address title<span class="text-red-500 font-medium">*</span></label>
                            <input id="header-others-title" class="form-input" type="text" name="others_title"
                                placeholder="Enter Your address title" value="{{ old('others_title') }}"/>
                            @error('others_title')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label">Address <span class="text-red-500 font-medium">*</span> </label>
                            <input class="form-input" type="text" name="address" value="{{ old('address') }}" placeholder="Enter your address"/>
                            @error('address')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-item">
                            <label class="form-label">Alternative Phone Number</label>
                            <input class="form-input" type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Enter Your Phone Number"/>
                            <span class="text-red-400 text-sm">@error('phone_number') {{ $message }} @enderror</span>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Area <span class="text-red-500 font-medium">*</span> </label>
                            <select class="form-input select-2-areas" name="area_id">
                                <option value="">Select area</option>
                                @foreach ($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('area_id')
                                <span class="form-helper error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-md btn-primary">
                                Submit
                            </button>
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
        var customerAddressTitle  = $('#customer-address-title');
        var customerOtherTitleDiv = $('#customer-others-title-div').hide();
        var oldTitle = "{{ old('title') }}";
        if (oldTitle === "Others") {
            customerOtherTitleDiv.show();
        }

        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 5000 );

        $(() => {
            // Select-2 for area
            $('.select-2-areas').select2({
                placeholder: "Select area",
            });

            // Check address title is others
            customerAddressTitle.change(function(){
                var customerTitle = $(this).val();
                if (customerTitle === 'Others') {
                    customerOtherTitleDiv.show();
                } else {
                    customerOtherTitleDiv.hide();
                }
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
