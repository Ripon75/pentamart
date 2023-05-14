@extends('frontend.layouts.default')

@section('title', 'Phone confirmation code')

@section('content')
    <!-- ========Login Form ======= -->
      <section class="">
        <div class="container page-section page-top-gap">
            <div class="md:w-[500px] lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        @if(Session::has('message'))
                        <div class="alert mb-8 error">{{ Session::get('message') }}</div>
                        @endif

                        <form action="{{ route('phone.active.code.check') }}" method="POST">
                            @csrf
                            <div class="form-item">
                                <input type="hidden" id="phone-number" value="{{ $phoneNumber }}" name="phone_number">
                                <label class="form-label">Enter your OTP code<span class="text-red-500 font-medium">*</span>
                                </label>
                                <input type="text" value="{{ old('pin_code') }}" name="pin_code" class="form-input" placeholder="Enter your otp code" autocomplete="off"/>
                                <span class="text-right mt-1">
                                    <a class="text-sm" id="phone-activation-resend-code">
                                        Resend code
                                    </a>
                                </span>
                            </div>
                            <div class="mt-4">
                                <button id="btn-user-activation-submit" type="submit" class="btn btn-primary btn-block">
                                    Submit
                                    <i class="user-activation-loadding-icon fa-solid fa-spinner fa-spin mr-2"></i>
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
    <script>
        var resendCodeEndPoint         = '/activation-resend-code';
        var phoneActivationResendCode  = $('#phone-activation-resend-code');
        var btnUserActivationSubmit    = $('#btn-user-activation-submit');
        var userActivationLoaddingIcon = $('.user-activation-loadding-icon').hide();

        $(function() {
            phoneActivationResendCode.click(function() {
                var phoneNumber = $('#phone-number').val();
                resendActivationCode(phoneNumber);
            });

            btnUserActivationSubmit.click(function() {
                userActivationLoaddingIcon.show();
            });
        });

        // Resend activation code
        function resendActivationCode(phoneNumber) {
            axios.get(resendCodeEndPoint, {
                params: {
                phone_number: phoneNumber
                }
            })
            .then(function (response) {
                if (response.data.code === 200) {
                __showNotification('success', response.data.message, 1000);
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    </script>
@endpush
