@extends('layouts.app')

@section('title', 'Dashboard Administrador - Sara Palma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard Administrador</h2>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalFincas }}</h4>
                        <p class="mb-0">Fincas Activas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-map fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $fincasConAspersiones }}</h4>
                        <p class="mb-0">Fincas con Aspersiones</p>
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
                        <h4>{{ $aspersionesHoy }}</h4>
                        <p class="mb-0">Aspersiones Hoy</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-day fa-2x"></i>
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
                        <h4>{{ $aspersionesMes }}</h4>
                        <p class="mb-0">Aspersiones Este Mes</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar me-2"></i>Acciones Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('users.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus me-2"></i>Crear Usuario
                    </a>
                    <a href="{{ route('fincas.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-map-plus me-2"></i>Crear Finca
                    </a>
                    <a href="{{ route('products.create') }}" class="btn btn-outline-warning">
                        <i class="fas fa-flask me-2"></i>Agregar Producto
                    </a>
                    <a href="{{ route('aspersions.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-list me-2"></i>Ver Aspersiones
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-file-export me-2"></i>Reportes</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-success" onclick="exportExcel()">
                        <i class="fas fa-file-excel me-2"></i>Exportar a Excel
                    </button>
                    <button class="btn btn-outline-primary" onclick="openPowerBI()">
                        <i class="fas fa-chart-line me-2"></i>Abrir Power BI
                    </button>
                    <a href="{{ route('reports.fincas') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-map me-2"></i>Reporte por Fincas
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportExcel() {
    Swal.fire({
        title: 'Exportar a Excel',
        text: '¿Qué período desea exportar?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Este mes',
        cancelButtonText: 'Todo',
        showDenyButton: true,
        denyButtonText: 'Personalizado'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{ route("reports.excel") }}?period=month';
        } else if (result.isDenied) {
            // Aquí se podría abrir un modal para seleccionar fechas
            Swal.fire('Funcionalidad en desarrollo', '', 'info');
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            window.location.href = '{{ route("reports.excel") }}?period=all';
        }
    });
}

function openPowerBI() {
    Swal.fire({
        title: 'Power BI',
        text: 'Abriendo dashboard de Power BI...',
        icon: 'info',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false
    });
    // Aquí se abriría la URL de Power BI
    // window.open('URL_POWER_BI', '_blank');
}
</script>
@endpush