@extends('frontend.layouts.default')
@section('title', 'Payment Cancel')
@section('content')

<!--========Payment Cancel========-->
    <section class="page-section page-top-gap">
        <div class="container">
            <div class="card shadow-sm mx-auto w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2 p-8 flex flex-col items-center">
                <div class="bg-white p-6  md:mx-auto">
                    <div class="bg-red-600 w-16 h-16 rounded-full mx-auto flex items-center justify-center">
                        <img class="w-14 h-14 " src="/images/icons/icons8-cross-100.png">
                    </div>
                    <div class="text-center mt-4">
                        <h3 class="md:text-2xl text-base text-gray-900 font-semibold text-center">Payment Cancel!</h3>
                        @if ($message)
                            <h3 class="md:text-2xl text-base text-gray-900 font-semibold text-center">{{ $message }}</h3>
                        @endif
                        <p class="text-gray-600 my-2">Sorry !! your payment is cancle.</p>
                        <div class="mt-4">
                            <a href="{{ route('home') }}" type="button" class="btn btn-md btn-primary hover:text-white">Go Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
