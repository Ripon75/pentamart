@extends('adminend.layouts.default')
@section('title', 'Sell Partners')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Sell Partner</h6>
        <div class="actions">
            <a href="{{ route('admin.sell-partners.create') }}" class="action btn btn-primary">Create</a>
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
                    <th class="w-20">ID</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Contact Name</th>
                    <th class="text-left">Contact Number</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($sellPartners as $sPartner)
                    <tr class="text-center">
                        <td>{{ $sPartner->id }}</td>
                        <td class="text-left">{{ $sPartner->name }}</td>
                        <td class="text-left">{{ $sPartner->contact_name ?? 'N/A' }}</td>
                        <td class="text-left">{{ $sPartner->contact_number ?? 'N/A' }}</td>
                        <td>
                            <a class="btn btn-success btn-sm" href="{{ route('admin.sell-partners.edit', $sPartner->id) }}">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- ========Pagination============ --}}
            @if ($sellPartners->hasPages())
                <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                    {{ $sellPartners->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
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
