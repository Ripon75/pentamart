@extends('frontend.layouts.default')

@section('title', 'Login')

@section('content')
    <!--========Banner start========-->
    <section class="page-top-gap">
        <x-frontend.header-title
            type="default"
            bgColor="linear-gradient( #112f7a, rgba(111, 111, 211, 0.52))"
            bgImageSrc="/images/banners/home-banner.jpg"
            title="Login"
        />
    </section>

    <div class="py-8 px-4">
        <x-frontend.auth-login/>
    </div>

@endsection


