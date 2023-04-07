@extends('adminend.layouts.default')
@section('title', 'Areas')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Areas</h6>
        <div class="actions">
            <a href="{{ route('admin.areas.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('error'))
            <div class="alert mb-8 error">{{ Session::get('error') }}</div>
        @endif

        @if(Session::has('message'))
            <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif
        <form action="{{ route('admin.areas.index') }}" method="GET">
            @csrf
            <div class="action-bar mb-4 flex items-end space-x-2">
                <div class="flex flex-col">
                    <label for="">Name</label>
                    <input type="text" class="border border-gray-300 rounded w-48 h-10" name="name"
                        value="{{ request()->input('name') }}">
                </div>
                <button class="btn btn-outline-success" type="submit">Search</button>
                <a href="{{ route('admin.areas.index') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
            </div>
        </form>
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($areas as $data)
                    <tr>
                        <td class="text-center">{{ $data->id }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->slug }}</td>
                        <td>
                            <a class="btn btn-success btn-sm" href="{{ route('admin.areas.edit', $data->id) }}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($areas->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $areas->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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
