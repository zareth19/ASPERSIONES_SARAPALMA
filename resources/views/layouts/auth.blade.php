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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
            width: 100%;
        }
        
        body {
            overflow-x: hidden;
        }
    </style>
    @stack('styles')
</head>
<body>
    @yield('content')

    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Éxito',
            text: '{{ session('success') }}',
            icon: 'success',
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
