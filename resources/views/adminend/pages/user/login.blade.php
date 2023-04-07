@extends('adminend.layouts.login')

@section('content')
    <div class="steps w-full lg:w-[500px] xl:w-[500px] mx-auto px-0 pt-5">
        <div class="">
            <div class="body rounded pb-2 md:pb-2 lg:pb-4 px-4 lg:px-0">
                <h1>Login</h1>
                <form action="{{ route('admin.users.login.store') }}" method="POST">
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
                            <i class="loading-icon fa-solid fa-spinner fa-spin mr-2"></i>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var lodingIcon =  $('.loading-icon').hide();
        $(function() {
            $('#btn-admin-login').click(() => {
                lodingIcon.show();
            });
        })
    </script>
@endpush