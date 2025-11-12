@extends('layouts.app')

@section('title', 'Aspersiones - Sara Palma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-spray-can me-2"></i>Aspersiones</h2>
    @if(session('finca_logged') || (auth()->check() && !Auth::user()->isAdmin()))
    <a href="{{ route('aspersions.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Nueva Aspersión
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        @if(auth()->check() && Auth::user()->isAdmin())
                        <th>Finca</th>
                        <th>Usuario</th>
                        @endif
                        <th>Fecha</th>
                        <th>Semana</th>
                        <th>Hectáreas</th>
                        <th>Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aspersions as $aspersion)
                    <tr>
                        @if(auth()->check() && Auth::user()->isAdmin())
                        <td>{{ $aspersion->finca->name }}</td>
                        <td>{{ $aspersion->user->name ?? 'Finca' }}</td>
                        @endif
                        <td>{{ $aspersion->application_date->format('d/m/Y') }}</td>
                        <td>Semana {{ $aspersion->week_number }}</td>
                        <td>{{ $aspersion->hectares }}</td>
                        <td>{{ $aspersion->products->count() }} productos</td>
                        <td>
                            <a href="{{ route('aspersions.show', $aspersion) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $aspersions->links() }}
    </div>
</div>
@endsection