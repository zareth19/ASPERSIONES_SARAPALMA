@extends('layouts.app')

@section('title', 'Ver Usuario - Sara Palma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user me-2"></i>{{ $user->name }}</h2>
    <div>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Editar
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user-circle me-2"></i>Información Personal</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Nombre Completo:</strong>
                        <p>{{ $user->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong>
                        <p>{{ $user->email ?? 'No registrado' }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Tipo de Documento:</strong>
                        <p>{{ $user->documentType->abbreviation }} - {{ $user->documentType->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Número de Documento:</strong>
                        <p>{{ $user->document_number }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Rol:</strong>
                        <p><span class="badge bg-primary">{{ ucfirst($user->role->name) }}</span></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Estado:</strong>
                        <p>
                            <span class="badge {{ $user->active ? 'bg-success' : 'bg-danger' }}">
                                {{ $user->active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </p>
                    </div>
                </div>
                @if($user->finca)
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Finca Asignada:</strong>
                        <p>{{ $user->finca->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>IBM:</strong>
                        <p><code>{{ $user->finca->ibm }}</code></p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($user->aspersions->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-spray-can me-2"></i>Aspersiones Registradas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Finca</th>
                                <th>Hectáreas</th>
                                <th>Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->aspersions->take(10) as $aspersion)
                            <tr>
                                <td>{{ $aspersion->application_date->format('d/m/Y') }}</td>
                                <td>{{ $aspersion->finca->name }}</td>
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
                <p><strong>Fecha de Registro:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        @if($user->finca)
        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="fas fa-map me-2"></i>Información de Finca</h6>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $user->finca->name }}</p>
                <p><strong>IBM:</strong> {{ $user->finca->ibm }}</p>
                <p><strong>Hectáreas:</strong> {{ $user->finca->hectares }} ha</p>
                <p><strong>Ubicación:</strong> {{ $user->finca->location ?? 'No especificada' }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection