@extends('layouts.app')

@section('title', 'Mi Perfil - Sara Palma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-circle me-2"></i>Mi Perfil</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user me-2"></i>Información Personal</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nombre Completo:</label>
                        <p class="form-control-plaintext">{{ $user->name }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tipo de Documento:</label>
                        <p class="form-control-plaintext">
                            {{ $user->documentType->abbreviation }} - {{ $user->documentType->name }}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Número de Documento:</label>
                        <p class="form-control-plaintext">{{ $user->document_number }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email:</label>
                        <p class="form-control-plaintext">{{ $user->email ?? 'No registrado' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Rol:</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-primary">{{ ucfirst($user->role->name) }}</span>
                        </p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Estado:</label>
                        <p class="form-control-plaintext">
                            <span class="badge {{ $user->active ? 'bg-success' : 'bg-danger' }}">
                                {{ $user->active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($user->finca)
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-bold mt-3 mb-2">Información de Finca:</h6>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Finca Asignada:</label>
                        <p class="form-control-plaintext">{{ $user->finca->name }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">IBM:</label>
                        <p class="form-control-plaintext">{{ $user->finca->ibm }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Hectáreas:</label>
                        <p class="form-control-plaintext">{{ $user->finca->hectares }} ha</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Ubicación:</label>
                        <p class="form-control-plaintext">{{ $user->finca->location ?? 'No especificada' }}</p>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Fecha de Registro:</label>
                        <p class="form-control-plaintext">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Última Actualización:</label>
                        <p class="form-control-plaintext">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-cog me-2"></i>Acciones</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary" onclick="changePassword()">
                        <i class="fas fa-key me-2"></i>Cambiar Contraseña
                    </button>
                    
                    @if($user->isFinca())
                    <a href="{{ route('aspersions.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-spray-can me-2"></i>Nueva Aspersión
                    </a>
                    
                    <a href="{{ route('aspersions.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-list me-2"></i>Mis Aspersiones
                    </a>
                    @endif
                </div>
            </div>
        </div>

        @if($user->isFinca() && $user->finca)
        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="fas fa-chart-bar me-2"></i>Estadísticas</h6>
            </div>
            <div class="card-body">
                <p><strong>Total Aspersiones:</strong> {{ $user->aspersions->count() }}</p>
                <p><strong>Este Mes:</strong> {{ $user->aspersions->where('application_date', '>=', now()->startOfMonth())->count() }}</p>
                <p><strong>Última Aspersión:</strong> 
                    @if($user->aspersions->count() > 0)
                        {{ $user->aspersions->latest()->first()->application_date->format('d/m/Y') }}
                    @else
                        Sin aspersiones
                    @endif
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function changePassword() {
    Swal.fire({
        title: 'Cambiar Contraseña',
        html: `
            <input type="password" id="current_password" class="swal2-input" placeholder="Contraseña actual">
            <input type="password" id="new_password" class="swal2-input" placeholder="Nueva contraseña">
            <input type="password" id="confirm_password" class="swal2-input" placeholder="Confirmar nueva contraseña">
        `,
        showCancelButton: true,
        confirmButtonText: 'Cambiar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const currentPassword = document.getElementById('current_password').value;
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (!currentPassword || !newPassword || !confirmPassword) {
                Swal.showValidationMessage('Todos los campos son requeridos');
                return false;
            }
            
            if (newPassword.length < 6) {
                Swal.showValidationMessage('La nueva contraseña debe tener al menos 6 caracteres');
                return false;
            }
            
            if (newPassword !== confirmPassword) {
                Swal.showValidationMessage('Las contraseñas no coinciden');
                return false;
            }
            
            return { currentPassword, newPassword };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí se enviaría la petición para cambiar la contraseña
            Swal.fire('Funcionalidad en desarrollo', '', 'info');
        }
    });
}
</script>
@endpush