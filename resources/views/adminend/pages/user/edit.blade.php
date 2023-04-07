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
            <div class="lg:w-[500px] xl:w-[800px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="">
                                {{-- role --}}
                                <div class="">
                                    <div class="form-item ">
                                        <label class="form-label">User</label>
                                        <input type="text" value="{{ $user->name }}" class="form-input" readonly/>
                                    </div>
                                    <div class="form-item">
                                        <label for="" class="form-label">Roles</label>
                                        <select class="form-select w-full select-2" name="role_id[]" multiple>
                                            <option value="">Select</option>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ in_array($role->name, $userRoles) ? "selected" : '' }}>
                                                {{ $role->display_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- permissions  --}}
                                <div class="grid grid-cols-3 gap-1">
                                    @foreach ($permissions as $permission)
                                        <span class="flex space-x-2">
                                            <input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}"
                                            {{ in_array($permission->id, $permissionIds) ? 'checked' : '' }}>
                                            <label>{{ $permission->display_name }}</label>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Update</button>
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
