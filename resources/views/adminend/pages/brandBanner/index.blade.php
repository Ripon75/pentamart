@extends('adminend.layouts.default')
@section('title', 'Brands')
@section('content')

<div class="px-8 py-4">
    <div class="py-4 flex items-center justify-between">
        <h3 class="font-bold text-lg">All brand banners</h3>
        <a href="{{ route('admin.brand.banners.create') }}" class="btn btn-primary">Create</a>
    </div>
    @if(Session::has('error'))
    <div class="alert mb-8 error">{{ Session::get('message') }}</div>
    @endif

    @if(Session::has('message'))
    <div class="alert mb-8 success">{{ Session::get('message') }}</div>
    @endif
    <div class="">
        <table class="table w-full">
            <thead>
              <tr class="">
                <th>Image</th>
                <th>Name</th>
                <th>Title</th>
                <th>Status</th>
                <th>Link</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($banners as $data)
                <tr class="">
                    <td>
                        <img src="{{ $data->img_src }}" alt="Bannaer" class="w-16 h-16">
                    </td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->title }}</td>
                    <td>{{ $data->status }}</td>
                    <td>{{ $data->link }}</td>
                    <td class="text-center">
                        <a class="btn btn-success btn-sm" href="{{ route('admin.brand.banners.edit', $data->id) }}">Edit</a>
                        {{-- <a class="btn btn-primary btn-sm" href="{{ route('admin.medical.device.banners.show', $data->id) }}">Show</a> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- ========Pagination============ --}}
        {{-- @if ($result->hasPages())
            <div class="mt-8 bg-gray-200 p-2 pl-4 rounded-md">
                {{ $result->links('vendor.pagination.tailwind', ['order' => request()->get('order')]) }}
            </div>
        @endif --}}
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

