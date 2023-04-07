@extends('adminend.layouts.default')
@section('title', 'Roles')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Role</h6>
        <div class="actions">
            <a href="{{ route('admin.roles.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('message'))
        <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th class="w-20">ID</th>
                    <th class="text-left">Name</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr class="text-center">
                        <td>{{ $role->id }}</td>
                        <td class="text-left">{{ $role->display_name }}</td>
                        <td>
                            <a class="btn btn-success btn-sm" href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                            {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.roles.show', $role->id) }}">Show</a> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($roles->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $roles->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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
