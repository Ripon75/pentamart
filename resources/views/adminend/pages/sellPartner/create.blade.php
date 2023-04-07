@extends('adminend.layouts.default')
@section('title', 'Sell Partner')
@section('content')
<section class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Create Sell Partner</h6>
        <div class="actions">
            <a href="{{ route('admin.sell-partners.index') }}" class="action btn btn-primary">Sell Partners</a>
        </div>
    </div>
    <div class="page-content">
        @if(Session::has('error'))
            <div class="alert mb-8 success">{{ Session::get('error') }}</div>
        @endif
        <div class="lg:w-[500px] xl:w-[800px] mx-auto">
            <div class="card shadow">
                <div class="body p-4">
                    <form action="{{ route('admin.sell-partners.store') }}" method="POST">
                        @csrf

                        <div class="">
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label class="form-label">Name</label>
                                    <input type="text" value="{{ old('name') }}" name="name" class="form-input" />
                                    @error('name')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label class="form-label">Contact Name</label>
                                    <input type="text" value="{{ old('contact_name') }}" name="contact_name" class="form-input" />
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" value="{{ old('contact_number') }}" name="contact_number" class="form-input" />
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary mt-2">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
