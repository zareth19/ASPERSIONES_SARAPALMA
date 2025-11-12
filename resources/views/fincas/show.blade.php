@extends('layouts.app')

@section('title', 'Ver Finca - Sara Palma')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <h2><i class="fas fa-map me-2"></i>{{ $finca->name }}</h2>
    <div class="d-flex flex-column flex-sm-row gap-2">
        <a href="{{ route('fincas.edit', $finca) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i><span class="d-none d-sm-inline">Editar</span>
        </a>
        <a href="{{ route('fincas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i><span class="d-none d-sm-inline">Volver</span>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle me-2"></i>Información de la Finca</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Nombre:</strong>
                        <p>{{ $finca->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Código IBM:</strong>
                        <p><code>{{ $finca->ibm }}</code></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Hectáreas:</strong>
                        <p>{{ $finca->hectares }} ha</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Ubicación:</strong>
                        <p>{{ $finca->location ?? 'No especificada' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Estado:</strong>
                        <p>
                            <span class="badge {{ $finca->active ? 'bg-success' : 'bg-danger' }}">
                                {{ $finca->active ? 'Activa' : 'Inactiva' }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Fecha de Registro:</strong>
                        <p>{{ $finca->created_at ? $finca->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($finca->aspersions->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-spray-can me-2"></i>Aspersiones Recientes</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Hectáreas</th>
                                <th>Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($finca->aspersions->take(10) as $aspersion)
                            <tr>
                                <td>{{ $aspersion->application_date->format('d/m/Y') }}</td>
                                <td>{{ $aspersion->user->name }}</td>
                                <td>{{ $aspersion->hectares }} ha</td>
                                <td>{{ $aspersion->products->count() }} productos</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-users me-2"></i>Usuarios Asignados</h6>
            </div>
            <div class="card-body">
                @if($finca->users->count() > 0)
                    @foreach($finca->users as $user)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>{{ $user->name }}</span>
                        <span class="badge bg-primary">{{ ucfirst($user->role->name) }}</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted">No hay usuarios asignados</p>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="fas fa-chart-bar me-2"></i>Estadísticas</h6>
            </div>
            <div class="card-body">
                <p><strong>Total Aspersiones:</strong> {{ $finca->aspersions->count() }}</p>
                <p><strong>Este Mes:</strong> {{ $finca->aspersions->where('application_date', '>=', now()->startOfMonth())->count() }}</p>
                <p><strong>Última Aspersión:</strong> 
                    @if($finca->aspersions->count() > 0)
                        {{ $finca->aspersions->latest()->first()->application_date->format('d/m/Y') }}
                    @else
                        Sin aspersiones
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection