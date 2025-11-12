@extends('layouts.app')

@section('title', 'Ver Aspersión - Sara Palma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-spray-can me-2"></i>Aspersión - {{ $aspersion->application_date->format('d/m/Y') }}</h2>
    <a href="{{ route('aspersions.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle me-2"></i>Información de la Aspersión</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Finca:</strong>
                        <p>{{ $aspersion->finca->name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Usuario:</strong>
                        <p>{{ $aspersion->user->name }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Fecha de Aplicación:</strong>
                        <p>{{ $aspersion->application_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Semana:</strong>
                        <p>Semana {{ $aspersion->week_number }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Hectáreas Aplicadas:</strong>
                        <p>{{ $aspersion->hectares }} ha</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Fecha de Registro:</strong>
                        <p>{{ $aspersion->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                @if($aspersion->mix_description)
                <div class="row">
                    <div class="col-12 mb-3">
                        <strong>Descripción de la Mezcla:</strong>
                        <p>{{ $aspersion->mix_description }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-flask me-2"></i>Productos Utilizados</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Ingrediente Activo</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                                <th>Categoría</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aspersion->products as $product)
                            <tr>
                                <td>{{ $product->commercial_name }}</td>
                                <td>{{ $product->active_ingredient }}</td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td>{{ $product->unit }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $product->category->name }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-map me-2"></i>Información de Finca</h6>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $aspersion->finca->name }}</p>
                <p><strong>IBM:</strong> {{ $aspersion->finca->ibm }}</p>
                <p><strong>Hectáreas Totales:</strong> {{ $aspersion->finca->hectares }} ha</p>
                <p><strong>Ubicación:</strong> {{ $aspersion->finca->location ?? 'No especificada' }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="fas fa-chart-pie me-2"></i>Resumen</h6>
            </div>
            <div class="card-body">
                <p><strong>Total Productos:</strong> {{ $aspersion->products->count() }}</p>
                <p><strong>Porcentaje de Finca:</strong> 
                    {{ number_format(($aspersion->hectares / $aspersion->finca->hectares) * 100, 1) }}%
                </p>
                <p><strong>Categorías Usadas:</strong> 
                    {{ $aspersion->products->pluck('category.name')->unique()->count() }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection