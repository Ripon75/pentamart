@extends('frontend.layouts.default')
@section('title', 'My-Address')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            <div class="col-span-4">

                 @if(Session::has('success'))
                    <div class="alert mb-8 success">{{ Session::get('success') }}</div>
                @endif

                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                @endif

                <div class="card p-0 sm:p-0 md:p-2 lg:p-4 xl:p-4 2xl:p-4">
                    <div class="w-full overflow-x-scroll">
                        <table class="table-auto w-full text-xs sm:text-xs md:text-sm">
                            <thead class="">
                                <tr class="bg-secondary">
                                    <th class="text-left border p-2">Title</th>
                                    <th class="text-left border p-2">Address</th>
                                    <th class="text-left border p-2">Phone</th>
                                    <th class="text-left border p-2">Area</th>
                                    <th class="text-center border p-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $data)
                                <tr>
                                    <td class="border p-2">{{ $data->title }}</td>
                                    <td class="border p-2">{{ $data->address }}</td>
                                    <td class="border p-2">{{ $data->phone_number }}</td>
                                    <td class="border p-2">{{ ($data->area->name) ?? null }}</td>
                                    <td class="text-center border p-2">
                                        <a href="{{ route('my.address.create') }}" class="text-center btn btn-success px-2 py-1">Create</a>
                                        <a href="{{ route('my.address.edit', $data->id) }}" class="text-center btn btn-primary px-2 py-1">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script>
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 5000 );
    </script>
@endpush

