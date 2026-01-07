@extends('layouts.app')

@section('title', 'Usuarios - Sara Palma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users me-2"></i>Gestión de Usuarios</h2>
    <a href="{{ route('users.create') }}" class="btn btn-success">
        <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
    </a>
</div>

@if(session('temp_password'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>¡Importante!</strong> El correo no pudo ser enviado debido a restricciones corporativas.
    <br><strong>Email:</strong> {{ session('user_email') }}
    <br><strong>Contraseña temporal:</strong> <code>{{ session('temp_password') }}</code>
    <br><small>Por favor, proporciona estas credenciales al usuario manualmente.</small>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Finca</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->documentType->abbreviation }} {{ $user->document_number }}</td>
                        <td>{{ $user->email ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-primary">{{ ucfirst($user->role->name) }}</span>
                        </td>
                        <td>{{ $user->finca->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $user->active ? 'bg-success' : 'bg-danger' }}">
                                {{ $user->active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->active)
                            <button class="btn btn-sm btn-danger" onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $users->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
function deleteUser(userId, userName) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Deseas eliminar permanentemente al usuario "${userName}"? Esta acción NO se puede revertir.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear formulario para enviar DELETE request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/users/${userId}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush