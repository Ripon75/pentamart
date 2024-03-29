@extends('frontend.layouts.default')
@section('title', 'Submitted')
@section('content')

<section class="container page-section page-top-gap">
    <div class="card p-8">
        <div class="flex flex-col items-center justify-center">
            <div class="mt-8 text-center">
                <h1 class="text-4xl font-medium tracking-wide text-primary">Thank your for your order<span class="text-green-500"><i class="ml-3 fa-regular fa-circle-check"></i></span></h1>
            </div>
            <a href="/" class="mt-8">
                <button class="btn btn-md btn-primary">Home</button>
            </a>
        </div>
    </div>
</section>

@endsection

