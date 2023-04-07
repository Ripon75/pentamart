@extends('frontend.layouts.default')
@section('title', 'Components')
@section('content')

<section class="page-section">
    <div class="container bg-white p-8">
        <h1 class="text-2xl">Buttons:</h1>
        <div class="py-4">
            <button class="btn">Submit</button>
            <button class="btn btn-primary">Submit</button>
            <button class="btn btn-secondary">Submit</button>
            <button class="btn btn-success">Submit</button>
            <button class="btn btn-ghost">Submit</button>
        </div>
        <div class="py-4">
            <button class="btn btn-sm">Submit</button>
            <button class="btn">Submit</button>
            <button class="btn btn-lg">Submit</button>
            <button class="btn btn-xl">Submit</button>
        </div>
        <div class="py-4">
            <button class="btn btn-sm btn-rounded">Submit</button>
            <button class="btn btn-rounded">Submit</button>
            <button class="btn btn-lg btn-rounded">Submit</button>
            <button class="btn btn-xl btn-rounded">Submit</button>
        </div>
        <div class="py-4">
            <button class="btn btn-sm btn-rounded-none">Submit</button>
            <button class="btn btn-rounded-none">Submit</button>
            <button class="btn btn-lg btn-rounded-none">Submit</button>
            <button class="btn btn-xl btn-rounded-none">Submit</button>
        </div>
        <div class="py-4">
            <button class="btn btn-icon-only btn-sm">
                <i class="icon fa-solid fa-play"></i>
            </button>
            <button class="btn btn-icon-only">
                <i class="icon fa-solid fa-play"></i>
            </button>
            <button class="btn btn-icon-only btn-lg">
                <i class="icon fa-solid fa-play"></i>
            </button>
            <button class="btn btn-icon-only btn-xl">
                <i class="icon fa-solid fa-play"></i>
            </button>
        </div>
        <div class="py-4">
            <button class="btn btn-icon btn-sm">
                <i class="icon fa-solid fa-play"></i> Play
            </button>
            <button class="btn btn-icon">
                <i class="icon fa-solid fa-play"></i> Play
            </button>
            <button class="btn btn-icon btn-lg">
                <i class="icon fa-solid fa-play"></i> Play
            </button>
            <button class="btn btn-icon btn-xl">
                <i class="icon fa-solid fa-play"></i> Play
            </button>
        </div>
        <div class="py-4 w-[512px]">
            <button class="btn btn-block">Submit</button>
        </div>
    </div>
</section>

@endsection
