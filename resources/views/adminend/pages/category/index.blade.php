@extends('adminend.layouts.default')
@section('title', 'Categories')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h3 class="title">All Category</h3>
        <div class="actions">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('error'))
            <div class="alert mb-8 error">{{ Session::get('message') }}</div>
        @endif
        @if(Session::has('message'))
            <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif
        <form class="mb-3" action="{{ route('admin.categories.index') }}" method="GET">
            <input class="" value="{{ request()->input('search_keyword') }}" name="search_keyword" type="search" placeholder="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
            <a href="{{ route('admin.categories.index') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
        </form>
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Attribute Family</th>
                    <th>Status</th>
                    <th>Color</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $data)
                    <tr>
                        <td class="text-center">{{ $data->id }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ ($data->parent->name) ?? null }}</td>
                        <td>{{ ($data->family->name) ?? null }}</td>
                        <td class="text-center">
                            <button class="border px-2 py-1 rounded text-white bg-green-400 text-sm">
                                {{ $data->status }}
                            </button>
                        </td>
                        <td>{{ $data->color }}</td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.categories.edit', $data->id) }}">Edit</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.categories.show', $data->id) }}">Show</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($categories->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $categories->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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
