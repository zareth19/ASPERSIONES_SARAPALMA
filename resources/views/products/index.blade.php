@extends('layouts.app')

@section('title', 'Productos - Sara Palma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>Gestión de Productos</h2>
    <a href="{{ route('products.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Nuevo Producto
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('products.index') }}">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="Buscar por nombre comercial, ingrediente activo o categoría...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre Comercial</th>
                        <th>Ingrediente Activo</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->commercial_name }}</td>
                        <td>{{ $product->active_ingredient }}</td>
                        <td>{{ $product->unit }}</td>
                        <td>{{ $product->cantidad_producto ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-info">{{ $product->category->name }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $product->active ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $products->appends(['search' => $search])->links() }}
    </div>
</div>
@endsection