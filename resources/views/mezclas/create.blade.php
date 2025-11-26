@extends('layouts.app')

@section('title', 'Nueva Mezcla - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus me-2"></i>Nueva Mezcla</h2>
    <a href="{{ route('mezclas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('mezclas.store') }}">
            @csrf
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Mezcla *</label>
                <input type="text" 
                       class="form-control @error('nombre') is-invalid @enderror" 
                       id="nombre" 
                       name="nombre" 
                       value="{{ old('nombre') }}"
                       required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>



            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Crear Mezcla
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

