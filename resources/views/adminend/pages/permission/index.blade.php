@extends('adminend.layouts.default')
@section('title', 'Permissions')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Permission</h6>
        <div class="actions">
            <a href="{{ route('admin.permissions.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">

        {{-- Show success message --}}
        @if(Session::has('success'))
            <div class="alert mb-8 success">{{ Session::get('success') }}</div>
        @endif

        <form class="mb-3" action="{{ route('admin.permissions') }}" method="GET">
            <input class="" value="{{ request()->input('search_keyword') }}" name="search_keyword" type="search" placeholder="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
            <a href="{{ route('admin.permissions') }}" class="btn border h-10 bg-red-500 text-white">Clear</a>
        </form>
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th class="w-20">SL</th>
                    <th class="text-left">Display Name</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Description</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $key => $permission)
                    <tr class="text-center">
                        <td>{{ ++$key }}</td>
                        <td class="text-left">{{ $permission->display_name }}</td>
                        <td class="text-left">{{ $permission->name }}</td>
                        <td class="text-left">{{ $permission->description }}</td>
                        <td>
                            <a class="btn btn-success btn-sm" href="{{ route('admin.permissions.edit', $permission->id) }}">Edit</a>
                            {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.permissions.show', $permission->id) }}">Show</a> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($permissions->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $permissions->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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
