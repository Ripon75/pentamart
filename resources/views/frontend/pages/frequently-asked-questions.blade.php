@extends('frontend.layouts.default')
@section('title', 'Frequently Asked Questions')
@section('content')

    <section class="page-section page-top-gap">
        <div class="container sm:container md:container lg:px-24 xl:px-52 2xl:px-60">
            <div class="">
                <div class="accordion" id="accordionExample5">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($questions as $key => $question)
                        <div class="accordion-item bg-white border border-gray-200">
                            <h2 class="accordion-header mb-0" id="headingOne5">
                                <button class="
                                    accordion-button
                                    {{ $i === 0 ? '' : 'collapsed' }}
                                    relative
                                    flex
                                    items-center
                                    w-full
                                    py-4
                                    px-5
                                    text-sm md:text-base text-gray-800 text-left
                                    bg-white
                                    border-0
                                    rounded-none
                                    transition
                                    focus:outline-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}"
                                    aria-controls="collapse{{ $key }}">
                                    {!! $question['q'] !!}
                                </button>
                            </h2>
                            <div id="collapse{{ $key }}" class="accordion-collapse collapse bg-gray-100 text-sm md:text-base {{ $i === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $key }}">
                                <div class="accordion-body py-4 px-5">{!! $question['a'] !!}</div>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
