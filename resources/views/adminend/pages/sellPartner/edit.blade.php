@extends('adminend.layouts.default')
@section('title', 'Sell Partner')
@section('content')
<section class="page">
    {{-- Page header --}}
    <div class="page-toolbar">
        <h6 class="title">Edit Sell Partner</h6>
        <div class="actions">
            <a href="{{ route('admin.sell-partners.index') }}" class="action btn btn-primary">Sell Partners</a>
        </div>
    </div>
    <div class="page-content">
        <div class="lg:w-[500px] xl:w-[800px] mx-auto">
            <div class="card shadow">
                <div class="body p-4">
                    <form action="{{ route('admin.sell-partners.update', $sellPartner->id) }}" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="">
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ $sellPartner->name }}" class="form-input" />
                                    @error('name')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Contact Name</label>
                                    <input type="text" name="contact_name" value="{{ $sellPartner->contact_name }}" class="w-full form-input">
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="form-item w-full">
                                    <label for="" class="form-label">Contact Number</label>
                                    <input type="text" name="contact_number" value="{{ $sellPartner->contact_number }}" class="w-full form-input">
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary mt-2">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
