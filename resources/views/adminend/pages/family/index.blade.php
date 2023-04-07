@extends('adminend.layouts.default')
@section('title', 'Families')
@section('content')

<div class="page">
    <div class="page-toolbar">
        <h6 class="title">All Family</h6>
        <div class="actions">
            <a href="{{ route('admin.families.create') }}" class="action btn btn-primary">Create</a>
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
                    <th>Name</th>
                    <th>User Defined</th>
                    <th>Description</th>
                    <th class="w-40">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($result as $data)
                    <tr class="text-center">
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->user_defined == 1 ? 'True' : 'False' }}</td>
                        <td>{{ $data->description }}</td>
                        <td>
                            <a class="btn btn-success btn-sm" href="{{ route('admin.families.edit', $data->id) }}">Edit</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.families.show', $data->id) }}">Show</a>
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

