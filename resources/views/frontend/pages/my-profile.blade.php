@extends('frontend.layouts.default')
@section('title', 'My-Profile')
@section('content')

    {{-- <section class="container page-top-gap">
        <div class="page-section">
            <h2>My Profile</h2>
            <div
                class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
                <img src="" alt="no image">
                <div class="col-span-3">
                    <div class="card p-4">
                        <div class="">
                            <form class="flex flex-col w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2"
                                action="{{ route('my.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                @if (Session::has('message'))
                                    <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                                @endif

                                @if (Session::has('error'))
                                    <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                                @endif

                                <div class="form-item">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-input" value="{{ $user->name }}" />
                                    @error('name')
                                        <span class="form-helper error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-item">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-input" value="{{ $user->email }}" />
                                </div>
                                <div class="form-item">
                                    <label class="form-label">Contact Number</label>
                                    <input type="number" class="form-input" value="{{ $user->phone_number }}" readonly />
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
    </section> --}}

    {{-- For PC/Laptop View --}}
    <section class="page-section page-top-gap hidden md:hidden lg:block 2xl:block">
        <div class="container">
            <div class="flex">
                <div class="w-[250px] h-[400px]" style="background-color: #fff;">
                    <img class="block mx-auto w-[200px] h-[200px] rounded-full mt-2"
                        src="{{ asset('images/default_profile.png') }}" alt="Profile image loading failed">
                    <h2 class="mt-2 text-center text-sm font-semibold">{{ $user->name }}</h2>
                    <h2 class="text-center text-sm font-normal">
                        <a href="">
                            {{ $user->email }}
                        </a>
                    </h2>
                </div>

                <div style="background-color: #fff; width:600px;" class="ml-[10px] rounded-sm">
                    <h2 class="p-2">Edit Profile</h2>
                    <hr>
                    <div class="p-2">
                        <form class="" action="{{ route('my.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if (Session::has('message'))
                                <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                            @endif

                            @if (Session::has('error'))
                                <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                            @endif

                            <div class="form-item">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-input w-[65%]"
                                    value="{{ $user->name }}" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-input w-[65%]"
                                    value="{{ $user->email }}" />
                            </div>
                            <div class="form-item">
                                <label class="form-label">Contact Number</label>
                                <input type="number" class="form-input w-[65%]" value="{{ $user->phone_number }}"
                                    readonly />
                            </div>
                            <div class="form-item">
                                <div class="mt-1 text-right w-[65%]">
                                    <button type="submit" class="btn btn-md btn-primary w-[25%]">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========= For Mobile View=========== --}}
    <section class="page-section page-top-gap block md:block lg:hidden 2xl:hidden">
        <div class="container">


            <div class="block mx-auto w-full bg-white rounded-sm">
                <div class="mb-10">
                    <div class="">
                        <img class="block mx-auto w-[200px] h-[200px] rounded-full p-4"
                            src="https://www.pngfind.com/pngs/m/468-4686427_profile-demo-hd-png-download.png"
                            alt="">
                    </div>
                    <h2 class="mt-2 text-center text-sm font-semibold">{{ $user->name }}</h2>
                    <h2 class="text-center text-sm font-normal">
                        <a href="">
                            {{ $user->email }}
                        </a>
                    </h2>
                </div>

                <div class="">
                    <h2 class="p-2">Edit Profile</h2>
                    <hr>
                    <div class="p-2">
                        <form class="" action="{{ route('my.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if (Session::has('message'))
                                <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                            @endif

                            @if (Session::has('error'))
                                <div class="alert mb-8 error">{{ Session::get('error') }}</div>
                            @endif

                            <div class="form-item w-[100%] md:w-[65%]">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-input" value="{{ $user->name }}" />
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-item w-[100%] md:w-[65%]">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-input" value="{{ $user->email }}" />
                            </div>
                            <div class="form-item w-[100%] md:w-[65%]">
                                <label class="form-label">Contact Number</label>
                                <input type="number" class="form-input" value="{{ $user->phone_number }}" readonly />
                            </div>
                            <div class="form-item w-[100%] md:w-[65%]">
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
    </section>

@endsection

@push('scripts')
    <script>
        // Set time to flash message
        setTimeout(function() {
            $("div.alert").remove();
        }, 4000);
    </script>
@endpush
