@extends('frontend.layouts.default')
@section('title', 'Payment Done')
@section('content')

<!--========Payment Done========-->
    <section class="page-section page-top-gap">
        <div class="container">
            <div class="card shadow-sm mx-auto w-full sm:w-full md:w-full lg:w-1/2 xl:w-1/2 2xl:w-1/2 p-8 flex flex-col items-center">
                <div class="bg-white p-6  md:mx-auto">
                    <svg viewBox="0 0 24 24" class="text-green-600 w-16 h-16 mx-auto my-6">
                        <path fill="currentColor"
                            d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z">
                        </path>
                    </svg>
                    <div class="text-center mt-4">
                        <h3 class="md:text-2xl text-base text-gray-900 font-semibold text-center">Payment Done!</h3>
                        <p class="text-gray-600 my-2">Thank you for your payment.</p>
                        <div class="mt-4">
                            <a href="{{ route('home') }}" type="button" class="btn btn-md btn-primary hover:text-white">Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
