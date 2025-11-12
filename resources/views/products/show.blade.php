@extends('layouts.app')

@section('title', 'Ver Producto - Sara Palma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>{{ $product->commercial_name }}</h2>
    <div>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Editar
        </a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle me-2"></i>Información del Producto</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Nombre Comercial:</strong>
                        <p>{{ $product->commercial_name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Ingrediente Activo:</strong>
                        <p>{{ $product->active_ingredient }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Unidad:</strong>
                        <p>{{ $product->unit }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Categoría:</strong>
                        <p><span class="badge bg-info">{{ $product->category->name }}</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Estado:</strong>
                        <p>
                            <span class="badge {{ $product->active ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Fecha de Registro:</strong>
                        <p>{{ $product->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-chart-bar me-2"></i>Estadísticas de Uso</h6>
            </div>
            <div class="card-body">
                <p><strong>Total Aspersiones:</strong> {{ $product->aspersions->count() }}</p>
                <p><strong>Este Mes:</strong> {{ $product->aspersions->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                <p><strong>Última Vez Usado:</strong> 
                    @if($product->aspersions->count() > 0)
                        {{ $product->aspersions->latest()->first()->application_date->format('d/m/Y') }}
                    @else
                        Nunca usado
                    @endif
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="fas fa-tags me-2"></i>Información de Categoría</h6>
            </div>
            <div class="card-body">
                <p><strong>Categoría:</strong> {{ $product->category->name }}</p>
                <p><strong>Descripción:</strong> {{ $product->category->description ?? 'Sin descripción' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection