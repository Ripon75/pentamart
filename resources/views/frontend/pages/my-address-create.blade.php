@extends('frontend.layouts.default')
@section('title', 'Address Cerate')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            <div class="col-span-4">
                <div class="card p-4 w-full mx-auto sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2">
                    <form action="{{ route('my.address') }}" method="POST">
                        @csrf

                        <div class="flex justify-end">
                            <a href="{{ route('my.address') }}" class="btn btn-primary">All</a>
                        </div>

                        <div class="form-item">
                            <label class="form-label">Address Title <span class="text-red-500 font-medium">*</span></label>
                           <select id="input-address-title" name="title" class="form-select form-input w-full">
                                <option value="">Select</option>
                                <option value="Home">Home</option>
                                <option value="Office">Office</option>
                                <option value="Others">Others</option>
                            </select>
                            <span class="text-red-500 text-xs">
                                @error('title') {{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Address <span class="text-red-500 font-medium">*</span></label>
                            <input class="form-input" type="text" name="address"/>
                            <span class="text-red-500 text-xs">
                                @error('address') {{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Alternative Phone Number</label>
                            <input class="form-input" type="number" name="phone_number"/>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Area <span class="text-red-500 font-medium">*</span></label>
                            <select class="form-input select-2-areas" name="area_id">
                                <option value="">Select</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-red-500 text-xs">
                                @error('area_id') {{ $message }} @enderror
                            </span>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-md btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
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
    </script>
@endpush
