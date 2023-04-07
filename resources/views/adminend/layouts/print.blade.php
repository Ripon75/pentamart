<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title') - {{ Config::get('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <!-- Styles -->

        {{-- font awesome cdn link --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

        <link rel="stylesheet" href="{{ mix('css/adminend.css') }}">
        {{-- jquery ui --}}
        {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css"> --}}
        @stack('styles')
    </head>
    <body class="bg-gray-300">

        @yield('content')

        {{-- @yield('content') --}}

        <!-- Scripts -->
        <script src="{{ mix('js/adminend.js') }}"></script>
        {{-- jquery ui --}}
        {{-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> --}}
        @stack('scripts')
    </body>
</html>
