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

        {{-- Show success message --}}
        @if(Session::has('success'))
            <div class="alert mb-8 success">{{ Session::get('success') }}</div>
        @endif

        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Promo Price</th>
                    <th>Min time</th>
                    <th>Max time</th>
                    <th>Time Unit</th>
                    <th>Status</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($dgs as $dg)
                    <tr>
                        <td class="text-center">{{ $dg->id }}</td>
                        <td>{{ $dg->name }}</td>
                        <td class="text-right">{{ $dg->price }}</td>
                        <td class="text-right">{{ $dg->promo_price }}</td>
                        <td class="text-right">{{ $dg->min_time }}</td>
                        <td class="text-right">{{ $dg->max_time }}</td>
                        <td>{{ $dg->time_unit }}</td>
                        <td class="text-center">
                            <button class="border px-2 py-1 rounded text-white bg-green-400 text-sm">{{ $dg->status }}</button>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.deliveries.edit', $dg->id) }}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($dgs->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $dgs->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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

