@extends('adminend.layouts.default')
@section('title', 'Roles')
@section('content')
<section class="page">
    <div class="page-toolbar">
        <h6 class="title">Create Role</h6>
        <div class="actions">
            <a href="{{ route('admin.roles') }}" class="action btn btn-primary">Roles</a>
        </div>
    </div>
    <div class="page-content">
        <div class="lg:w-[500px] xl:w-[800px] mx-auto">

            {{-- Show error message --}}
            @if(Session::has('error'))
                <div class="alert mb-8 error">{{ Session::get('error') }}</div>
            @endif

            <div class="card shadow">
                <div class="body p-4">
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf

                        <div class="">
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label class="form-label">Name</label>
                                    <input type="text" value="{{ old('display_name') }}" name="display_name" class="form-input" />
                                    @error('display_name')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Description</label>
                                    <input type="text" name="description" class="w-full form-input">
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-1">
                                @foreach ($permissions as $permission)
                                    <span class="flex space-x-2">
                                        <input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}">
                                        <label class="text-base">{{ $permission->display_name }}</label>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary mt-2">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
