@extends('adminend.layouts.default')
@section('title', 'Users')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Edit User</h6>
        <div class="actions">
            <a href="{{ route('admin.users.index') }}" class="action btn btn-primary">Users</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[600px] mx-auto">

                {{-- Show error message --}}
                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                @endif

                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="">
                                <div class="">
                                    <div class="form-item ">
                                        <label class="form-label">name</label>
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-input"/>
                                        @error('name')
                                            <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-item ">
                                        <label class="form-label">Email</label>
                                        <input type="text" name="email" value="{{ $user->email }}" class="form-input"/>
                                    </div>
                                    <div class="form-item ">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="phone_number" value="{{ $user->phone_number }}" class="form-input"/>
                                        @error('phone_number')
                                            <span class="form-helper error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-item">
                                        <label for="" class="form-label">Roles</label>
                                        <select class="form-select w-full select-2" name="role_ids[]" multiple>
                                            <option value="">Select</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ in_array($role->name, $userRoles) ? "selected" : '' }}>
                                                    {{ $role->display_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="btn btn-primary mt-2">Update</button>
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
        $(function() {
            $('.select-2').select2({
                placeholder: "Select some roles",
            });
        });
    </script>
@endpush
