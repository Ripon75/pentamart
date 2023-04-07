@extends('frontend.layouts.default')
@section('title', 'Not Found')
@section('content')

    <!--========NOt found========-->
    <section class="page-section page-top-gap">
        <div class="container">
            <div class="card shadow-sm mx-auto w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2 p-8 flex flex-col items-center">
                <div class="bg-white p-6  md:mx-auto">
                    <div class="mx-auto w-48 h-48 flex items-center justify-center">
                        <img class="" src="/images/icons/no-product-found.jpg">
                    </div>
                    <div class="text-center mt-4">
                        <p class="my-2 text-xl">No Products Found...</p>
                        <div class="mt-4">
                            <a href="{{ route('home') }}" type="button" class="btn btn-md btn-primary hover:text-white">Go Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
