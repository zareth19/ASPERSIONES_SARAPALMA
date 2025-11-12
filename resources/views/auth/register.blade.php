@extends('layouts.app')

@section('title', 'Registro - Sara Palma')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h4><i class="fas fa-user-plus me-2"></i>Registro de Usuario</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-1"></i>Nombre Completo *
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   pattern="[A-Za-zÀ-ÿ\s]+"
                                   title="Solo se permiten letras y espacios"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Email (Opcional)
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="document_type_id" class="form-label">
                                <i class="fas fa-id-card me-1"></i>Tipo de Documento *
                            </label>
                            <select class="form-select @error('document_type_id') is-invalid @enderror" 
                                    id="document_type_id" 
                                    name="document_type_id" 
                                    required>
                                <option value="">Seleccione...</option>
                                @foreach($documentTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('document_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->abbreviation }} - {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('document_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="document_number" class="form-label">
                                <i class="fas fa-hashtag me-1"></i>Número de Documento *
                            </label>
                            <input type="text" 
                                   class="form-control @error('document_number') is-invalid @enderror" 
                                   id="document_number" 
                                   name="document_number" 
                                   value="{{ old('document_number') }}"
                                   pattern="[0-9]+"
                                   title="Solo se permiten números"
                                   required>
                            @error('document_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i>Contraseña *
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   minlength="6"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-1"></i>Confirmar Contraseña *
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   minlength="6"
                                   required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role_id" class="form-label">
                                <i class="fas fa-user-tag me-1"></i>Rol *
                            </label>
                            <select class="form-select @error('role_id') is-invalid @enderror" 
                                    id="role_id" 
                                    name="role_id" 
                                    required>
                                <option value="">Seleccione...</option>
                                <option value="1" {{ old('role_id') == '1' ? 'selected' : '' }}>Administrador</option>
                                <option value="2" {{ old('role_id') == '2' ? 'selected' : '' }}>Administrativo</option>
                                <option value="3" {{ old('role_id') == '3' ? 'selected' : '' }}>Finca</option>
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="finca_id" class="form-label">
                                <i class="fas fa-map me-1"></i>Finca (Solo para rol Finca)
                            </label>
                            <select class="form-select @error('finca_id') is-invalid @enderror" 
                                    id="finca_id" 
                                    name="finca_id">
                                <option value="">Seleccione...</option>
                                @foreach($fincas as $finca)
                                    <option value="{{ $finca->id }}" {{ old('finca_id') == $finca->id ? 'selected' : '' }}>
                                        {{ $finca->name }} ({{ $finca->ibm }})
                                    </option>
                                @endforeach
                            </select>
                            @error('finca_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-user-plus me-2"></i>Registrar Usuario
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        ¿Ya tienes cuenta? Inicia sesión aquí
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Validación en tiempo real
document.getElementById('name').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '');
});

document.getElementById('document_number').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Mostrar/ocultar campo finca según rol
document.getElementById('role_id').addEventListener('change', function() {
    const fincaField = document.getElementById('finca_id').closest('.col-md-6');
    if (this.value === '3') { // Rol finca
        fincaField.style.display = 'block';
        document.getElementById('finca_id').required = true;
    } else {
        fincaField.style.display = 'none';
        document.getElementById('finca_id').required = false;
        document.getElementById('finca_id').value = '';
    }
});

// Validar confirmación de contraseña
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    if (this.value !== password) {
        this.setCustomValidity('Las contraseñas no coinciden');
    } else {
        this.setCustomValidity('');
    }
});

// Confirmación antes de enviar
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: '¿Confirmar registro?',
        text: '¿Está seguro de que desea registrar este usuario?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, registrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});

// Inicializar estado del campo finca
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('role_id').dispatchEvent(new Event('change'));
});
</script>
@endpush