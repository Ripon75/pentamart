<div>
    @if ($type === 'default')
        <div class="relative h-[272px] sm:h-[220x] md:h-[440px] lg:h-[440px] xl:h-[440px] 2xl:h-[440px] rounded-md p-4 hover:scale-105 transition duration-300 ease-in-out"
            style="background-color:{{ $bgColor }}">
            <a href="{{ $postTitleLink }}" class="block overflow-auto">
                <h4 class="uppercase text-xs md:text-sm text-blue-500">{{ $preTitle }}</h4>
                <h2 class="text-sm md:text-2xl xl:text-3xl font-bold my-1 text-blue-900">{{ $title }}</h2>

                <div class="font-medium text-xs md:text-sm">
                    <span class="">{{ $postTitle }}</span>
                    <span class="ml-2"><i class="fa-regular fa-circle-right"></i></span>
                </div>


                <div class="absolute bottom-0 right-0 p-2 md:p-4">
                    <div class="w-32 h-32 sm:w-32 sm:h-32 md:w-60 md:h-60 z-10 bg-white rounded-full">
                    </div>
                </div>



                {{-- <div class="absolute bottom-0 right-0 p-2 md:p-4" style="overflow: hidden;">
                    <div class="w-32 h-16 sm:w-32 sm:h-16 md:w-60 md:h-30 z-10">
                        <div class="bg-red-500 h-full rounded-full"></div>
                    </div>
                </div> --}}

                <div class="absolute bottom-0 right-0 z-20 p-4 sm:p-4 md:p-8">
                    <img class="pl-0 sm:pl-0 md:pl-6 w-32 h-32 sm:w-32 sm:h-32 md:w-64 md:h-64 object-contain"
                        src="{{ $imgSrc }}" />
                </div>
            </a>
        </div>
    @elseif ($type === 'category')
        <div class="rounded-md border p-4" style="background-color:{{ $bgColor }}">
            <div class="text-center py-4 rounded-t-md">
                <h1 class="text-xl font-medium">{{ $title }}</h1>
            </div>
            <div class="aspect-w-1 aspect-h-1">
                <img class="p-12 w-full h-full" src={{ $imgSrc }}>
            </div>
            <a herf="{{ $postTitleLink }}" class="block text-center py-4 rounded-b-md">{{ $postTitle }}
                <span class="ml-1"><i class="fa-solid fa-arrow-right"></i></span></a>
        </div>
    @elseif ($type === 'brand')
        <div class="service-new">
            <div
                class="grid grid-cols-2 justify-items-center border bg-white p-2 sm:p-2 md:p-4 xl:p-4 2xl:p-4 rounded-md shadow-sm hover:shadow">
                <div class="flex flex-col items-center justify-center space-y-2">
                    <div class="title">
                        <span
                            class="text-base lg:text-base xl:text-lg 2xl:text-lg text-primary font-semibold">{{ $title }}</span>
                    </div>
                    <div class="">
                        <a href="{{ $postTitleLink }}" type="button" class="btn btn-md btn-primary">
                            {{ $postTitle }}
                        </a>
                    </div>
                </div>
                <div class="img-wrapper">
                    <img class="w-[300px] h-[180px]" src="{{ $imgSrc }}">
                </div>
            </div>
        </div>
    @elseif ($type === 'categories-banner')
        <a href="{{ $postTitleLink }}" class="">
            <div
                class="flex flex-col items-center justify-center space-y-6 border border-gray-200 rounded-md shadow hover:shadow-md">
                <div class="pt-4">
                    <img class="h-48 w-full bg-contain" src={{ $imgSrc }}>
                </div>
                <div class="text-center w-full bg-gray-200 py-2">
                    <span class="text-primary font-medium text-lg">{{ $title }}</span>
                </div>
            </div>
        </a>
    @elseif ($type === 'brands-banner')
        <a href="{{ $postTitleLink }}" class="">
            <div class="flex flex-col items-center justify-center border shadow-sm hover:shadow-md rounded-2xl">
                <div class="">
                    <div class="w-[140px] h-[140px] sm:w-[140px] sm:h-[140px] md:w-[254px] md:h-[254px]">
                        <img class="w-full h-full" src="{{ $imgSrc }}" />
                    </div>
                </div>
                {{-- <div class="w-full border-t">
                <div class="text-center p-2">
                    <span class="text-secondary text-sm">{{ $title }}</span>
                </div>
            </div> --}}
            </div>
        </a>
    @else
        <div class="service-card">
            <div class="header">
                <h1 class="title">{{ $title }}</h1>
            </div>
            <div class="body">
                <div class="img-wrapper">
                    <img class="img" src="{{ $imgSrc }}">
                </div>
            </div>
            <div class="footer mt-2">
                <a href="{{ $postTitleLink }}" class="btn btn-primary sm:btn btn-sm text-sm">
                    {{ $postTitle }}
                </a>
            </div>
        </div>
    @endif
</div>
