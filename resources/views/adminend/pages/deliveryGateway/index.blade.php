@extends('adminend.layouts.default')
@section('title', 'Delivery Gateways')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Delivery Gateway</h6>
        <div class="actions">
            <a href="{{ route('admin.deliveries.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('error'))
            <div class="alert mb-8 error">{{ Session::get('message') }}</div>
        @endif

        @if(Session::has('message'))
            <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif
        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Price</th>
                    <th>Min time</th>
                    <th>Max time</th>
                    <th>Unit</th>
                    <th>Status</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($result as $data)
                    <tr>
                        <td class="text-center">{{ $data->id }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->code }}</td>
                        <td class="text-right">{{ $data->price }}</td>
                        <td class="text-right">{{ $data->min_delivery_time }}</td>
                        <td class="text-right">{{ $data->max_delivery_time }}</td>
                        <td>{{ $data->delivery_time_unit }}</td>
                        <td class="text-center">
                            <button class="border px-2 py-1 rounded text-white bg-green-400 text-sm">{{ $data->status }}</button>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.deliveries.edit', $data->id) }}">Edit</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.deliveries.show', $data->id) }}">Show</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($result->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $result->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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

