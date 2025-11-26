@extends('layouts.app')

@section('title', 'Productos - Código {{ $codigo->codigo }} - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>Productos - Código {{ $codigo->codigo }}</h2>
    <a href="{{ route('codigos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5>Agregar Producto</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('codigos.productos.store', $codigo) }}">
            @csrf
            
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Sel.</th>
                            <th width="50%">Producto</th>
                            <th width="20%">Cantidad</th>
                            <th width="25%">Unidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                        <tr>
                            <td>
                                <input type="checkbox" name="productos[]" value="{{ $producto->id }}" 
                                       class="form-check-input"
                                       {{ $productosAsociados->contains('id', $producto->id) ? 'disabled checked' : '' }}>
                            </td>
                            <td>{{ $producto->commercial_name }}</td>
                            <td>
                                <input type="number" class="form-control form-control-sm" 
                                       value="{{ $producto->cantidad_producto }}" 
                                       step="0.01" readonly>
                            </td>
                            <td>{{ $producto->unit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Agregar Productos Seleccionados
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Productos Asociados</h5>
    </div>
    <div class="card-body">
        @if($productosAsociados->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productosAsociados as $producto)
                    <tr>
                        <td>{{ $producto->commercial_name }}</td>
                        <td>{{ $producto->pivot->cantidad_aplicacion ?? $producto->cantidad_producto }}</td>
                        <td>{{ $producto->unit }}</td>
                        <td>
                            <form action="{{ route('codigos.productos.destroy', [$codigo, $producto->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar producto?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center text-muted">No hay productos asociados a este código.</p>
        @endif
    </div>
</div>
@endsection