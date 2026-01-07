@extends('layouts.app')

@section('title', 'Nuevo Código - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus me-2"></i>Nuevo Código{{ isset($mezcla) ? ' para ' . $mezcla->nombre : '' }}</h2>
    <a href="{{ isset($mezcla) ? route('mezclas.show', $mezcla) : route('codigos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('codigos.store') }}">
            @csrf
            
            @if(isset($mezcla))
                <div class="mb-3">
                    <label class="form-label">Mezcla</label>
                    <input type="text" class="form-control" value="{{ $mezcla->nombre }}" readonly>
                    <input type="hidden" name="mezcla_id" value="{{ $mezcla->id }}">
                </div>
            @else
                <div class="mb-3">
                    <label for="mezcla_id" class="form-label">Mezcla *</label>
                    <select class="form-select @error('mezcla_id') is-invalid @enderror" 
                            id="mezcla_id" name="mezcla_id" required>
                        <option value="">Seleccione una mezcla...</option>
                        @foreach(\App\Models\Mezcla::all() as $m)
                            <option value="{{ $m->id }}" {{ old('mezcla_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('mezcla_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            
            <div class="mb-3">
                <label for="codigo" class="form-label">Código *</label>
                <input type="text" 
                       class="form-control @error('codigo') is-invalid @enderror" 
                       id="codigo" 
                       name="codigo" 
                       value="{{ old('codigo') }}"
                       placeholder="Ej: 12521001"
                       required>
                @error('codigo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Crear Código
                </button>
            </div>
        </form>
    </div>
</div>
@endsection