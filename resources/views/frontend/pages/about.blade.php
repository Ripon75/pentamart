@extends('frontend.layouts.default')
@section('title', 'About')
@section('content')
    <section class="page-section page-top-gap">
        <div class="container sm:container md:container lg:px-24 xl:px-52 2xl:px-56">
            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2 gap-4 items-center">
                <div class="text-justify">
                    <p class="mb-3 text-sm md:text-base">Lorem text here</p>
                    <p class="text-sm md:text-base">
                        Lorem text here
                    </p>
                    <div class="mt-6 flex text-sm md:text-base">
                        <span><strong class="">Trade License Number :</strong></span>
                        <span>12121212121</span>
                    </div>
                    <p class="text-sm md:text-base">
                        <strong>TIN :</strong> 111111111111
                    </p>
                    <p class="text-sm md:text-base">
                        <strong>BIN :</strong> 111111111
                    </p>
                </div>
                {{-- <div class="grid place-items-center">
                    <img class="w-[80%]" src="./images/sample/pharmacy.png">
                </div> --}}
            </div>
        </div>
    </section>

@endsection
