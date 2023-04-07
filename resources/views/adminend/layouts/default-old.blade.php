<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title') - {{ Config::get('app.name') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

        {{-- font awesome cdn link --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/adminend.css') }}">
        {{-- jquery ui --}}
        {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css"> --}}
        @stack('styles')
    </head>
    <body class="h-screen w-screen">

        <div class="h-screen w-screen flex flex-col">
            <div class="w-full h-16 bg-blue-400 flex">
                <div class="w-52 bg-red-400">Logo</div>
                <div class="flex flex-1 justify-between w-full items-center p-4">
                    <div>
                        Header
                    </div>
                    <div>
                        <a href="{{ route('logout') }}" class="bg-white rounded-md py-3 px-4">Logout</a>
                    </div>
                </div>
            </div>
            <div class="flex flex-1">
                <div class="bg-gray-700 h-full w-52 flex">
                    <nav class="flex flex-col w-full mt-8 text-center text-lg">
                        @php
                            $menus = config('admin.menu');
                        @endphp
                        @foreach ($menus as $m)
                            <div class="w-full bg-slate-300 p-2 border-solid border-2 border-indigo-600">
                                <a href="{{ route($m['route']) }}" class="px-2 block">{{ $m['label'] }}</a>
                            </div>
                        @endforeach
                    </nav>
                </div>
                <div class="flex-1 h-full overflow-auto">
                    @yield('content')
                </div>
            </div>
        </div>

        {{-- @yield('content') --}}
        {{-- jquery ui --}}
        {{-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> --}}
        <!-- Scripts -->
        <script src="{{ mix('js/adminend.js') }}"></script>
        @stack('scripts')
    </body>
</html>
