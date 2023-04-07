@extends('adminend.layouts.default')
@section('title', 'Upload Prescription')
@section('content')
<div class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title"> Upload Prescription</h6>
        <div class="actions">
            <a href="{{ route('admin.orders.index') }}" class="action btn btn-primary">Orders</a>
        </div>
    </div>
    <div class="page-content">
        <div class="px-8 py-4">
            <div class="py-4 flex items-center justify-between">
                <h3 class="font-bold text-lg">Upload Prescription</h3>
            </div>
            @if(Session::has('error'))
                <div class="alert mb-8 error">{{ Session::get('error') }}</div>
            @endif

            @if(Session::has('message'))
                <div class="alert mb-8 success">{{ Session::get('message') }}</div>
            @endif
            <div>
                <div class="flex justify-center items-center border-2 border-gray-300 border-dashed rounded-lg h-20">
                    <div class="w-1/3">
                        <form action="{{ route('admin.prescription.store', $orderId) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex justify-between items-center">
                                <input name="files[]" multiple type="file" class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border
                                    file:border-secondary/50
                                    file:text-sm file:font-medium
                                    file:bg-violet-50 file:text-secondary
                                    hover:file:bg-violet-100
                                "/>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                @error('files')
                    <span class="form-helper error text-red-400">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 10000 );
    </script>
@endpush
