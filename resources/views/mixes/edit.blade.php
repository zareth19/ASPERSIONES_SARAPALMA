@extends('layouts.app')

@section('title', 'Editar Mezcla - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>Editar Mezcla</h2>
    <a href="{{ route('mixes.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('mixes.update', $mix) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nombre de la Mezcla *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $mix->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="code" class="form-label">Código de la Mezcla *</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                           id="code" name="code" value="{{ old('code', $mix->code) }}" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="product_id" class="form-label">Producto *</label>
                <select class="form-select @error('product_id') is-invalid @enderror" 
                        id="product_id" name="product_id" required>
                    <option value="">Seleccionar producto...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $mix->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->commercial_name }} - {{ $product->active_ingredient }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
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