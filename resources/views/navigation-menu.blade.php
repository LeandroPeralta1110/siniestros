<nav x-data="{ open: false }" class="bg-white border-gray-100 navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
          <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars" style="color: blue;"></i></a></li>
          <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
        <div class="search-element">
          <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
          <button class="btn" type="submit"><i class="fas fa-search"></i></button>
          <div class="search-backdrop"></div>
          <div class="search-result">
            {{-- <div class="search-header">
              Histories
            </div>
            <div class="search-item">
              <a href="#">How to hack NASA using CSS</a>
              <a href="#" class="search-close"><i class="fas fa-times"></i></a>
            </div>
            <div class="search-item">
              <a href="#">Kodinger.com</a>
              <a href="#" class="search-close"><i class="fas fa-times"></i></a>
            </div>
            <div class="search-item">
              <a href="#">#Stisla</a>
              <a href="#" class="search-close"><i class="fas fa-times"></i></a>
            </div>
            <div class="search-header">
              Result
            </div>
            <div class="search-item">
              <a href="#">
                <img class="mr-3 rounded" width="30" src="assets/img/products/product-3-50.png" alt="product">
                oPhone S9 Limited Edition
              </a>
            </div>
            <div class="search-item">
              <a href="#">
                <img class="mr-3 rounded" width="30" src="assets/img/products/product-2-50.png" alt="product">
                Drone X2 New Gen-7
              </a>
            </div>
            <div class="search-item">
              <a href="#">
                <img class="mr-3 rounded" width="30" src="assets/img/products/product-1-50.png" alt="product">
                Headphone Blitz
              </a>
            </div>
            <div class="search-header">
              Projects
            </div>
            <div class="search-item">
              <a href="#">
                <div class="search-icon bg-danger text-white mr-3">
                  <i class="fas fa-code"></i>
                </div>
                Stisla Admin Template
              </a>
            </div>
            <div class="search-item">
              <a href="#">
                <div class="search-icon bg-primary text-white mr-3">
                  <i class="fas fa-laptop"></i>
                </div>
                Create a new Homepage Design
              </a>
            </div> --}}
          </div>
        </div>
      </form>
      <div class="flex justify-between h-16">
        <div class="flex">
            <!-- Logo -->
            {{-- <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-mark class="block h-9 w-auto" />
                </a>
            </div> --}}

            <!-- Navigation Links -->
            
        </div>
    </div>
      {{-- <ul class="navbar-nav navbar-right items-center">
            <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
            <div class="dropdown-header">Messages
              <div class="float-right">
                <a href="#">Mark All As Read</a>
              </div>
            </div>
            <div class="dropdown-list-content dropdown-list-message">
              <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-avatar">
                  <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle">
                  <div class="is-online"></div>
                </div>
                <div class="dropdown-item-desc">
                  <b>Kusnaedi</b>
                  <p>Hello, Bro!</p>
                  <div class="time">10 Hours Ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-avatar">
                  <img alt="image" src="assets/img/avatar/avatar-2.png" class="rounded-circle">
                </div>
                <div class="dropdown-item-desc">
                  <b>Dedik Sugiharto</b>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                  <div class="time">12 Hours Ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-avatar">
                  <img alt="image" src="assets/img/avatar/avatar-3.png" class="rounded-circle">
                  <div class="is-online"></div>
                </div>
                <div class="dropdown-item-desc">
                  <b>Agung Ardiansyah</b>
                  <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                  <div class="time">12 Hours Ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item">
                <div class="dropdown-item-avatar">
                  <img alt="image" src="assets/img/avatar/avatar-4.png" class="rounded-circle">
                </div>
                <div class="dropdown-item-desc">
                  <b>Ardian Rahardiansyah</b>
                  <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                  <div class="time">16 Hours Ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item">
                <div class="dropdown-item-avatar">
                  <img alt="image" src="assets/img/avatar/avatar-5.png" class="rounded-circle">
                </div>
                <div class="dropdown-item-desc">
                  <b>Alfa Zulkarnain</b>
                  <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                  <div class="time">Yesterday</div>
                </div>
              </a>
            </div>
            <div class="dropdown-footer text-center">
              <a href="#">View All <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </li>
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
          <div class="dropdown-menu dropdown-list dropdown-menu-right">
            <div class="dropdown-header">Notifications
              <div class="float-right">
                <a href="#">Mark All As Read</a>
              </div>
            </div>
            <div class="dropdown-list-content dropdown-list-icons">
              <a href="#" class="dropdown-item dropdown-item-unread">
                <div class="dropdown-item-icon bg-primary text-white">
                  <i class="fas fa-code"></i>
                </div>
                <div class="dropdown-item-desc">
                  Template update is available now!
                  <div class="time text-primary">2 Min Ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item">
                <div class="dropdown-item-icon bg-info text-white">
                  <i class="far fa-user"></i>
                </div>
                <div class="dropdown-item-desc">
                  <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                  <div class="time">10 Hours Ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item">
                <div class="dropdown-item-icon bg-success text-white">
                  <i class="fas fa-check"></i>
                </div>
                <div class="dropdown-item-desc">
                  <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                  <div class="time">12 Hours Ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item">
                <div class="dropdown-item-icon bg-danger text-white">
                  <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="dropdown-item-desc">
                  Low disk space. Let's clean it!
                  <div class="time">17 Hours Ago</div>
                </div>
              </a>
              <a href="#" class="dropdown-item">
                <div class="dropdown-item-icon bg-info text-white">
                  <i class="fas fa-bell"></i>
                </div>
                <div class="dropdown-item-desc">
                  Welcome to Stisla template!
                  <div class="time">Yesterday</div>
                </div>
              </a>
            </div>
            <div class="dropdown-footer text-center">
              <a href="#">View All <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
        </li> --}}
        {{-- <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
          <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
          <div class="d-sm-none d-lg-inline-block">Hi, Ujang Maman</div></a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-title">Logged in 5 min ago</div>
            <a href="features-profile.html" class="dropdown-item has-icon">
              <i class="far fa-user"></i> Profile
            </a>
            <a href="features-activities.html" class="dropdown-item has-icon">
              <i class="fas fa-bolt"></i> Activities
            </a>
            <a href="features-settings.html" class="dropdown-item has-icon">
              <i class="fas fa-cog"></i> Settings
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item has-icon text-danger">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </div>
        </li> --}}
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    {{-- <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <x-application-mark class="block h-9 w-auto" />
                        </a>
                    </div> --}}
    
                     <!-- Navigation Links -->
                     @can('crear-usuarios')
                      <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                          <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users')">
                              {{ __('Usuarios') }}
                          </x-nav-link>
                      </div> 
                    @endcan
                </div>
    
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <!-- Teams Dropdown -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="ms-3 relative">
                            <x-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->currentTeam->name }}
    
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>
    
                                <x-slot name="content">
                                    <div class="w-60">
                                        <!-- Team Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Team') }}
                                        </div>
    
                                        <!-- Team Settings -->
                                        <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                            {{ __('Team Settings') }}
                                        </x-dropdown-link>
    
                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-dropdown-link href="{{ route('teams.create') }}">
                                                {{ __('Create New Team') }}
                                            </x-dropdown-link>
                                        @endcan
    
                                        <!-- Team Switcher -->
                                        @if (Auth::user()->allTeams()->count() > 1)
                                            <div class="border-t border-gray-200"></div>
    
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Switch Teams') }}
                                            </div>
    
                                            @foreach (Auth::user()->allTeams() as $team)
                                                <x-switchable-team :team="$team" />
                                            @endforeach
                                        @endif
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
    
                    <!-- Settings Dropdown -->
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}
    
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>
    
                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>
    
                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
    
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif
    
                                <div class="border-t border-gray-200"></div>
    
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
    
                                    <x-dropdown-link href="{{ route('logout') }}"
                                             @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
    
                <!-- Hamburger -->
                <div class="fixed top-0 right-0 z-50">
                  <div class="relative">
                      <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                              <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                              <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                          </svg>
                      </button>
                  </div>
              </div>
            </div>
        </div>
      </ul>

      <div x-show="open" @click.away="open = false" class="fixed inset-0 z-40 overflow-y-auto bg-black bg-opacity-50 sm:hidden">
        <div class="fixed top-0 right-0 h-full flex justify-end py-6 pr-6">
            <div class="relative w-64 h-full bg-white shadow-lg transform translate-x-0 transition-transform duration-300 ease-in-out">
                <!-- Contenido del menú -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('form.siniestros') }}" :active="request()->routeIs('form')">
                        {{ __('form.siniestros') }}
                    </x-responsive-nav-link>
                </div>
    
                <!-- Opciones de configuración responsivas -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <!-- Información del usuario -->
                    <div class="flex items-center px-4">
                        <!-- Foto de perfil -->
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <div class="shrink-0 me-3">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </div>
                        @endif
    
                        <!-- Nombre de usuario y correo electrónico -->
                        <div>
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
    
                    <!-- Opciones de administración de cuenta -->
                    <div class="mt-3 space-y-1">
                        <!-- Enlaces de gestión de cuenta -->
                        <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                            {{ __('Profile') }}
                        </x-responsive-nav-link>
    
                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                                {{ __('API Tokens') }}
                            </x-responsive-nav-link>
                        @endif
    
                        <!-- Autenticación -->
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf
    
                            <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
    
                        <!-- Gestión de equipos -->
                        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                            <div class="border-t border-gray-200"></div>
    
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Team') }}
                            </div>
    
                            <!-- Configuración del equipo -->
                            <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                                {{ __('Team Settings') }}
                            </x-responsive-nav-link>
    
                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                    {{ __('Create New Team') }}
                                </x-responsive-nav-link>
                            @endcan
    
                            <!-- Selector de equipo -->
                            @if (Auth::user()->allTeams()->count() > 1)
                                <div class="border-t border-gray-200"></div>
    
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Switch Teams') }}
                                </div>
    
                                @foreach (Auth::user()->allTeams() as $team)
                                    <x-switchable-team :team="$team" component="responsive-nav-link" />
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
