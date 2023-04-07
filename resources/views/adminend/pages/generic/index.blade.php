@extends('adminend.layouts.default')
@section('title', 'Generics')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Generic</h6>
        <div class="actions">
            <a href="{{ route('admin.generics.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('error'))
        <div class="alert mb-8 error">{{ Session::get('message') }}</div>
        @endif

        @if(Session::has('message'))
        <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif
        <form class="mb-3" action="{{ route('admin.generics.index') }}" method="GET">
            <input class="" value="{{ request()->input('search_keyword') }}" name="search_keyword" type="search" placeholder="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
            <a href="{{ route('admin.generics.index') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
        </form>
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Strength</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($generics as $data)
                    <tr>
                        <td class="text-center">{{ $data->id }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->strength }}</td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.generics.edit', $data->id) }}">Edit</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.generics.show', $data->id) }}">Show</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($generics->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $generics->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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
