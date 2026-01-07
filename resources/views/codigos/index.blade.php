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
        @if($mezclas->count() > 0)
            <div class="accordion" id="mezclasAccordion">
                @foreach($mezclas as $mezcla)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $mezcla->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $mezcla->id }}">
                                <div class="d-flex justify-content-between w-100 me-3">
                                    <span><strong>{{ $mezcla->nombre }}</strong></span>
                                    <span class="badge bg-primary">{{ $mezcla->codigos_count }} códigos</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $mezcla->id }}" class="accordion-collapse collapse" data-bs-parent="#mezclasAccordion">
                            <div class="accordion-body">
                                @if($mezcla->codigos->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Productos</th>
                                                    <th>Aspersiones</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($mezcla->codigos as $codigo)
                                                    <tr>
                                                        <td>{{ $codigo->codigo }}</td>
                                                        <td>{{ $codigo->productos->count() }}</td>
                                                        <td>{{ $codigo->aspersions_count }}</td>
                                                        <td>
                                                            <a href="{{ route('codigos.edit', $codigo) }}" class="btn btn-sm btn-warning">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('codigos.productos', $codigo) }}" class="btn btn-sm btn-info">
                                                                <i class="fas fa-cog"></i>
                                                            </a>
                                                            @if($codigo->aspersions_count == 0)
                                                                <form action="{{ route('codigos.destroy', $codigo) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar código?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">No hay códigos para esta mezcla.</p>
                                @endif
                                <div class="mt-3">
                                    <a href="{{ route('codigos.create', $mezcla) }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i>Agregar Código
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">No hay mezclas registradas.</p>
        @endif
    </div>
</div>
@endsection