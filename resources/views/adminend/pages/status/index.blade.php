@extends('adminend.layouts.default')
@section('title', 'Order status')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Status</h6>
        <div class="actions">
            <a href="{{ route('admin.order.statuses.create') }}" class="action btn btn-primary">Create</a>
        </div>
    </div>
    <div class="page-content">

        @if(Session::has('success'))
            <div class="alert mb-8 success">{{ Session::get('success') }}</div>
        @endif

        <div>
            <table class="table w-full">
                <thead>
                <tr class="">
                    <th class="w-20">ID</th>
                    <th>Name</th>
                    <th class="w-40">Status</th>
                    <th class="w-40">BG Color</th>
                    <th class="w-40">Text Color</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($statuses as $status)
                    <tr>
                        <td class="text-center">{{ $status->id }}</td>
                        <td>{{ $status->name }}</td>
                        @if ($status->status === 'active')
                            <td class="text-center">
                                <button class="btn btn-success btn-sm">{{ $status->status }}</button>
                            </td>
                        @else
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm">{{ $status->status }}</button>                            </td>
                        @endif
                        <td class="text-center">{{ $status->bg_color }}</td>
                        <td class="text-center">{{ $status->text_color }}</td>
                        <td class="text-center">
                            <a class="btn btn-success btn-sm" href="{{ route('admin.order.statuses.edit', $status->id) }}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($statuses->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $statuses->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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

