@extends('sellercenter.layouts.auth')
@section('title', 'Sellercenter Login')
@section('content')

<div class="page h-full w-full">
    <div class="w-96 mx-auto mt-24">
        <div class="text-center">
            <div>
                <img class="w-48 mx-auto" src="{{ asset('images/sellercenter/logo-full-color.svg') }}" alt="">
            </div>
            <div class="text-sm">SellerCenter</div>
        </div>
        <div class="bg-white rounded-md shadow-sm mt-4 p-4">
            <div>
                <form action="{{ route('seller.login.store') }}" method="POST">
                    @csrf

                    @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                    @endif

                    @if(Session::has('success'))
                    <div class="alert mb-8 success">{{ Session::get('success') }}</div>
                    @endif

                    <div class="form-item mt-2">
                        <label class="form-label">Phone Number<span class="ml-1 text-red-500 font-medium">*</span></label>
                        <div class="">
                            <div>
                                <input
                                    class="w-full text-xs md:text-base rounded focus:ring-0 focus:outline-none placeholder:text-xs md:placeholder:text-sm"
                                    type="text" placeholder="01XXXXXXXXX" name="phone_number"
                                    value="{{ old('phone_number') }}"/>
                                @error('phone_number')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-4">
                                <label class="form-label">Password<span class="ml-1 text-red-500 font-medium">*</span></label>
                                <input
                                    type="password"
                                    class="w-full text-xs md:text-base rounded focus:ring-0 focus:outline-none placeholder:text-xs md:placeholder:text-sm mt-2"
                                    type="text" placeholder="Password" name="password" />
                                @error('password')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button id="btn-admin-login" type="submit" class="btn btn-md btn-primary btn-block">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
