@extends('adminend.layouts.default')
@section('title', 'Sliders')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Slider</h6>
        <div class="actions">
            <a href="{{ route('admin.sliders.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('error'))
        <div class="alert mb-8 error">{{ Session::get('error') }}</div>
        @endif

        @if(Session::has('message'))
        <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif

        <form class="mb-3" action="{{ route('admin.sliders.index') }}" method="GET">
            <input class="" value="{{ request()->input('search_keyword') }}" name="search_keyword" type="search" placeholder="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
            <a href="{{ route('admin.sliders.index') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
        </form>
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($sliders as $slider)
                    <tr class="">
                        <td class="text-center">{{ $slider->id }}</td>
                        <td class="text-center w-16">
                            <img class="h-8 w-16" src="{{ $slider->img_src }}" alt="{{ $slider->name }}">
                        </td>
                        <td>{{ $slider->name }}</td>
                        <td class="text-center">
                            @if ($slider->status == 'active')
                                <button class="border px-1 py-1 rounded text-white bg-green-400 text-sm">
                                    {{ $slider->status }}
                                </button>
                            @else
                                <button class="border px-1 py-1 rounded text-white bg-red-400 text-sm">
                                    {{ $slider->status }}
                                </button>
                            @endif
                        </td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.sliders.edit', $slider->id) }}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($sliders->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $sliders->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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

