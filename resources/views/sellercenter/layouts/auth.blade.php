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
        <link rel="stylesheet" href="{{ mix('css/sellercenter.css') }}">
        @stack('styles')
    </head>
    <body class="h-screen w-screen">
        <div class="app-layout">
            <div class="app-container">
                <main class="app-page-container">
                    @yield('content')
                </main>
            </div>
        </div>

        <script src="{{ mix('js/sellercenter.js') }}"></script>
        @stack('scripts')
    </body>
</html>
