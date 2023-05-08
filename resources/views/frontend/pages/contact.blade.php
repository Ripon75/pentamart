@extends('frontend.layouts.default')
@section('title', 'Contact')
@section('content')

    <section class="page-section page-top-gap">
        <div class="">
            <section class="text-gray-600 body-font relative">
            <div class="container mx-auto flex sm:flex-nowrap flex-wrap">
                <div class="lg:w-2/3 md:w-1/2 bg-gray-300 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative">
                    <div class="bg-white relative flex flex-wrap py-6 rounded shadow-lg">
                        <div class="lg:w-1/2 px-6">
                            <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs">ADDRESS</h2>
                            <p class="mt-1">Your office address</p>
                        </div>
                        <div class="lg:w-1/2 px-6 mt-4 lg:mt-0">
                            <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs">EMAIL</h2>
                            <a class="text-indigo-500 leading-relaxed">contact@pentamart.com</a>
                            <h2 class="title-font font-semibold text-gray-900 tracking-widest text-xs mt-4">Phone</h2>
                            <div class="leading-relaxed">
                                <span><a href="tel:+8801100000000">+8801100000000</a></span>,
                                <span><a href="tel:+8801200000000">+8801200000000</a></span>,
                                <span><a href="tel:+8801300000000">+8801300000000</a></span>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full py-4 md:py-8 mt-8 md:mt-0 px-8 shadow-md">
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Feedback</h2>
                    <p class="leading-relaxed mb-5 text-sm text-gray-600">We want to hear from you. Please send us message.</p>
                    <div class="relative mb-4">
                        <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
                        <input type="text" id="name" name="name" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                        <input type="email" id="email" name="email" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                    <div class="relative mb-4">
                        <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
                        <textarea id="message" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                    </div>
                    <button class="btn btn-primary">Submit</button>
                </div>
            </div>
            </section>
        </div>
    </section>

@endsection
