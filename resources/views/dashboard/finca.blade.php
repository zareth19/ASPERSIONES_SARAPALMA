@extends('layouts.app')

@section('title', 'Dashboard Finca - Sara Palma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard - {{ session('finca_name', Auth::user()->finca->name ?? 'Finca') }}</h2>
    <a href="{{ route('aspersions.create') }}" class="btn btn-success">
        <i class="fas fa-spray-can me-2"></i>Nueva Aspersión
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ session('finca_logged') ? session('finca_hectares', '0') : (Auth::user()->finca->hectares ?? 'N/A') }}</h4>
                        <p class="mb-0">Hectáreas Totales</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-map fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $aspersionesRecientes->count() }}</h4>
                        <p class="mb-0">Aspersiones Recientes</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-spray-can fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ session('finca_ibm', Auth::user()->finca->ibm ?? 'N/A') }}</h4>
                        <p class="mb-0">Código IBM</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-barcode fa-2x"></i>
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
                            @foreach($aspersionesRecientes as $aspersion)
                            <tr>
                                <td>{{ $aspersion->application_date->format('d/m/Y') }}</td>
                                <td>Semana {{ $aspersion->week_number }}</td>
                                <td>{{ $aspersion->hectares }}</td>
                                <td>{{ $aspersion->products->count() }} productos</td>
                            </tr>
                            @endforeach
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
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-info-circle me-2"></i>Información de la Finca</h6>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ session('finca_name', Auth::user()->finca->name ?? 'N/A') }}</p>
                <p><strong>IBM:</strong> {{ session('finca_ibm', Auth::user()->finca->ibm ?? 'N/A') }}</p>
                <p><strong>Hectáreas:</strong> {{ session('finca_logged') ? session('finca_hectares', '0') : 'N/A' }}</p>
                <p><strong>Ubicación:</strong> {{ session('finca_logged') ? 'N/A' : (Auth::user()->finca->location ?? 'No especificada') }}</p>
                <p><strong>Usuario:</strong> {{ session('finca_logged') ? 'Finca' : Auth::user()->name }}</p>
            </div>
        </div>
    </div>
</div>
@endsection