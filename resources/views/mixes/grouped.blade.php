@extends('layouts.app')

@section('title', 'Mezclas por Producto - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>Mezclas por Producto</h2>
    <div>
        <a href="{{ route('mixes.index') }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-list me-1"></i>Vista Lista
        </a>
        <a href="{{ route('mixes.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Nueva Mezcla
        </a>
    </div>
</div>

@foreach($productGroups as $product)
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-flask me-2"></i>{{ $product->commercial_name }}
            <small class="text-muted">- {{ $product->active_ingredient }}</small>
            <span class="badge bg-secondary ms-2">{{ $product->mixes->count() }} mezclas</span>
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($product->mixes as $mix)
            <div class="col-md-4 mb-2">
                <div class="border rounded p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $mix->name }}</strong><br>
                            <span class="badge bg-primary">{{ $mix->code }}</span>
                        </div>
                        <div>
                            <a href="{{ route('mixes.edit', $mix) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('mixes.destroy', $mix) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar mezcla?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endforeach

@if($productGroups->isEmpty())
<div class="card">
    <div class="card-body text-center">
        <p>No hay mezclas registradas</p>
    </div>
</div>
@endif
@endsection