<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="{{asset('backend/assets/modules/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('backend/assets/modules/fontawesome/css/all.min.css')}}">

        <!-- CSS Libraries -->
        <link rel="stylesheet" href="{{asset('backend/assets/modules/jqvmap/dist/jqvmap.min.css')}}">
        <link rel="stylesheet" href="{{asset('backend/assets/modules/weather-icon/css/weather-icons.min.css')}}">
        <link rel="stylesheet" href="{{asset('backend/assets/modules/weather-icon/css/weather-icons-wind.min.css')}}">
        <link rel="stylesheet" href="{{asset('backend/assets/modules/summernote/summernote-bs4.css')}}">

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{asset('backend/assets/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('backend/assets/css/components.css')}}">
        <!-- Start GA -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
        </script>

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />
        <div class="main-sidebar sidebar-style-2 shadow-lg">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
        <a href="index.html" style="line-height: 1;">IVESS <br><span style="line-height: 1;">formulario</span></a>
    </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="index.html">IVS</a>
                </div>
                <ul class="sidebar-menu">
                    <li class="menu-header">Dashboard</li>
                    <li class="dropdown active">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('dashboard') }}">General Dashboard</a>
                            </li>
                            <li class="{{ request()->is('form') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('form') }}">Formulario</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown active">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Cambio de Precios</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->is('form.precio') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('form.precio') }}">Formulario Cambio de Precios</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                </div>
            </aside>
        </div>
                  
                </div>
            </div>
              
            
            @livewire('navigation-menu')
            
            <main class="main-content">
                {{$slot}}
            </main>
            

            <!-- Page Content -->
        

        @stack('modals')

        
        @livewireScripts
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <!-- General JS Scripts -->
        <script src="{{asset('backend/assets/modules/jquery.min.js')}}"></script>
        <script src="{{asset('backend/assets/modules/popper.js')}}"></script>
        <script src="{{asset('backend/assets/modules/tooltip.js')}}"></script>
        <script src="{{asset('backend/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
        <script src="{{asset('backend/assets/modules/moment.min.js')}}"></script>
        <script src="{{asset('backend/assets/js/stisla.js')}}"></script>
        
        <!-- JS Libraies -->
        <script src="{{asset('backend/assets/modules/simple-weather/jquery.simpleWeather.min.js')}}"></script>
        <script src="{{asset('backend/assets/modules/chart.min.js')}}"></script>
        <script src="{{asset('backend/assets/modules/jqvmap/dist/jquery.vmap.min.js')}}"></script>
        <script src="{{asset('backend/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
        <script src="{{asset('backend/assets/modules/summernote/summernote-bs4.js')}}"></script>
        <script src="{{asset('backend/assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

        <!-- Page Specific JS File -->
        <script src="{{asset('backend/assets/js/page/index-0.js')}}"></script>
        
        <!-- Template JS File -->
        <script src="{{asset('backend/assets/js/scripts.js')}}"></script>
        <script src="{{asset('backend/assets/js/custom.js')}}"></script>
    </body>
</html>
