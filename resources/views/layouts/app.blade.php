<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Aspersiones - SaraPalma')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/image.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/image.png') }}">
    @if (file_exists(public_path('vendor/bootstrap/css/bootstrap.min.css')))
        <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    @endif
    @if (file_exists(public_path('vendor/fontawesome/css/all.min.css')))
        <link href="{{ asset('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
    @else
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" crossorigin="anonymous">
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Sidebar layout: fixed on md+ and offcanvas on small screens */
        .sidebar-fixed {
            width: 240px;
            background-color: #fff !important;
        }
        @media(min-width: 768px) {
            /* Make the sidebar fixed so it doesn't push content down */
            .sidebar-fixed {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                overflow-y: auto;
                z-index: 1040;
                background: #fff !important;
            }

            .content-wrapper {
                margin-left: 240px;
                width: calc(100% - 240px);
                box-sizing: border-box;
                min-height: 100vh;
            }

            .sidebar-offcanvas {
                display: none !important;
            }
        }
        @media(max-width: 767.98px) {
            .sidebar-fixed {
                display: none;
            }
        }
        /* Top navbar for user profile */
        .top-navbar {
            background-color: #27ae60;
            border-bottom: 1px solid #1e8449;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .user-profile-dropdown {
            position: relative;
        }
        .user-profile-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .user-profile-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }
        /* Prevent table overflow issues by allowing horizontal scroll when needed */
        .table-responsive { overflow-x: auto; }
        
        /* Sidebar text colors */
        .sidebar-fixed {
            color: #27ae60;
        }
        .sidebar-fixed .nav-link {
            color: #27ae60 !important;
            font-weight: 500;
        }
        .sidebar-fixed .nav-link:hover {
            color: #fff !important;
            background-color: #27ae60;
            border-radius: 4px;
        }
        .sidebar-fixed .nav-link.active {
            color: #fff !important;
            background-color: #27ae60;
            border-radius: 4px;
        }
        .sidebar-fixed hr {
            border-color: #27ae60;
        }
        .sidebar-fixed strong {
            color: #27ae60;
        }
        .sidebar-fixed .text-muted {
            color: #95a5a6 !important;
        }
        .sidebar-fixed .navbar-brand {
            color: #27ae60 !important;
            font-weight: 700;
        }
    </style>
    @stack('styles')
