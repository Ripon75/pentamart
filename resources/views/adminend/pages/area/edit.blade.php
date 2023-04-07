@extends('adminend.layouts.default')
@section('title', 'Area Edit')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Area</h6>
        <div class="actions">
            <a href="{{ route('admin.areas.index') }}" class="action btn btn-primary">Areas</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="lg:w-[500px] xl:w-[500px] mx-auto">
                @if(Session::has('error'))
                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                @endif

                @if(Session::has('message'))
                    <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                @endif
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.areas.update', $area->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-item ">
                                <label class="form-label">Name</label>
                                <input type="text" value="{{ $area->name }}" name="name" class="form-input" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
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
        }, 4000 );
    </script>
@endpush
