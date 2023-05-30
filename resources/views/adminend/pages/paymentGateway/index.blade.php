@extends('adminend.layouts.default')
@section('title', 'Payment Gateways')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Payment Gateway</h6>
        <div class="actions">
            <a href="{{ route('admin.payments.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">

        @if(Session::has('message'))
            <div class="alert mb-8 success">{{ Session::get('message') }}</div>
        @endif

        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($pgs as $pg)
                    <tr>
                        <td class="text-center">{{ $pg->id }}</td>
                        <td class="text-center w-24">
                            <img src="{{ $pg->img_src }}" alt="{{ $pg->name }}" class="w-16 h-8">
                        </td>
                        <td>{{ $pg->name }}</td>
                        <td class="text-center">
                            <button class="border px-2 py-1 rounded text-white bg-green-400 text-sm">
                                {{ $pg->status }}
                            </button>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.payments.edit', $pg->id) }}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($pgs->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $pgs->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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
