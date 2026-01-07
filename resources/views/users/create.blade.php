@extends('layouts.app')

@section('title', 'Crear Usuario - Sara Palma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-plus me-2"></i>Crear Usuario</h2>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nombre Completo *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" 
                           pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                           minlength="2" maxlength="255"
                           title="Solo se permiten letras y espacios"
                           oninput="validateName(this)"
                           onpaste="return false"
                           required>
                    <div class="invalid-feedback" id="name-error"></div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}"
                           pattern="[a-zA-Z0-9._%+-]+@sarapalma\.com\.co$"
                           maxlength="255"
                           title="Debe ser un email válido que termine en @sarapalma.com.co"
                           oninput="validateEmail(this)"
                           onpaste="return false"
                           required>
                    <small class="form-text text-muted">Debe terminar en @sarapalma.com.co</small>
                    <div class="invalid-feedback" id="email-error"></div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="document_type_id" class="form-label">Tipo de Documento *</label>
                    <select class="form-select @error('document_type_id') is-invalid @enderror" 
                            id="document_type_id" name="document_type_id" required>
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
                    <label for="document_number" class="form-label">Número de Documento *</label>
                    <input type="text" class="form-control @error('document_number') is-invalid @enderror" 
                           id="document_number" name="document_number" value="{{ old('document_number') }}"
                           pattern="[0-9]+"
                           minlength="6" maxlength="20"
                           title="Solo se permiten números (6-20 dígitos)"
                           oninput="validateDocumentNumber(this)"
                           onpaste="return false"
                           required>
                    <div class="invalid-feedback" id="document-error"></div>
                    @error('document_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="role_id" class="form-label">Rol *</label>
                    <select class="form-select @error('role_id') is-invalid @enderror" 
                            id="role_id" name="role_id" required>
                        <option value="">Seleccione...</option>
                        @foreach($roles->where('name', 'admin') as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>



            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Nota:</strong> Se generará una contraseña temporal que será enviada por correo. El usuario deberá cambiarla en su primer acceso.
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Prevenir ataques XSS y validar entrada
function sanitizeInput(input) {
    return input.replace(/[<>"'&\/\\]/g, '');
}

function validateName(input) {
    const value = input.value;
    const errorDiv = document.getElementById('name-error');
    
    // Remover caracteres peligrosos
    const sanitized = value.replace(/[<>"'&\/\\]/g, '');
    if (sanitized !== value) {
        input.value = sanitized;
    }
    
    // Validar solo letras y espacios
    const namePattern = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
    if (!namePattern.test(input.value) && input.value !== '') {
        input.classList.add('is-invalid');
        errorDiv.textContent = 'Solo se permiten letras y espacios';
        errorDiv.style.display = 'block';
    } else if (input.value.length < 2 && input.value !== '') {
        input.classList.add('is-invalid');
        errorDiv.textContent = 'Mínimo 2 caracteres';
        errorDiv.style.display = 'block';
    } else {
        input.classList.remove('is-invalid');
        errorDiv.style.display = 'none';
    }
}

function validateEmail(input) {
    const value = input.value;
    const errorDiv = document.getElementById('email-error');
    
    // Remover caracteres peligrosos
    const sanitized = value.replace(/[<>"'&\/\\]/g, '');
    if (sanitized !== value) {
        input.value = sanitized;
    }
    
    // Validar formato de email y dominio
    const emailPattern = /^[a-zA-Z0-9._%+-]+@sarapalma\.com\.co$/;
    if (!emailPattern.test(input.value) && input.value !== '') {
        input.classList.add('is-invalid');
        errorDiv.textContent = 'Debe ser un email válido que termine en @sarapalma.com.co';
        errorDiv.style.display = 'block';
    } else {
        input.classList.remove('is-invalid');
        errorDiv.style.display = 'none';
    }
}

function validateDocumentNumber(input) {
    const value = input.value;
    const errorDiv = document.getElementById('document-error');
    
    // Solo permitir números
    const numbersOnly = value.replace(/[^0-9]/g, '');
    if (numbersOnly !== value) {
        input.value = numbersOnly;
    }
    
    // Validar longitud
    if (input.value.length < 6 && input.value !== '') {
        input.classList.add('is-invalid');
        errorDiv.textContent = 'Mínimo 6 dígitos';
        errorDiv.style.display = 'block';
    } else if (input.value.length > 20) {
        input.classList.add('is-invalid');
        errorDiv.textContent = 'Máximo 20 dígitos';
        errorDiv.style.display = 'block';
        input.value = input.value.substring(0, 20);
    } else {
        input.classList.remove('is-invalid');
        errorDiv.style.display = 'none';
    }
}

// Prevenir envío de formulario con datos inválidos
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const documentNumber = document.getElementById('document_number').value;
        
        // Validaciones finales
        const namePattern = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@sarapalma\.com\.co$/;
        const documentPattern = /^[0-9]{6,20}$/;
        
        if (!namePattern.test(name) || name.length < 2) {
            e.preventDefault();
            alert('Nombre inválido');
            return false;
        }
        
        if (!emailPattern.test(email)) {
            e.preventDefault();
            alert('Email inválido');
            return false;
        }
        
        if (!documentPattern.test(documentNumber)) {
            e.preventDefault();
            alert('Número de documento inválido');
            return false;
        }
        
        // Deshabilitar botón para prevenir doble envío
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creando...';
    });
    
    // Prevenir pegado de contenido potencialmente malicioso
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            return false;
        });
    });
});
</script>
@endpush