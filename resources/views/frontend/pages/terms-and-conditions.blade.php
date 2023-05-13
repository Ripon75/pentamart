@extends('frontend.layouts.default')
@section('title', 'Terms and Conditions')
@section('content')
    <section class="page-section page-top-gap">
        <section class="container sm:container md:container lg:px-24 xl:px-52 2xl:px-60 text-gray-800">
            {{-- ======English translate============ --}}
            <div id="show" class="mt-4">
                <div class="">
                    <h1 class="text-lg">Welcome to <span class="font-medium">Pentamart</span></h1>
                </div>
                <div class="mt-2 flex flex-col space-y-2 text-justify">
                    <p class="">Lorem</p>
                </div>
                <div class="mt-4">
                    <p class="font-medium mb-2 mt-3">List title</p>
                    <ol class="list-decimal list-inside text-gray-600">
                        <li>A</li>
                        <li>B</li>
                        <li>C</li>
                        <li>D</li>
                    </ol>
                </div>
                <div class="mt-4">
                    <div class="">
                        <h1 class="title font-bold">Price Notice</h1>
                    </div>
                    <p class="mb-2 mt-3">
                        Something
                    </p>
                </div>
            </div>
            {{-- ======./English translate============ --}}
        </section>
    </section>

@endsection
