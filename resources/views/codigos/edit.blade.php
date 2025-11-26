@extends('layouts.app')

@section('title', 'Editar Código - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit me-2"></i>Editar Código</h2>
    <a href="{{ route('mezclas.show', $codigo->mezcla) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('codigos.update', $codigo) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="mezcla_id" class="form-label">Mezcla *</label>
                <select class="form-select @error('mezcla_id') is-invalid @enderror" 
                        id="mezcla_id" 
                        name="mezcla_id" 
                        required>
                    <option value="">Seleccionar mezcla...</option>
                    @foreach($mezclas as $mezcla)
                        <option value="{{ $mezcla->id }}" {{ old('mezcla_id', $codigo->mezcla_id) == $mezcla->id ? 'selected' : '' }}>
                            {{ $mezcla->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('mezcla_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="codigo" class="form-label">Código *</label>
                <input type="text" 
                       class="form-control @error('codigo') is-invalid @enderror" 
                       id="codigo" 
                       name="codigo" 
                       value="{{ old('codigo', $codigo->codigo) }}"
                       placeholder="Ej: 12521001"
                       required>
                @error('codigo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Actualizar Código
                </button>
            </div>
        </form>
    </div>
</div>
@endsection