@extends('adminend.layouts.default')
@section('title', 'Offers')
@section('content')
<div class="page">
    <div class="page-toolbar">
        <h6 class="title">Edit Offer</h6>
        <div class="actions">
            <a href="{{ route('admin.offers.index') }}" class="action btn btn-primary">Offers</a>
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <div class="my-16 lg:w-[500px] xl:w-[500px] mx-auto">
                <div class="card shadow">
                    <div class="body p-4">
                        <form action="{{ route('admin.offers.update', $offer->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-item">
                                <label class="form-label">Title</label>
                                <input type="text" value="{{ $offer->title }}" name="title" class="form-input" />
                                @error('title')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Offer Percent</label>
                                <input type="number" value="{{ $offer->offer_percent }}" name="offer_percent" class="form-input" />
                                @error('offer_percent')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select w-full form-input" name="status">
                                    <option value="active">Select</option>
                                    <option value="active" {{ $offer->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $offer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-item">
                                <label for="" class="form-label">Image</label>
                                <input type="file" name="img_src" class="w-full">
                                @if ($offer->img_src)
                                    <img class="w-28 h-28 mt-2" src="{{ $offer->img_src }}" alt="{{ $offer->name }}">
                                @endif
                                @error('img_src')
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
