@if ($type === 'default')
<div>
    <div class="banner flex items-center justify-center bg-no-repeat bg-cover bg-opacity-10 h-28 sm:h-28 md:h-36 lg:h-44 xl:h-52 2xl:h-56"
        style="background-image:{{ $bgColor }} ,url('{{ $bgImageSrc }}')">
        <div class="title-wrapper bg-white rounded">
            <h1 class="title py-2 px-4 md:px-8 text-sm md:text-base lg:text-xl xl:text-2xl font-semibold text-center text-primary uppercase">{{ $title }}</h1>
        </div>
    </div>
</div>
@else
    <div class="rounded p-2 sm:p-2 md:p-4 flex-1" style="background-color: {{ $bgColor }};">
        <h1 class="text-lg sm:text-lg md:text-xl font-semibold text-white tracking-wider">{{ $title }}</h1>
    </div>
@endif
