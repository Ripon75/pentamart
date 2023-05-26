@extends('adminend.layouts.default')
@section('title', 'Users')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Users</h6>
        <div class="actions">
            <a href="{{ route('admin.users.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">

        {{-- Show success messagge --}}
        @if(Session::has('success'))
            <div class="alert mb-8 success">{{ Session::get('success') }}</div>
        @endif

        <form action="{{ route('admin.users.index') }}" method="GET">
            @csrf
            <div class="action-bar mb-4 flex items-end space-x-2">
                <div class="flex flex-col">
                    <label for="">Name</label>
                    <input type="text" class="border border-gray-300 rounded w-40 h-10" name="name"
                        value="{{ request()->input('name') }}">
                </div>
                <div class="flex flex-col">
                    <label for="">Email</label>
                    <input type="text" class="border border-gray-300 rounded w-64 h-10" name="email"
                        value="{{ request()->input('email') }}">
                </div>
                <div class="flex flex-col">
                    <label for="">Phone Number</label>
                    <input type="text" class="border border-gray-300 rounded w-36 h-10" name="phone_number"
                        value="{{ request()->input('phone_number') }}">
                </div>
                <div class="flex flex-col">
                    <label for="">Role</label>
                    <input type="text" class="border border-gray-300 rounded w-36 h-10" name="roles"
                        value="{{ request()->input('roles') }}">
                </div>
                <button class="btn btn-outline-success" type="submit">Search</button>
                <a href="{{ route('admin.users.index') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
            </div>
        </form>
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th class="w-20">ID</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Email</th>
                    <th class="text-left">Phone Number</th>
                    <th class="text-left">Role</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="text-center">
                        <td>{{ $user->id }}</td>
                        <td class="text-left">{{ $user->name }}</td>
                        <td class="text-left">{{ $user->email }}</td>
                        <td class="text-left">{{ $user->phone_number }}</td>
                        <td class="text-left">{{ $user->roles[0]->display_name ?? ''}}</td>
                        <td>
                            <a class="btn btn-success btn-sm" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($users->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $users->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 4000 );
    </script>
@endpush
