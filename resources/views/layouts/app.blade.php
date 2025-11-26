<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Aspersiones - SaraPalma')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/image.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/image.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>
<body>
    @if(auth()->check() || session('finca_logged'))
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>{{ session('finca_logged') ? session('finca_name') : Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        @if(!session('finca_logged'))
                        <li><a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="fas fa-user-circle me-2"></i>Perfil
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    @endif

    @if(auth()->check() || session('finca_logged'))
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <div class="navbar-nav">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" 
                   href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                </a>
                
                @if(auth()->check() && Auth::user()->isAdmin())
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active fw-bold' : '' }}" 
                   href="{{ route('users.index') }}">
                    <i class="fas fa-users me-1"></i>Usuarios
                </a>
                <a class="nav-link {{ request()->routeIs('fincas.*') ? 'active fw-bold' : '' }}" 
                   href="{{ route('fincas.index') }}">
                    <i class="fas fa-map me-1"></i>Fincas
                </a>
                <a class="nav-link {{ request()->routeIs('products.*') ? 'active fw-bold' : '' }}" 
                   href="{{ route('products.index') }}">
                    <i class="fas fa-flask me-1"></i>Productos
                </a>
                <a class="nav-link {{ request()->routeIs('codigos.*') ? 'active fw-bold' : '' }}" 
                   href="{{ route('codigos.index') }}">
                    <i class="fas fa-vial me-1"></i>Códigos
                </a>
                <a class="nav-link {{ request()->routeIs('mezclas.*') ? 'active fw-bold' : '' }}" 
                   href="{{ route('mezclas.index') }}">
                    <i class="fas fa-flask me-1"></i>Mezclas
                </a>
                @endif
                
                <a class="nav-link {{ request()->routeIs('aspersions.*') ? 'active fw-bold' : '' }}" 
                   href="{{ route('aspersions.index') }}">
                    <i class="fas fa-spray-can me-1"></i>Aspersiones
                </a>
            </div>
        </div>
    </nav>
    @endif

    <main class="container mt-4">
        @yield('content')
    </main>

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
</body>
</html>