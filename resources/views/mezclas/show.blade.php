@extends('layouts.app')

@section('title', 'Mezcla: ' . $mezcla->nombre . ' - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>{{ $mezcla->nombre }}</h2>
    <div>
        <a href="{{ route('codigos.create', $mezcla) }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Nuevo Código
        </a>
        <a href="{{ route('mezclas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Códigos de la Mezcla</h5>
    </div>
    <div class="card-body">
        @if($mezcla->codigos->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Productos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mezcla->codigos as $codigo)
                            <tr>
                                <td>{{ $codigo->codigo }}</td>
                                <td>{{ $codigo->productos->count() }}</td>
                                <td>
                                    <a href="{{ route('codigos.edit', $codigo) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('codigos.productos', $codigo) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-cog"></i> Gestionar Productos
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No hay códigos asociados a esta mezcla.</p>
        @endif
    </div>
</div>
@endsection