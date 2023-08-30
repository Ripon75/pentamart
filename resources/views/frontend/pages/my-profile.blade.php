@extends('frontend.layouts.default')
@section('title', 'My-Profile')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            <div class="col-span-3">
                <div class="card p-4">
                    <div class="">
                        <form class="flex flex-col w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2" action="{{ route('my.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if(Session::has('message'))
                                <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                            @endif

                            @if(Session::has('error'))
                            <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                            @endif

                           <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-input" value="{{ $user->name }}"/>
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                           </div>
                           <div class="form-item">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-input" value="{{ $user->email }}"/>
                           </div>
                           <div class="form-item">
                                <label class="form-label">Contact Number</label>
                                <input type="number" class="form-input" value="{{ $user->phone_number }}" readonly/>
                           </div>
                            <div class="form-item">
                                <div class="mt-1 text-right">
                                    <button type="submit" class="btn btn-md btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
