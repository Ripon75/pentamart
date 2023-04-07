@extends('frontend.layouts.default')
@section('title', 'Forbidden')
@section('content')
{{-- =======403 page====--}}
<section class="">
    <div class="container page-section page-top-gap">
        <div class="card w-full md:w-full lg:w-[512px] mx-auto text-center py-16 rounded-lg border shadow-sm">
            <h1 class="text-4xl sm:text-4xl md:text-6xl lg:text-9xl font-bold text-primary">4<span class="text-secondary">0</span>3</h1>
            <div class="mt-2 text-base sm:text-base lg:text-xl">You do not have access right to the content.</div>
            <div class="">
                <a href="{{ route('home') }}" type="button" class="btn btn-sm btn-primary mt-4">Go Back</a>
            </div>
        </div>
    </div>
</section>

@endsection
