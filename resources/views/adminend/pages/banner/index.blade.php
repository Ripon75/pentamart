@extends('adminend.layouts.default')
@section('title', 'Banners')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All banners</h6>
        <div class="actions">
            <a href="{{ route('admin.banners.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        <form class="mb-3" action="{{ route('admin.banners') }}" method="GET">
            <input class="" value="{{ request()->input('search_keyword') }}" name="search_keyword" type="search" placeholder="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
            <a href="{{ route('admin.banners') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
        </form>
        @if(Session::has('error'))
            <div class="alert mb-8 error">{{ Session::get('message') }}</div>
        @endif

        @if(Session::has('message'))
            <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif
        <div class="">
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th class="w-40">Image</th>
                    <th class="w-28">Title</th>
                    <th class="w-28">Position</th>
                    <th class="w-28">Serial</th>
                    <th class="w-40">Status</th>
                    <th class="w-40">BG Color</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($banners as $data)
                    <tr class="">
                        <td>
                            <img src="{{ $data->img_src }}" alt="Bannaer" class="h-16">
                        </td>
                        <td>{{ $data->title }}</td>
                        <td>{{ $data->position }}</td>
                        <td>{{ $data->serial }}</td>
                        <td class="text-center">{{ $data->status }}</td>
                        <td class="text-center">{{ $data->bg_color }}</td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.banners.edit', $data->id) }}">Edit</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.banners.show', $data->id) }}">Show</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($banners->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $banners->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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

