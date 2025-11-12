@extends('layouts.app')

@section('title', 'Fincas - Sara Palma')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <h2><i class="fas fa-map me-2"></i>Gestión de Fincas</h2>
    <a href="{{ route('fincas.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i><span class="d-none d-sm-inline">Nueva </span>Finca
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('fincas.index') }}">
            <div class="row g-2">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, IBM, administrador, oficinista o coordinador..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>CC</th>
                        <th>HA</th>
                        <th>IBM</th>
                        <th>FINCA</th>
                        <th>EXT</th>
                        <th>Tel. Directo</th>
                        <th>ADMINISTRADOR</th>
                        <th>#CELULAR</th>
                        <th>OFICINISTA</th>
                        <th>#CELULAR</th>
                        <th>COORD.EMPAQUE</th>
                        <th>#CELULAR</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fincas as $finca)
                    <tr>
                        <td>{{ $finca->cc }}</td>
                        <td>{{ $finca->hectares }}</td>
                        <td><code>{{ $finca->ibm }}</code></td>
                        <td>{{ $finca->name }}</td>
                        <td>{{ $finca->extension }}</td>
                        <td>{{ $finca->direct_phone }}</td>
                        <td>{{ $finca->administrator_name }}</td>
                        <td>{{ $finca->administrator_phone }}</td>
                        <td>{{ $finca->office_worker_name }}</td>
                        <td>{{ $finca->office_worker_phone }}</td>
                        <td>{{ $finca->coordinator_name }}</td>
                        <td>{{ $finca->coordinator_phone }}</td>
                        <td style="min-width: 120px;">
                            <div class="btn-group-vertical btn-group-sm" role="group">
                                <a href="{{ route('fincas.show', $finca) }}" class="btn btn-info btn-sm mb-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('fincas.edit', $finca) }}" class="btn btn-warning btn-sm mb-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-success btn-sm" onclick="setPassword({{ $finca->id }}, '{{ $finca->name }}')">
                                    <i class="fas fa-key"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{ $fincas->links() }}
@endsection

@push('scripts')
<script>
function setPassword(fincaId, fincaName) {
    Swal.fire({
        title: 'Asignar Contraseña',
        text: `Finca: ${fincaName}`,
        input: 'password',
        inputPlaceholder: 'Ingrese la contraseña',
        showCancelButton: true,
        confirmButtonText: 'Asignar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#28a745',
        inputValidator: (value) => {
            if (!value) {
                return 'Debe ingresar una contraseña';
            }
            if (value.length < 6) {
                return 'La contraseña debe tener al menos 6 caracteres';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/fincas/${fincaId}/password`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    password: result.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Contraseña asignada correctamente',
                        icon: 'success',
                        confirmButtonColor: '#28a745'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo asignar la contraseña',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Error de conexión',
                    icon: 'error'
                });
            });
        }
    });
}
</script>
@endpush