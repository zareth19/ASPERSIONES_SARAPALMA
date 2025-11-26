@extends('layouts.app')

@section('title', 'Códigos - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-code me-2"></i>Códigos</h2>
    <a href="{{ route('mezclas.index') }}" class="btn btn-success">
        <i class="fas fa-flask me-2"></i>Ver Mezclas
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('codigos.index') }}">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="Buscar por código o mezcla...">
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
        @if($codigos->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Mezcla</th>
                            <th>Productos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($codigos as $codigo)
                            <tr>
                                <td>{{ $codigo->codigo }}</td>
                                <td>{{ $codigo->mezcla->nombre ?? 'Sin asignar' }}</td>
                                <td>{{ $codigo->productos->count() }}</td>
                                <td>
                                    <a href="{{ route('codigos.edit', $codigo) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('codigos.productos', $codigo) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-cog"></i> Productos
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No hay códigos registrados.</p>
        @endif
    </div>
</div>
@endsection