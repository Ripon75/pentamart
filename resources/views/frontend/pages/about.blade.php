@extends('frontend.layouts.default')
@section('title', 'About')
@section('content')

<!--========Category Banner========-->
    <section class="page-top-gap">
        <x-frontend.header-title
            bgColor="linear-gradient( #112f7a, rgba(111, 111, 211, 0.52))"
            bgImageSrc="/images/banners/home-banner.jpg"
            title="About"
        />
    </section>

    <section class="page-section">
        <div class="container sm:container md:container lg:px-24 xl:px-52 2xl:px-56">
            <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2 gap-4 items-center">
                <div class="text-justify">
                    <p class="mb-3 first-letter:text-4xl text-sm md:text-base"><strong>Medicart e-commerce platform is online healthcare, medicine, and wellness E-Commerce that deals with B2C platforms.</strong> Medicart E-commerce platform is the fastest medicine delivery e-commerce platform in Bangladesh.</p>
                    <p class=" text-sm md:text-base">
                        “Medicart” e-commerce platform is not only opted to do providing medicine e-commerce service but also an integrated system of building data analysis algorithm. This E-Commerce is integrated with our POS Software to deliver the best service possible. Through the integrated solutions, the architecture of MediPOS pharmacy management software and Medicart e-commerce system sales data is accumulated in the central database system in a conventional approach.
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
                <div class="grid place-items-center">
                    <img class="w-[80%]" src="./images/sample/pharmacy.png">
                </div>
            </div>
        </div>
    </section>

@endsection
