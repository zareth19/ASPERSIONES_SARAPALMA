@extends('layouts.app')

@section('title', 'Nueva Aspersión - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-spray-can me-2"></i>Nueva Aspersión</h2>
    <a href="{{ route('aspersions.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('aspersions.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="finca_name" class="form-label">Nombre de la Finca *</label>
                            <input type="text" class="form-control @error('finca_name') is-invalid @enderror" 
                                   id="finca_name" name="finca_name" 
                                   value="{{ old('finca_name', session('finca_logged') ? session('finca_name') : (Auth::user()->finca->name ?? '')) }}" 
                                   readonly>
                            @error('finca_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="application_date" class="form-label">Fecha de Aplicación *</label>
                            <input type="date" class="form-control @error('application_date') is-invalid @enderror" 
                                   id="application_date" name="application_date" 
                                   value="{{ old('application_date', date('Y-m-d')) }}" required>
                            @error('application_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="week_number" class="form-label">Número de Semana *</label>
                            <input type="number" class="form-control @error('week_number') is-invalid @enderror" 
                                   id="week_number" name="week_number" min="1" max="52" 
                                   value="{{ old('week_number', date('W')) }}" required>
                            @error('week_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hectares" class="form-label">Volumen/HA*</label>
                            <input type="number" class="form-control @error('hectares') is-invalid @enderror" 
                                   id="hectares" name="hectares" step="0.01" min="0.01" 
                                   value="{{ old('hectares') }}" required>
                            @error('hectares')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                        <div class="mb-3">
                        <label for="aspersed_lots" class="form-label"> Areas O Lotes Asperjados</label>
                        <textarea class="form-control @error('aspersed_lots') is-invalid @enderror" 
                                  id="aspersed_lots" name="aspersed_lots" rows="2" 
                                  placeholder="Ej: Lote 1, Lote 2, Lote 3...">{{ old('aspersed_lots') }}</textarea>
                        @error('aspersed_lots')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="categoria_nombre" readonly placeholder="Seleccione un código">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="codigo" class="form-label">Código</label>
                            <div class="position-relative">
                                <input type="text" class="form-control @error('codigo') is-invalid @enderror" 
                                       id="codigo" name="codigo" value="{{ old('codigo') }}" 
                                       placeholder="Ingrese código" autocomplete="off" 
                                       onkeyup="searchCodigos(this.value)" 
                                       onblur="loadCodigoInfo(this.value)">
                                <div id="codigo-suggestions" class="dropdown-menu" style="display: none; position: absolute; z-index: 1000;"></div>
                            </div>
                            @error('codigo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nombre de la Mezcla</label>
                            <input type="text" class="form-control" id="mezcla_nombre" readonly placeholder="Seleccione un código">
                        </div>
                    </div>

              
                    <div class="mb-3">
                        <label for="mix_description" class="form-label"> OBSERVACION</label>
                        <textarea class="form-control @error('mix_description') is-invalid @enderror" 
                                  id="mix_description" name="mix_description" rows="2" 
                                  placeholder="Descripción de los productos utilizados...">{{ old('mix_description') }}</textarea>
                        @error('mix_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Crear Aspersión
                        </button>
                        <a href="{{ route('aspersions.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-info-circle me-2"></i>Información</h6>
            </div>
            <div class="card-body">
                <p><strong>Usuario:</strong> {{ session('finca_logged') ? 'Finca' : Auth::user()->name }}</p>
                <p><strong>Finca:</strong> {{ session('finca_logged') ? session('finca_name') : (Auth::user()->finca->name ?? 'No asignada') }}</p>
                @if(isset($maxHectares))
                    <p><strong>Hectáreas disponibles:</strong> {{ $maxHectares }} ha</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let searchTimeout;

function searchCodigos(query) {
    clearTimeout(searchTimeout);
    const suggestions = document.getElementById('codigo-suggestions');
    
    if (query.length < 1) {
        suggestions.style.display = 'none';
        document.getElementById('mezcla_nombre').value = '';
        document.getElementById('categoria_nombre').value = '';
        return;
    }
    
    searchTimeout = setTimeout(() => {
        fetch(`/api/mix-codes?codigo=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                suggestions.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(codigo => {
                        const item = document.createElement('a');
                        item.className = 'dropdown-item';
                        item.href = '#';
                        item.innerHTML = `
                            <strong>${codigo.codigo}</strong><br>
                            <small class="text-muted">${codigo.nombre_mezcla || 'Sin mezcla'} - ${codigo.categoria || 'Sin categoría'}</small>
                        `;
                        item.onclick = (e) => {
                            e.preventDefault();
                            document.getElementById('codigo').value = codigo.codigo;
                            suggestions.style.display = 'none';
                            showCodigoInfo(codigo);
                        };
                        suggestions.appendChild(item);
                    });
                    suggestions.style.display = 'block';
                } else {
                    suggestions.style.display = 'none';
                }
            })
            .catch(error => console.error('Error:', error));
    }, 300);
}

function loadCodigoInfo(codigo) {
    if (!codigo.trim()) {
        document.getElementById('mezcla_nombre').value = '';
        document.getElementById('categoria_nombre').value = '';
        return;
    }
    
    fetch(`/api/mix-codes?codigo=${encodeURIComponent(codigo)}`)
        .then(response => response.json())
        .then(data => {
            const codigoData = data.find(c => c.codigo === codigo);
            if (codigoData) {
                showCodigoInfo(codigoData);
            } else {
                document.getElementById('mezcla_nombre').value = 'Código no encontrado';
                document.getElementById('categoria_nombre').value = 'Código no encontrado';
            }
        })
        .catch(error => console.error('Error:', error));
}

function showCodigoInfo(codigo) {
    document.getElementById('mezcla_nombre').value = codigo.nombre_mezcla || 'Sin mezcla asignada';
    document.getElementById('categoria_nombre').value = codigo.categoria || 'Sin categoría';
}

// Ocultar sugerencias al hacer clic fuera
document.addEventListener('click', function(e) {
    if (!e.target.closest('#codigo-suggestions') && !e.target.matches('#codigo')) {
        document.getElementById('codigo-suggestions').style.display = 'none';
    }
});
</script>
@endpush