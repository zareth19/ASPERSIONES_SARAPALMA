@extends('layouts.app')

@section('title', 'Dashboard Finca - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard - {{ session('finca_name', Auth::user()->finca->name ?? 'Finca') }}</h2>
    <a href="{{ route('aspersions.create') }}" class="btn btn-success">
        <i class="fas fa-spray-can me-2"></i>Nueva Aspersión
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ session('finca_logged') ? session('finca_hectares', '0') : (Auth::user()->finca->hectares ?? 'N/A') }} ha</h4>
                        <p class="mb-0">Hectáreas Totales</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-map fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalAspersiones }}</h4>
                        <p class="mb-0">Total Aspersiones</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-spray-can fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $aspersionesMes }}</h4>
                        <p class="mb-0">Este Mes</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $hectareasAsperjadas }}</h4>
                        <p class="mb-0">Ha. Asperjadas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-area fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-history me-2"></i>Aspersiones Recientes</h5>
            </div>
            <div class="card-body">
                @if($aspersionesRecientes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Semana</th>
                                <th>Hectáreas</th>
                                <th>Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aspersionesRecientes as $aspersion)
                            <tr>
                                <td>{{ $aspersion->application_date->format('d/m/Y') }}</td>
                                <td><span class="badge bg-secondary">Semana {{ $aspersion->week_number }}</span></td>
                                <td>{{ $aspersion->hectares }} ha</td>
                                <td>
                                    <span class="badge bg-info">{{ $aspersion->products->count() }} productos</span>
                                    @if($aspersion->mix_description)
                                        <i class="fas fa-comment-alt text-muted ms-1" title="{{ $aspersion->mix_description }}"></i>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    <i class="fas fa-spray-can fa-2x mb-2 d-block"></i>
                                    No hay aspersiones registradas
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">No hay aspersiones registradas aún.</p>
                @endif
                
                <div class="text-center mt-3">
                    <a href="{{ route('aspersions.index') }}" class="btn btn-outline-primary">
                        Ver Todas las Aspersiones
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="fas fa-info-circle me-2"></i>Información de la Finca</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong><i class="fas fa-map-marker-alt text-success me-1"></i>Nombre:</strong><br>
                    <span class="text-muted">{{ session('finca_name', Auth::user()->finca->name ?? 'N/A') }}</span>
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-barcode text-warning me-1"></i>IBM:</strong><br>
                    <code>{{ session('finca_ibm', Auth::user()->finca->ibm ?? 'N/A') }}</code>
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-ruler text-info me-1"></i>Hectáreas:</strong><br>
                    <span class="text-muted">{{ session('finca_logged') ? session('finca_hectares', '0') : 'N/A' }} ha</span>
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-user text-primary me-1"></i>Usuario:</strong><br>
                    <span class="text-muted">{{ session('finca_logged') ? 'Acceso Finca' : Auth::user()->name }}</span>
                </div>
                @if(!session('finca_logged') && Auth::user()->finca && Auth::user()->finca->location)
                <div class="mb-3">
                    <strong><i class="fas fa-location-arrow text-secondary me-1"></i>Ubicación:</strong><br>
                    <span class="text-muted">{{ Auth::user()->finca->location }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection