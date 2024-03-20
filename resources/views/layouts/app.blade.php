<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>IVSForm</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Icono de formulario -->
        <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23000000'%3E%3Cpath d='M2 3v18h20V3H2zm1 1h18v16H3V4zm8 5v2h6V9h-6zm0 4v2h6v-2h-6zm0 4v2h6v-2h-6zM5 9h2v2H5V9zm0 4h2v2H5v-2zm0 4h2v2H5v-2z'/%3E%3C/svg%3E">

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
                    <a href="{{ route('dashboard') }}" style="line-height: 1;">IVESS <br><span style="line-height: 1;">formulario</span></a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="{{ route('dashboard') }}">IVS</a>
                </div>
                <ul class="sidebar-menu">
                    <li class="menu-header">Dashboard</li>
                    <li class="dropdown {{ request()->routeIs('dashboard')  ? 'active' : ''  }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('dashboard') }}">General Dashboard</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown {{ request()->routeIs('registro.precio') || request()->routeIs('form.precio') ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Cambio de Precios</span></a>
                        <ul class="dropdown-menu">
                            @can('editar-form-productos')
                            <li class="{{ request()->routeIs('form.precio') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('form.precio') }}">Form Cambio de Precios</a>
                            </li>
                            @endcan
                            @can('registrar-productos')
                            <li class="{{ request()->routeIs('registro.precio') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('registro.precio') }}">Registrar Precios</a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @can('crear-formularios')
                        <li class="dropdown {{ request()->routeIs('form.siniestros') || request()->routeIs('registro.siniestros') ? 'active' : '' }}">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Siniestros</span></a>
                            <ul class="dropdown-menu">
                                <li class="{{ request()->routeIs('form.siniestros') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('form.siniestros') }}">Formulario de Siniestros</a>
                                </li>
                                <li class="{{ request()->routeIs('registro.siniestros') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('registro.siniestros')}}">Registros de Siniestros</a>
                                </li>
                            </ul>
                        </li>
                    @endcan
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
            
            <footer class="main-footer">
                <div class="footer-left">
                    Todos los derechos reservados - Área de Sistemas, Ivess El Jumillano &copy; <?php echo date("Y"); ?>
                </div>
            </footer>
        
        @stack('modals')

        
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
        @livewireScripts
    </body>
</html>
