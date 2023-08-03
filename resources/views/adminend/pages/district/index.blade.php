@extends('adminend.layouts.default')
@section('title', 'Areas')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Areas</h6>
        <div class="actions">
            <a href="{{ route('admin.districts.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">

        @if(Session::has('success'))
            <div class="alert mb-8 success">{{ Session::get('success') }}</div>
        @endif

        <form action="{{ route('admin.districts.index') }}" method="GET">
            @csrf
            <div class="action-bar mb-4 flex items-end space-x-2">
                <div class="flex flex-col">
                    <label for="">Name</label>
                    <input type="text" class="border border-gray-300 rounded w-48 h-10" name="name"
                        value="{{ request()->input('name') }}">
                </div>
                <button class="btn btn-outline-success" type="submit">Search</button>
                <a href="{{ route('admin.districts.index') }}" class="btn border h-10 bg-red-500 text-white ml-1">Clear</a>
            </div>
        </form>
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Delivery Charge</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($districts as $key => $data)
                    <tr>
                        <td class="text-center">{{ ++$key }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->delivery_charge }}</td>
                        @if ($data->status === 'active')
                            <td class="text-center">
                                <button class="btn btn-success btn-sm">{{ $data->status }}</button>
                            </td>
                        @else
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm">{{ $data->status }}</button>
                            </td>
                        @endif
                        <td class="text-center">
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.districts.edit', $data->id) }}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($districts->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $districts->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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
