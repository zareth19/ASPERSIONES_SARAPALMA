@extends('layouts.app')

@section('title', 'Crear Finca - Sara Palma')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <h2><i class="fas fa-plus me-2"></i>Crear Finca</h2>
    <a href="{{ route('fincas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i><span class="d-none d-sm-inline">Volver</span>
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('fincas.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nombre de la Finca *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="ibm" class="form-label">Código IBM *</label>
                    <input type="text" class="form-control @error('ibm') is-invalid @enderror" 
                           id="ibm" name="ibm" value="{{ old('ibm') }}" required>
                    @error('ibm')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="hectares" class="form-label">Hectáreas *</label>
                    <input type="number" class="form-control @error('hectares') is-invalid @enderror" 
                           id="hectares" name="hectares" value="{{ old('hectares') }}" 
                           step="0.01" min="0.01" required>
                    @error('hectares')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Ubicación</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                           id="location" name="location" value="{{ old('location') }}">
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Crear Finca
                </button>
            </div>
        </form>
    </div>
</div>
@endsection