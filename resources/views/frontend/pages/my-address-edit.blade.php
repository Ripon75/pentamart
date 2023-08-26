@extends('frontend.layouts.default')
@section('title', 'My-Address-Edit')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            <div class="col-span-4">
                <div class="card p-4 w-full mx-auto sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2">
                    <form action="{{ route('my.address.update', $data->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="flex justify-end">
                            <a href="{{ route('my.address') }}" class="btn btn-primary">All</a>
                        </div>

                        <div class="form-item">
                            <label class="form-label">Address Title <span class="text-red-500 font-medium">*</span></label>
                            <input class="form-input" type="text" value="{{ $data->title }}" name="title" disabled/>
                            <span class="text-red-500 text-xs">
                                @error('title') {{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Name </label>
                            <input class="form-input" type="text" value="{{ $data->user_name }}" name="user_name"/>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Phone Number</label>
                            <input class="form-input" type="text" value="{{ $data->phone_number }}" name="phone_number"/>
                            <span class="text-red-500 text-xs">
                                @error('phone_number') {{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Phone Number (2)</label>
                            <input class="form-input" type="text" value="{{ $data->phone_number_2 }}" name="phone_number_2"/>
                            <span class="text-red-500 text-xs">
                                @error('phone_number_2') {{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-item">
                            <label class="form-label">District <span class="text-red-500 font-medium">*</span></label>
                            <select class="form-input select-2-district" name="district_id">
                                <option value="">Select</option>
                                @foreach ($districts as $district)
                                <option value="{{ $district->id }}" {{ $district->id == $data->district_id ? "selected" : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-red-500 text-xs">
                                @error('district_id') {{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Thana <span class="text-red-500 font-medium">*</span></label>
                            <input class="form-input" type="text" value="{{ $data->thana }}" name="thana"/>
                            <span class="text-red-500 text-xs">
                                @error('thana') {{ $message }} @enderror
                            </span>
                        </div>
                        <div class="form-item">
                            <label class="form-label">Address <span class="text-red-500 font-medium">*</span></label>
                            <textarea name="address" class="form-input">{{ $data->address }}</textarea>
                            <span class="text-red-500 text-xs">@error('address') {{ $message }} @enderror</span>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-md btn-primary">Update</button>
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
            // Select-2 for district
            $('.select-2-district').select2({
                placeholder: "Select district",
            });
        });
    </script>
@endpush
