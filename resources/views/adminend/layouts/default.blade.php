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
        @stack('styles')
    </head>
    <body class="h-screen w-screen">
        <div class="app-layout">
            <aside id="app-sidebar" class="app-sidebar flex flex-col">
                <a href="{{ route('home') }}" class="logo-container">
                    <img class="logo" src="{{ asset('images/adminend/logo.png') }}">
                </a>
                 @php
                    $menus = config('admin.menu');
                @endphp
                <div class="w-60 h-full bg-white overflow-y-auto" id="sidenavSecExample">
                    <ul class="relative px-1">
                        @foreach ($menus as $key => $menu)
                            @ability(true, $menu['permission'])
                                <li class="relative" id="sidenavSecEx2">
                                    <a
                                        @if (!count($menu['sub'])) href="{{ route($menu['route']) }}" @else() href="#" @endif
                                        class="{{ Route::currentRouteName() == $menu['route'] ? 'bg-primary-lightest' : '' }} flex items-center text-sm py-4 px-6 h-12 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out cursor-pointer"
                                        data-mdb-ripple="true"
                                        data-mdb-ripple-color="primary"
                                            @if (count($menu['sub']))
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseSidenavSecEx{{ $key }}"
                                                aria-expanded="false"
                                                aria-controls="collapseSidenavSecEx{{ $key }}"
                                            @endif
                                        >
                                        <span class="mr-3 icon">
                                            @if ($menu['icon'])
                                                <i class="{{ $menu['icon'] }}"></i>
                                            @else
                                                <i class="fa-solid fa-circle"></i>
                                            @endif
                                        </span>
                                        <span>{{ $menu['label'] }}</span>
                                        @if (count($menu['sub']))
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas" class="w-3 h-3 ml-auto" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                <path fill="currentColor" d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path>
                                            </svg>
                                        @endif
                                    </a>
                                    @if (count($menu['sub']))
                                        <ul class="relative accordion-collapse collapse"
                                            id="collapseSidenavSecEx{{ $key }}"
                                            aria-labelledby="sidenavSecEx{{ $key }}"
                                            data-bs-parent="#sidenavSecExample">
                                            @foreach ($menu['sub'] as $sub)
                                                @ability(true, $sub['permission'])
                                                    <li class="relative">
                                                        <a href="{{ route($sub['route']) }}"
                                                            class="flex items-center text-xs py-4 pl-12 pr-6 h-6 overflow-hidden text-gray-700 text-ellipsis whitespace-nowrap rounded hover:text-blue-600 hover:bg-blue-50 transition duration-300 ease-in-out"
                                                            data-mdb-ripple="true" data-mdb-ripple-color="primary">
                                                            {{ $sub['label'] }}
                                                        </a>
                                                    </li>
                                                @endability
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endability
                        @endforeach
                    </ul>
                </div>
            </aside>

            <div class="app-container">
                <header class="app-bar">
                    <div class="px-6 flex items-center h-full">
                        {{-- <button id="btn-hamburger" class="navigation-icon h-12 w-12 flex items-center justify-center">
                            <i class="fa-solid fa-bars"></i>
                        </button> --}}
                        <h1 class="headline flex-1 text-lg font-medium">@yield('title')</h1>
                        <div class="relative group mr-4">
                            <div class="">
                                <a href="#!">
                                <div class="flex items-center">
                                    <div class="shrink-0">
                                    <img src="{{ asset('images/adminend/admin.png') }}" class="rounded-full w-10" alt="Avatar">
                                    </div>
                                    <div class="grow ml-3">
                                    <p class="text-sm font-semibold text-primary">{{ Auth::user()->name ?? null }}</p>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="profile-menu absolute z-30 hidden group-hover:block bg-white shadow-sm py-2 rounded w-36 right-0">
                                <ul class="flex flex-col text-primary">
                                    <a href="" class="text-sm p-2 hover:bg-primary-lightest px-4 transition-all duration-300 ease-in-out">
                                        <i class="mr-3 fa-solid fa-user"></i></i>My Profile
                                    </a>
                                    <a href="" class="text-sm p-2 hover:bg-primary-lightest px-4 transition-all duration-300 ease-in-out">
                                        <i class="mr-3 fa-solid fa-gear"></i>Setting
                                    </a>
                                    <a href="{{ route('logout') }}" class="text-sm p-2 hover:bg-primary-lightest px-4 transition-all duration-300 ease-in-out">
                                        <i class="mr-3 fa fa-sign-out-alt"></i>Logout
                                    </a>
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>
                <main class="app-page-container">
                    @yield('content')
                </main>
            </div>
        </div>
        <!-- Scripts -->
        <script src="{{ mix('js/adminend.js') }}"></script>
        {{-- <script>
            $(function () {
                initAppSidebar();

                $('#btn-hamburger').click(function () {
                    let isMini = localStorage.getItem('app-sidebar-mini');
                    isMini = JSON.parse(isMini);
                    // let isMini = $('#app-sidebar').hasClass('app-sidebar-mini');

                    if (isMini) {
                        $('#app-sidebar').removeClass('app-sidebar-mini');
                        localStorage.setItem('app-sidebar-mini', false);
                    } else {
                        $('#app-sidebar').addClass('app-sidebar-mini');
                        localStorage.setItem('app-sidebar-mini', true);
                    }
                });

                function initAppSidebar() {
                    let isMini = localStorage.getItem('app-sidebar-mini');
                    isMini = JSON.parse(isMini);

                    if (isMini) {
                        $('#app-sidebar').removeClass('app-sidebar-mini');
                    } else {
                        $('#app-sidebar').addClass('app-sidebar-mini');
                    }
                }
            });
        </script> --}}
        @stack('scripts')
    </body>
</html>
