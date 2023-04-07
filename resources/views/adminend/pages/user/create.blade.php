@extends('adminend.layouts.default')
@section('title', 'Users')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Create User</h6>
        <div class="actions">
            <a href="{{ route('admin.users.index') }}" class="action btn btn-primary">Users</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[800px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.users.registration.store') }}" method="POST">
                            @csrf

                            @if(Session::has('error'))
                                <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                            @endif

                            @if(Session::has('message'))
                                <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                            @endif

                            <div class="">
                                <div class="flex space-x-2">
                                    <div class="form-item w-full">
                                        <label class="form-label">Name <span class="text-red-500 font-medium">*</span></label>
                                        <input type="text" value="{{ old('name') }}" name="name" placeholder="Jhon Doe"
                                            class="form-input" />
                                        @error('name')
                                        <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-item w-full">
                                        <label class="form-label">Phone Number <span
                                                class="text-red-500 font-medium">*</span></label>
                                        <input type="text" value="{{ old('phone_number') }}" name="phone_number"
                                            class="form-input rounded" placeholder="01XXXXXXXXX" />
                                        @error('phone_number')
                                        <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <div class="form-item w-full">
                                        <label class="form-label">Email</label>
                                        <input type="email" value="{{ old('email') }}" name="email"
                                            placeholder="jhon@example.com" class="form-input" />
                                        @error('email')
                                        <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-item w-full">
                                        <label class="form-label">Password <span
                                                class="text-red-500 font-medium">*</span></label>
                                        <div class="relative flex items-center justify-end">
                                            <input class="form-input flex-1" type="text"
                                                placeholder="Please enter your password" name="password" />
                                        </div>
                                        @error('password')
                                        <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <div class="form-item w-full">
                                        <label class="form-label">Roles<span class="text-red-500 font-medium">*</span></label>
                                        <div class="relative flex items-center justify-end">
                                            <select name="role_id[]" class="form-input flex-1 select-2" multiple>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('password')
                                        <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-item w-full">
                                        <label class="form-label">Sell Partner<span class="text-red-500 font-medium">*</span></label>
                                        <div class="relative flex items-center justify-end">
                                            <select name="sell_partner_id" class="form-input flex-1 select-2">
                                                @foreach ($sellPartners as $sellPartner)
                                                    <option value="{{ $sellPartner->id }}">{{ $sellPartner->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('password')
                                        <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <button id="btn-admin-create" type="submit" class="btn btn-primary btn-block">
                                    <i class="loading-icon fa-solid fa-spinner fa-spin mr-2"></i>
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var lodingIcon = $('.loading-icon').hide();
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 5000 );

         $('.select-2').select2({
            placeholder: "Select",
        });

        $(function() {
            $('#btn-admin-create').click(() => {
                lodingIcon.show();
            });
        })
    </script>
@endpush