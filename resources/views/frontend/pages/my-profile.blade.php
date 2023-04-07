@extends('frontend.layouts.default')
@section('title', 'My-Profile')
@section('content')

<section class="container page-top-gap">
    <div class="page-section">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 2xl:grid-cols-4 gap-0 sm:gap-0 md:gap-0 lg:gap-4 xl:gap-4 2xl:gap-4">
            {{-- =======List========= --}}
            <div class="col-span-1 hidden sm:hidden md:hidden lg:block xl:block 2xl:block">
                <x-frontend.customer-nav/>
            </div>
            {{-- =============== --}}
            <div class="col-span-3">
                <div class="flex space-x-2 sm:space-x-2 md:space-x-2 lg:space-x-0 xl:space-x-0 2xl:space-x-0">
                    <div class="relative block sm:block md:block lg:hidden xl:hidden 2xl:hidden">
                        <button id="category-menu" onclick="menuToggleCategory()" class="h-[46px] w-14 bg-white flex items-center justify-center rounded border-2 ">
                            <i class="text-xl fa-solid fa-ellipsis-vertical"></i>
                        </button>
                          {{-- ===Mobile menu for order===== --}}
                        <div id="category-list-menu" style="display: none" class="absolute left-0 w-60">
                            <x-frontend.customer-nav/>
                        </div>
                    </div>
                    <div class="mb-4 flex-1">
                        <x-frontend.header-title
                            type="else"
                            title="My Profile"
                            bgImageSrc=""
                            bgColor="#102967"
                        />
                    </div>
                </div>
                <div class="card p-4">
                    <div class="">
                        <form class="flex flex-col w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2" action="{{ route('my.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if(Session::has('message'))
                                <div class="alert mb-8 success">{{ Session::get('message') }}</div>
                            @endif

                            @if(Session::has('failed'))
                            <div class="alert mb-8 error">{{ Session::get('failed') }}</div>
                            @endif

                           {{-- <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    <img class="h-36 w-36 object-cover rounded-full" src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1361&q=80" alt="Current profile photo" />
                                </div>
                                <label class="block">
                                    <input type="file" class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-violet-50 file:text-violet-700
                                        hover:file:bg-violet-100
                                    "/>
                                </label>
                           </div> --}}
                           <div class="form-item">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-input" value="{{ $user->name }}"/>
                                @error('name')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                           </div>
                           <div class="form-item">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-input" value="{{ $user->email }}" readonly/>
                           </div>
                           <div class="form-item">
                                <label class="form-label">Contact Number</label>
                                @if ($user->phone_number)
                                <input type="number" name="phone_number" class="form-input" value="{{ $user->phone_number }}" readonly/>
                                @else
                                <input type="number" name="phone_number" class="form-input" value=""/>
                                @endif
                                @error('number')
                                    <span class="form-helper error">{{ $message }}</span>
                                @enderror
                           </div>
                            <div class="form-item">
                                <label class="form-label">Gender </label>
                                <div class="flex">
                                    <label
                                        class="flex justify-start items-center text-truncate rounded-lg bg-gray-100 pl-4 pr-6 py-2 shadow-sm mr-4">
                                        <div class="text-teal-600 mr-3">
                                            <input type="radio" name="gender" value="male" {{ $user->gender === 'male' ? 'checked' : '' }} class="form-radio focus:outline-none focus:shadow-outline" />
                                        </div>
                                        <div class="select-none text-gray-700">Male</div>
                                    </label>

                                    <label
                                        class="flex justify-start items-center text-truncate rounded-lg bg-gray-100 pl-4 pr-6 py-2 shadow-sm">
                                        <div class="text-teal-600 mr-3">
                                            <input type="radio" name="gender" value="female" {{ $user->gender === 'female' ? 'checked' : '' }} class="form-radio focus:outline-none focus:shadow-outline" />
                                        </div>
                                        <div class="select-none text-gray-700">Female</div>
                                    </label>
                                </div>
                                <div class="mt-4 text-right">
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

@push('scripts')
    <script>
        // Set time to flash message
        setTimeout(function(){
            $("div.alert").remove();
        }, 5000 );

        // Category Menu for Address
        function menuToggleCategory() {
            var categoryList = document.getElementById('category-list-menu');
            if(categoryList.style.display == "none") { // if is menuBox displayed, hide it
                categoryList.style.display = "block";
            }
            else { // if is menuBox hidden, display it
                categoryList.style.display = "none";
            }
        }
    </script>
@endpush
