@extends('layouts.app')

@section('title', 'Mezclas - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>Mezclas</h2>
    <div>
        <a href="{{ route('mixes.grouped') }}" class="btn btn-outline-info me-2">
            <i class="fas fa-layer-group me-1"></i>Vista Agrupada
        </a>
        <a href="{{ route('mixes.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Nueva Mezcla
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Nombre de Mezcla</th>
                        <th>Código</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mixes as $mix)
                    <tr>
                        <td>
                            <strong>{{ $mix->product->commercial_name }}</strong><br>
                            <small class="text-muted">{{ $mix->product->active_ingredient }}</small>
                        </td>
                        <td>{{ $mix->name }}</td>
                        <td><span class="badge bg-primary">{{ $mix->code }}</span></td>
                        <td>
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
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No hay mezclas registradas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $mixes->links() }}
    </div>
</div>
@endsection