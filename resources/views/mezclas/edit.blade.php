@extends('layouts.app')

@section('title', 'Editar Mezcla - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit me-2"></i>Editar Mezcla</h2>
    <a href="{{ route('mezclas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('mezclas.update', $mezcal) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nombre_mezcla" class="form-label">Nombre de la Mezcla *</label>
                <input type="text" 
                       class="form-control @error('nombre_mezcla') is-invalid @enderror" 
                       id="nombre_mezcla" 
                       name="nombre_mezcla" 
                       value="{{ old('nombre_mezcla', $mezcal->nombre_mezcla) }}"
                       required>
                @error('nombre_mezcla')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cantidad_aplicacion" class="form-label">Cantidad de Aplicación *</label>
                <input type="number" 
                       class="form-control @error('cantidad_aplicacion') is-invalid @enderror" 
                       id="cantidad_aplicacion" 
                       name="cantidad_aplicacion" 
                       value="{{ old('cantidad_aplicacion', $mezcal->cantidad_aplicacion) }}"
                       step="0.01"
                       min="0.01"
                       required>
                @error('cantidad_aplicacion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="producto_id" class="form-label">Producto *</label>
                <select class="form-select @error('producto_id') is-invalid @enderror" 
                        id="producto_id" 
                        name="producto_id" 
                        required>
                    <option value="">Seleccionar producto...</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ old('producto_id', $mezcal->producto_id) == $producto->id ? 'selected' : '' }}>
                            {{ $producto->commercial_name }}
                        </option>
                    @endforeach
                </select>
                @error('producto_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="codigo_id" class="form-label">Código *</label>
                <select class="form-select @error('codigo_id') is-invalid @enderror" 
                        id="codigo_id" 
                        name="codigo_id" 
                        required>
                    <option value="">Seleccionar código...</option>
                    @foreach($codigos as $codigo)
                        <option value="{{ $codigo->id }}" {{ old('codigo_id', $mezcal->codigo_id) == $codigo->id ? 'selected' : '' }}>
                            {{ $codigo->codigo }}
                        </option>
                    @endforeach
                </select>
                @error('codigo_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Actualizar Mezcla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection