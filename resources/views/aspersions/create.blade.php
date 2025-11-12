@extends('layouts.app')

@section('title', 'Nueva Aspersión - Sara Palma')

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
            <div class="card-header">
                <h5><i class="fas fa-plus me-2"></i>Formulario de Aspersión</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('aspersions.store') }}" id="aspersionForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="finca_name" class="form-label">
                                <i class="fas fa-map me-1"></i>Finca
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="finca_name" 
                                   value="{{ session('finca_logged') ? session('finca_name') : (Auth::user()->finca->name ?? 'No asignada') }}" 
                                   readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="application_date" class="form-label">
                                <i class="fas fa-calendar me-1"></i>Fecha de Aplicación *
                            </label>
                            <input type="date" 
                                   class="form-control @error('application_date') is-invalid @enderror" 
                                   id="application_date" 
                                   name="application_date" 
                                   value="{{ old('application_date', date('Y-m-d')) }}"
                                   required>
                            @error('application_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="week_display" class="form-label">
                                <i class="fas fa-calendar-week me-1"></i>Semana
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="week_display" 
                                   readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="hectares" class="form-label">
                                <i class="fas fa-ruler me-1"></i>Hectáreas *
                            </label>
                            <input type="number" 
                                   class="form-control @error('hectares') is-invalid @enderror" 
                                   id="hectares" 
                                   name="hectares" 
                                   value="{{ old('hectares') }}"
                                   step="0.01"
                                   min="0.01"
                                   max="{{ $maxHectares }}"
                                   required>
                            @error('hectares')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-flask me-1"></i>Productos a Aplicar *
                        </label>
                        <div id="products-container">
                            <!-- Los productos se cargarán aquí dinámicamente -->
                        </div>
                        <button type="button" class="btn btn-outline-success btn-sm mt-2" onclick="addProduct()">
                            <i class="fas fa-plus me-1"></i>Agregar Producto
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="mix_description" class="form-label">
                            <i class="fas fa-notes-medical me-1"></i>Descripción de la Mezcla
                        </label>
                        <textarea class="form-control" 
                                  id="mix_description" 
                                  name="mix_description" 
                                  rows="3"
                                  placeholder="Describa la mezcla utilizada...">{{ old('mix_description') }}</textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Registrar Aspersión
                        </button>
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
                <p><strong>IBM:</strong> {{ session('finca_logged') ? session('finca_ibm') : (Auth::user()->finca->ibm ?? 'N/A') }}</p>
                <p><strong>Hectáreas Totales:</strong> {{ $maxHectares }} ha</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="fas fa-list me-2"></i>Categorías Disponibles</h6>
            </div>
            <div class="card-body">
                @foreach($categories as $category)
                <div class="mb-2">
                    <strong>{{ $category->name }}</strong>
                    <ul class="list-unstyled ms-3">
                        @foreach($category->products as $product)
                        <li><small>• {{ $product->commercial_name }}</small></li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const categories = @json($categories);
let productIndex = 0;

// Calcular semana al cambiar fecha
document.getElementById('application_date').addEventListener('change', function() {
    const date = new Date(this.value);
    const week = getWeekNumber(date);
    document.getElementById('week_display').value = `Semana ${week}`;
});

function getWeekNumber(date) {
    const firstDayOfYear = new Date(date.getFullYear(), 0, 1);
    const pastDaysOfYear = (date - firstDayOfYear) / 86400000;
    return Math.ceil((pastDaysOfYear + firstDayOfYear.getDay() + 1) / 7);
}

function addProduct() {
    const container = document.getElementById('products-container');
    const productDiv = document.createElement('div');
    productDiv.className = 'row mb-2 product-row';
    productDiv.innerHTML = `
        <div class="col-md-4">
            <select class="form-select" name="products[${productIndex}][category_id]" onchange="loadProducts(this, ${productIndex})" required>
                <option value="">Seleccionar categoría...</option>
                ${categories.map(cat => `<option value="${cat.id}">${cat.name}</option>`).join('')}
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-select" name="products[${productIndex}][id]" required disabled>
                <option value="">Seleccionar producto...</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control" name="products[${productIndex}][quantity]" 
                   placeholder="Cantidad" step="0.01" min="0.01" required>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(productDiv);
    productIndex++;
}

function loadProducts(categorySelect, index) {
    const categoryId = categorySelect.value;
    const productSelect = document.querySelector(`select[name="products[${index}][id]"]`);
    
    productSelect.innerHTML = '<option value="">Seleccionar producto...</option>';
    productSelect.disabled = !categoryId;
    
    if (categoryId) {
        const category = categories.find(cat => cat.id == categoryId);
        if (category) {
            category.products.forEach(product => {
                const option = document.createElement('option');
                option.value = product.id;
                option.textContent = `${product.commercial_name} - ${product.active_ingredient} (${product.unit})`;
                productSelect.appendChild(option);
            });
        }
    }
}

function removeProduct(button) {
    button.closest('.product-row').remove();
}

// Validaciones en tiempo real
const maxHectares = {{ $maxHectares }};
document.getElementById('hectares').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9.]/g, '');
    
    if (parseFloat(this.value) > maxHectares) {
        this.setCustomValidity(`No puede superar las ${maxHectares} hectáreas de la finca`);
    } else {
        this.setCustomValidity('');
    }
});

// Confirmación antes de enviar
document.getElementById('aspersionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const products = document.querySelectorAll('.product-row');
    if (products.length === 0) {
        Swal.fire({
            title: 'Productos requeridos',
            text: 'Debe agregar al menos un producto',
            icon: 'warning',
            timer: 6000,
            timerProgressBar: true
        });
        return;
    }
    
    Swal.fire({
        title: '¿Confirmar aspersión?',
        text: '¿Está seguro de que desea registrar esta aspersión?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, registrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('application_date').dispatchEvent(new Event('change'));
    addProduct(); // Agregar un producto por defecto
});
</script>
@endpush