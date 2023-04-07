@extends('adminend.layouts.default')
@section('title', 'Sections')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Section</h6>
        <div class="actions">
            <a href="{{ route('admin.sections.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('error'))
            <div class="alert mb-8 error">{{ Session::get('message') }}</div>
        @endif

        @if(Session::has('message'))
            <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif
        <form class="mb-3" action="{{ route('admin.sections.index') }}" method="GET">
            <input class="" value="{{ request()->input('search_keyword') }}" name="search_keyword" type="search" placeholder="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
            <a href="{{ route('admin.sections.index') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
        </form>
        <div class="">
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th class="w-40">Name</th>
                    <th class="w-40">Title</th>
                    <th class="w-28">Link</th>
                    <th class="w-40">Status</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($sections as $data)
                    <tr class="">
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->title }}</td>
                        <td>{{ $data->link }}</td>
                        <td class="text-center">
                            {{ $data->status }}
                        </td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.sections.edit', $data->id) }}">Edit</a>
                            {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.sections.show', $data->id) }}">Show</a> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($sections->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $sections->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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

