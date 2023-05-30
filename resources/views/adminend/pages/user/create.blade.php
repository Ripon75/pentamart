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
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf

                            {{-- Show error message --}}
                            @if(Session::has('error'))
                                <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                            @endif

                            <div class="">
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
                                <div class="form-item w-full">
                                    <label class="form-label">Email</label>
                                    <input type="email" value="{{ old('email') }}" name="email"
                                        placeholder="jhon@example.com" class="form-input" />
                                </div>
                                <div class="form-item w-full">
                                    <label class="form-label">Roles</label>
                                    <div class="relative flex items-center justify-end">
                                        <select name="role_ids[]" class="form-input flex-1 select-2" multiple>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button class="btn btn-primary">Create</button>
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
