@extends('adminend.layouts.default')
@section('title', 'Offers Quantity')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Offers Quantity</h6>
        <div class="actions">
            <a href="{{ route('admin.offers.quantity.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('error'))
        <div class="alert mb-8 error">{{ Session::get('error') }}</div>
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
                    <th>Type</th>
                    <th>Status</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($result as $key => $data)
                    <tr>
                        <td class="text-center">{{ ++$key }}</td>
                        <td>{{ $data->name }}</td>
                        <td>
                            @if ($data->type === 'quantity')
                                Quantity
                            @else
                                N/A
                            @endif
                        </td>
                        @if ($data->status === 'activated')
                            <td class="text-center">
                                <button class="border px-2 py-1 rounded text-white bg-green-400 text-sm">{{ $data->status }}</button>
                            </td>
                        @else
                            <td class="text-center">
                                <button class="border px-2 py-1 rounded text-white bg-orange-400 text-sm">{{ $data->status }}</button>
                            </td>
                        @endif
                        <td>{{ $data->start_date }}</td>
                        <td>{{ $data->end_date }}</td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.offers.quantity.edit', $data->id) }}">Edit</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.offers.quantity.show', $data->id) }}">Show</a>
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
