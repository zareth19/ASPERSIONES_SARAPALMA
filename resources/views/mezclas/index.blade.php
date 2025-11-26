@extends('layouts.app')

@section('title', 'Mezclas - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>Mezclas</h2>
    <a href="{{ route('mezclas.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Nueva Mezcla
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($mezclas->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Códigos</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mezclas as $mezcla)
                        <tr>
                            <td>{{ $mezcla->id }}</td>
                            <td>{{ $mezcla->nombre }}</td>
                            <td>{{ $mezcla->codigos->count() }}</td>
                            <td>{{ $mezcla->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('mezclas.show', $mezcla) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No hay mezclas registradas.</p>
        @endif
    </div>
</div>
@endsection