<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="" />
        <title>@yield('title') - Pentamart</title>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-CFNPPDYKBW"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());

            gtag('config', 'G-CFNPPDYKBW');
        </script> --}}

        {{-- Facebook sdk --}}
        {{-- <script>
            window.fbAsyncInit = function() {
            FB.init({
                xfbml            : true,
                version          : 'v14.0'
            });
            };

            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script> --}}

        <link rel="icon" href="{{ url('favicon.ico') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/frontend.css') }}">
        @stack('styles')
    </head>
    <body>
        <div id="page">
            <x-frontend.header></x-frontend.header>

            <div class="mt-8 sm:mt-8 md:mt-8 lg:mt-14 xl:mt-14 2xl:mt-14">
                @yield('content')
            </div>

            <x-frontend.footer></x-frontend.footer>
        </div>

        <!-- Scripts -->
        <script src="{{ mix('js/frontend.js') }}"></script>
        @stack('scripts')
    </body>
</html>