</head>
<body>
    @if(auth()->check() || session('finca_logged'))
    <!-- Offcanvas for small screens -->
    <div class="offcanvas offcanvas-start sidebar-offcanvas" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Menú</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <aside class="bg-light border-end sidebar-fixed p-3">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-2">
                        <img src="{{ asset('images/image.png') }}" alt="Logo" style="width:48px; height:48px; object-fit:contain;">
                    </div>
                    <div>
                        <strong>Sistema Aspersiones</strong>
                        <div class="small text-muted">SaraPalma</div>
                    </div>
                </div>

                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>

                    @if(auth()->check() && Auth::user() && Auth::user()->isAdmin())
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active fw-bold' : '' }}" href="{{ route('users.index') }}">
                        <i class="fas fa-users me-2"></i>Usuarios
                    </a>
                    <a class="nav-link {{ request()->routeIs('fincas.*') ? 'active fw-bold' : '' }}" href="{{ route('fincas.index') }}">
                        <i class="fas fa-map me-2"></i>Fincas
                    </a>
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active fw-bold' : '' }}" href="{{ route('products.index') }}">
                        <i class="fas fa-flask me-2"></i>Productos
                    </a>
                    <a class="nav-link {{ request()->routeIs('codigos.*') ? 'active fw-bold' : '' }}" href="{{ route('codigos.index') }}">
                        <i class="fas fa-vial me-2"></i>Códigos
                    </a>
                    <a class="nav-link {{ request()->routeIs('mezclas.*') ? 'active fw-bold' : '' }}" href="{{ route('mezclas.index') }}">
                        <i class="fas fa-flask me-2"></i>Mezclas
                    </a>
                    @endif

                    <a class="nav-link {{ request()->routeIs('aspersions.*') ? 'active fw-bold' : '' }}" href="{{ route('aspersions.index') }}">
                        <i class="fas fa-spray-can me-2"></i>Aspersiones
                    </a>
                </nav>

                <hr>
            </aside>
        </div>
    </div>

    <!-- Fixed sidebar for md+ screens -->
    <aside class="bg-light border-end sidebar-fixed d-none d-md-block">
        <div class="p-3">
            <div class="d-flex align-items-center mb-3">
                <div class="me-2">
                    <img src="{{ asset('images/image.png') }}" alt="Logo" style="width:48px; height:48px; object-fit:contain;">
                </div>
                <div>
                    <strong>Sistema Aspersiones</strong>
                    <div class="small text-muted">SaraPalma</div>
                </div>
            </div>

            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>

                @if(auth()->check() && Auth::user() && Auth::user()->isAdmin())
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active fw-bold' : '' }}" href="{{ route('users.index') }}">
                    <i class="fas fa-users me-2"></i>Usuarios
                </a>
                <a class="nav-link {{ request()->routeIs('fincas.*') ? 'active fw-bold' : '' }}" href="{{ route('fincas.index') }}">
                    <i class="fas fa-map me-2"></i>Fincas
                </a>
                <a class="nav-link {{ request()->routeIs('products.*') ? 'active fw-bold' : '' }}" href="{{ route('products.index') }}">
                    <i class="fas fa-flask me-2"></i>Productos
                </a>
                <a class="nav-link {{ request()->routeIs('codigos.*') ? 'active fw-bold' : '' }}" href="{{ route('codigos.index') }}">
                    <i class="fas fa-vial me-2"></i>Códigos
                </a>
                <a class="nav-link {{ request()->routeIs('mezclas.*') ? 'active fw-bold' : '' }}" href="{{ route('mezclas.index') }}">
                    <i class="fas fa-flask me-2"></i>Mezclas
                </a>
                @endif

                <a class="nav-link {{ request()->routeIs('aspersions.*') ? 'active fw-bold' : '' }}" href="{{ route('aspersions.index') }}">
                    <i class="fas fa-spray-can me-2"></i>Aspersiones
                </a>
            </nav>

            <hr>
        </div>
    </aside>

    <div class="content-wrapper">
        <!-- Top navbar with user profile on right -->
        <nav class="navbar navbar-expand top-navbar">
            <div class="container-fluid">
                <div class="d-md-none">
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <span class="navbar-text grow ps-2 fw-bold d-none d-md-inline" style="color: #fff;">Sistema Aspersiones</span>
                
                <!-- User profile dropdown on the right -->
                <div class="user-profile-dropdown dropdown">
                    <a class="user-profile-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle fa-lg me-2"></i>
                        <span>{{ session('finca_logged') ? session('finca_name') : Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if(!session('finca_logged'))
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-circle me-2"></i>Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="dropdown-item w-100 text-start"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container-fluid p-4">
            @yield('content')
        </main>
    </div>
    @else
    <main class="container mt-4">
        @yield('content')
    </main>
    @endif


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @if(session('welcome_message'))
    <script>
        const isFirstLogin = {{ session('is_first_login') ? 'true' : 'false' }};
        const isFincaLogin = {{ session('is_finca_login') ? 'true' : 'false' }};
        const timeout = isFirstLogin ? 10000 : (isFincaLogin ? 8000 : 6000);
        
        Swal.fire({
            title: isFincaLogin ? '¡Bienvenida Finca!' : '¡Bienvenido!',
            text: '{{ session('welcome_message') }}',
            icon: 'success',
            timer: timeout,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
    @endif

    @if(session('success'))
    <script>
        @if(session('codigo_confirmacion'))
        Swal.fire({
            title: '¡Éxito!',
            html: '{{ session('success') }}<br><br><strong>Código de Confirmación:</strong><br><span style="font-size: 1.5em; color: #198754; font-weight: bold;">{{ session('codigo_confirmacion') }}</span>',
            icon: 'success',
            confirmButtonText: 'Entendido',
            allowOutsideClick: false
        });
        @else
        Swal.fire({
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: 6000,
            timerProgressBar: true,
            showConfirmButton: false
        });
        @endif
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            title: 'Error',
            text: '{{ session('error') }}',
            icon: 'error',
            timer: 6000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
    @endif

    @if($errors->any())
    <script>
        let errorMessages = @json($errors->all());
        Swal.fire({
            title: 'Error de Validación',
            html: errorMessages.map(error => `• ${error}`).join('<br>'),
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
    </script>
    @endif

    @stack('scripts')
    
    <!-- Footer -->
    <footer class="text-center text-muted py-3 mt-4" style="background-color: #f8f9fa; border-top: 1px solid #dee2e6;">
        <small>Desarrollado por <strong style="color: #27ae60;">Zareth Fuentes</strong> © 2025</small>
    </footer>
</body>
</html>
