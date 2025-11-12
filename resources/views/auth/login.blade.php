@extends('layouts.app')

@section('title', 'Iniciar Sesión - SaraPalma')

@push('styles')
<style>
body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: url('{{ asset('images/imagenLogin/image.png') }}') no-repeat center center fixed;
    background-size: cover;
}
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 10;
}
.login-card {
    background: rgba(255, 255, 255, 0.7);
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    overflow: hidden;
    max-width: 400px;
    width: 100%;
    padding: 40px 30px;
}
.logo-section {
    text-align: center;
    margin-bottom: 30px;
}
.logo-section img {
    max-height: 80px;
    width: auto;
}
.form-title {
    text-align: center;
    color: #333;
    font-weight: 600;
    font-size: 24px;
    margin-bottom: 30px;
}
.form-group {
    margin-bottom: 20px;
}
.form-label {
    color: #666;
    font-weight: 500;
    margin-bottom: 8px;
    display: block;
    font-size: 14px;
}
.form-control, .form-select {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 12px 15px;
    font-size: 16px;
    width: 100%;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}
.form-control:focus, .form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    outline: none;
}
.form-control::placeholder {
    color: #999;
}
.btn-login {
    background: #28a745;
    border: 1px solid #28a745;
    border-radius: 5px;
    padding: 12px;
    font-size: 16px;
    font-weight: 600;
    color: white;
    width: 100%;
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-login:hover {
    background: #218838;
    border-color: #218838;
}
.forgot-password {
    text-align: center;
    margin-top: 15px;
}
.forgot-password a {
    color: #28a745;
    text-decoration: none;
    font-size: 14px;
}
.forgot-password a:hover {
    text-decoration: underline;
}
.invalid-feedback {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
}
.is-invalid {
    border-color: #dc3545;
}
</style>
@endpush

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="logo-section">
            <img src="{{ asset('images/image.png') }}" alt="Sara Palma">
        </div>
        
        <h2 class="form-title">INGRESO USUARIOS</h2>
        
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            
            <div class="form-group">
                <input type="text" 
                       class="form-control @error('document_number') is-invalid @enderror" 
                       id="document_number" 
                       name="document_number" 
                       value="{{ old('document_number') }}"
                       placeholder="Número de Documento o IBM"
                       required>
                @error('document_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="Contraseña"
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="forgot-password">
                <a href="#" onclick="showForgotPassword()">Olvidé mi contraseña</a>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn-login">
                    INGRESAR
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Permitir tanto números como texto para IBM
document.getElementById('document_number').addEventListener('input', function(e) {
    // No restringir caracteres para permitir tanto documentos como IBM
});

function showForgotPassword() {
    Swal.fire({
        title: 'Recuperar Contraseña',
        text: 'Contacte al administrador del sistema para recuperar su contraseña',
        icon: 'info',
        confirmButtonColor: '#28a745'
    });
}

document.getElementById('loginForm').addEventListener('submit', function(e) {
    const documentNumber = document.getElementById('document_number').value;
    const password = document.getElementById('password').value;
    
    if (!documentNumber || !password) {
        e.preventDefault();
        Swal.fire({
            title: 'Campos requeridos',
            text: 'Por favor complete todos los campos',
            icon: 'warning',
            timer: 6000,
            timerProgressBar: true,
            confirmButtonColor: '#28a745'
        });
    }
});
</script>
@endpush