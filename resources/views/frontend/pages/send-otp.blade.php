@extends('frontend.layouts.default')
@section('title', 'OTP')
@section('content')
    <section class="">
        <div class="container page-section page-top-gap">
            <div class="sm:[w-500px] md:w-[500px] lg:w-[500px] xl:w-[500px] 2xl:w-[500px] mx-auto">

                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                @endif

                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('check.otp') }}" method="POST">
                            @csrf

                            <input type="hidden" name="phone_number" value="{{ request('phone_number') }}">

                            <div class="form-item">
                                <label class="form-label">Enter your OTP <span class="text-red-500 font-medium">*</span></label>
                                <input type="text" value="{{ old('otp_code') }}" name="otp_code" class="form-input rounded" />
                                <a id="input-resend-otp" type="button"  class="text-xs mt-1">Resend</a>
                                @error('otp_code')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-8">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        var inputResendOtp = $('#input-resend-otp');

        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 4000 );

        $(function(){
            inputResendOtp.click(function() {
                console.log('clic');
            });
        });
    </script>

@endpush


