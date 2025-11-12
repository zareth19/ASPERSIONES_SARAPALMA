@extends('layouts.app')

@section('title', 'Editar Producto - Sara Palma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>Editar Producto</h2>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('products.update', $product) }}">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="commercial_name" class="form-label">Nombre Comercial *</label>
                    <input type="text" class="form-control @error('commercial_name') is-invalid @enderror" 
                           id="commercial_name" name="commercial_name" value="{{ old('commercial_name', $product->commercial_name) }}" required>
                    @error('commercial_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="active_ingredient" class="form-label">Ingrediente Activo *</label>
                    <input type="text" class="form-control @error('active_ingredient') is-invalid @enderror" 
                           id="active_ingredient" name="active_ingredient" value="{{ old('active_ingredient', $product->active_ingredient) }}" required>
                    @error('active_ingredient')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="unit" class="form-label">Unidad *</label>
                    <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                        <option value="">Seleccione...</option>
                        <option value="Litro" {{ old('unit', $product->unit) == 'Litro' ? 'selected' : '' }}>Litro</option>
                        <option value="Kilogramo" {{ old('unit', $product->unit) == 'Kilogramo' ? 'selected' : '' }}>Kilogramo</option>
                        <option value="Gramo" {{ old('unit', $product->unit) == 'Gramo' ? 'selected' : '' }}>Gramo</option>
                        <option value="Mililitro" {{ old('unit', $product->unit) == 'Mililitro' ? 'selected' : '' }}>Mililitro</option>
                    </select>
                    @error('unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Categoría *</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" 
                            id="category_id" name="category_id" required>
                        <option value="">Seleccione...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="active" name="active" value="1" 
                               {{ old('active', $product->active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="active">
                            Producto Activo
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection