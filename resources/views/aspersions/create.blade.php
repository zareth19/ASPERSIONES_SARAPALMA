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
            <div class="card-header">
                <h5><i class="fas fa-plus me-2"></i>Formulario de Aspersión</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('aspersions.store') }}" id="aspersionForm">
                    @csrf
                    
                    <!-- FILA 1: FINCA, FECHA, SEMANA -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="finca_name" class="form-label">
                                <i class="fas fa-map me-1"></i>Finca
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="finca_name" 
                                   value="{{ session('finca_logged') ? session('finca_name') : (Auth::user()->finca->name ?? 'No asignada') }}" 
                                   readonly>
                        </div>

                        <div class="col-md-4 mb-3">
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

                        <div class="col-md-4 mb-3">
                            <label for="week_display" class="form-label">
                                <i class="fas fa-calendar-week me-1"></i>Semana
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="week_display" 
                                   readonly>
                        </div>
                    </div>

                    <!-- FILA 2: CÓDIGOS CON CATEGORÍAS Y MEZCLA -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-code me-1"></i>Códigos de Mezcla por Categoría
                        </label>
                        <div id="codigos-container">
                            <!-- Los códigos con categorías se agregarán aquí dinámicamente -->
                        </div>
                        @error('categories')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('codigo_ids')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addCodigo()">
                            <i class="fas fa-plus me-1"></i>Agregar Código
                        </button>
                    </div>

                    <!-- FILA 4: VOLUMEN Y LOTES ASPERJADOS -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="volumen_ha" class="form-label">
                                <i class="fas fa-tint me-1"></i>Volumen/Ha *
                            </label>
                            <input type="number" 
                                   class="form-control @error('volumen_ha') is-invalid @enderror" 
                                   id="volumen_ha" 
                                   name="volumen_ha" 
                                   value="{{ old('volumen_ha') }}"
                                   step="0.01"
                                   min="0.01"
                                   max="{{ $maxHectares }}"
                                   placeholder="Volumen por hectárea"
                                   required>
                            <div class="form-text">Máximo: {{ $maxHectares }} hectáreas</div>
                            @error('volumen_ha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="aspersed_lots" class="form-label">
                                <i class="fas fa-map-marked-alt me-1"></i>Lotes Asperjados
                            </label>
                            <textarea class="form-control @error('aspersed_lots') is-invalid @enderror" 
                                      id="aspersed_lots" 
                                      name="aspersed_lots" 
                                      rows="3"
                                      placeholder="LOTE:2,LOTE:3,LOTE:5...">{{ old('aspersed_lots') }}</textarea>
                            @error('aspersed_lots')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mix_description" class="form-label">
                            <i class="fas fa-notes-medical me-1"></i>Observaciones de Aplicación
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

       
    </div>
</div>
@endsection
@push('scripts')
<script>
const categoriesData = @json($categories->map(function($cat) { return ['id' => $cat->id, 'name' => $cat->name]; }));
const codigosExistentes = @json($codigosExistentes ?? []);
let productIndex = 0;

// Función para escapar HTML y prevenir XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function getWeekNumber(date) {
    const firstDayOfYear = new Date(date.getFullYear(), 0, 1);
    const pastDaysOfYear = (date - firstDayOfYear) / 86400000;
    return Math.ceil((pastDaysOfYear + firstDayOfYear.getDay() + 1) / 7);
}

document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('application_date');
    if (dateInput && dateInput.value) {
        const date = new Date(dateInput.value);
        const week = getWeekNumber(date);
        document.getElementById('week_display').value = `Semana ${week}`;
    }
    
    // Agregar el primer código automáticamente
    addCodigo();
});

document.getElementById('application_date').addEventListener('change', function() {
    const date = new Date(this.value);
    const week = getWeekNumber(date);
    document.getElementById('week_display').value = `Semana ${week}`;
});

// FUNCIONES PARA CÓDIGOS CON AUTOCOMPLETADO Y CATEGORÍAS
function addCodigo() {
    const container = document.getElementById('codigos-container');
    const codigoIndex = container.children.length;
    
    const codigoDiv = document.createElement('div');
    codigoDiv.className = 'row mb-2 codigo-row align-items-end';
    codigoDiv.innerHTML = `
        <div class="col-md-3 mb-2">
            <label class="form-label"><small>Categoría *</small></label>
            <select class="form-select form-select-sm category-input" 
                    name="categories[]"
                    required>
                <option value="">-- Seleccione categoría --</option>
                ${categoriesData.map(cat => 
                    '<option value="' + escapeHtml(cat.id) + '">' + escapeHtml(cat.name) + '</option>'
                ).join('')}
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label"><small>Código *</small></label>
            <input type="text" 
                   class="form-control form-control-sm codigo-input" 
                   name="codigos[]" 
                   placeholder="Ingrese código"
                   list="codigos_datalist_${codigoIndex}"
                   inputmode="numeric"
                   pattern="[0-9]*"
                   data-index="${codigoIndex}"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   onchange="checkCodigoSelection(this)"
                   required>
            <datalist id="codigos_datalist_${codigoIndex}">
                ${codigosExistentes.map(item => 
                    '<option value="' + escapeHtml(item.code) + '" data-id="' + escapeHtml(item.id) + '" data-mezcla="' + escapeHtml(item.mezcla) + '">' + escapeHtml(item.code) + ' - ' + escapeHtml(item.mezcla) + '</option>'
                ).join('')}
            </datalist>
            <input type="hidden" class="codigo-id-input" name="codigo_ids[]" value="">
        </div>
        <div class="col-md-4 mb-2">
            <label class="form-label"><small>Mezcla</small></label>
            <small class="mezcla-info-${codigoIndex} text-success fw-bold d-block p-2 bg-light rounded">-</small>
        </div>
        <div class="col-md-2 mb-2">
            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeCodigo(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    container.appendChild(codigoDiv);
}

function checkCodigoSelection(input) {
    const selectedCodigo = codigosExistentes.find(c => c.code === input.value);
    const row = input.closest('.codigo-row');
    const hiddenInput = row.querySelector('.codigo-id-input');
    const codigoIndex = input.dataset.index;
    const infoElement = row.querySelector(`.mezcla-info-${codigoIndex}`);
    
    if (selectedCodigo) {
        infoElement.textContent = selectedCodigo.mezcla;
        infoElement.classList.remove('d-none');
        hiddenInput.value = selectedCodigo.id;
    } else {
        infoElement.textContent = '-';
        infoElement.classList.remove('d-none');
        hiddenInput.value = '';
    }
}

function removeCodigo(button) {
    const container = document.getElementById('codigos-container');
    if (container.children.length > 1) {
        button.closest('.codigo-row').remove();
    } else {
        if (window.Swal) {
            Swal.fire('Debe haber al menos un código de mezcla', '', 'warning');
        } else {
            alert('Debe haber al menos un código de mezcla');
        }
    }
}

function addProduct() {
    const container = document.getElementById('products-container');
    const productDiv = document.createElement('div');
    productDiv.className = 'row mb-2 product-row';
    productDiv.innerHTML = `
        <div class="col-12 col-md-3 mb-2 mb-md-0">
            <label class="form-label d-md-none"><small>Categoría:</small></label>
            <select class="form-select form-select-sm" name="products[${productIndex}][category_id]" onchange="loadCategoryProducts(this, ${productIndex})">
                <option value="">Seleccionar categoría...</option>
                ${categories.map(cat => `<option value="${cat.id}">${cat.name}</option>`).join('')}
            </select>
        </div>
        <div class="col-12 col-md-3 mb-2 mb-md-0">
            <label class="form-label d-md-none"><small>Producto:</small></label>
            <select class="form-select form-select-sm" name="products[${productIndex}][id]" disabled required>
                <option value="">Seleccionar producto...</option>
            </select>
        </div>
        <div class="col-12 col-md-3 mb-2 mb-md-0">
            <label class="form-label d-md-none"><small>Ingrediente:</small></label>
            <input type="text" class="form-control form-control-sm" readonly placeholder="Ingrediente activo">
        </div>
        <div class="col-6 col-md-2 mb-2 mb-md-0">
            <label class="form-label d-md-none"><small>Cantidad:</small></label>
            <input type="number" class="form-control form-control-sm" name="products[${productIndex}][quantity]" step="0.01" min="0.01" placeholder="Cant." required>
        </div>
        <div class="col-6 col-md-1">
            <label class="form-label d-md-none"><small>Acción:</small></label>
            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeProduct(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(productDiv);
    productIndex++;
}

function removeProduct(button) {
    button.closest('.product-row').remove();
}

function loadCategoryProducts(select, index) {
    const categoryId = select.value;
    const productSelect = select.closest('.row').querySelector(`select[name="products[${index}][id]"]`);
    const ingredientInput = select.closest('.row').querySelector('input[readonly]');
    
    productSelect.innerHTML = '<option value="">Seleccionar producto...</option>';
    productSelect.disabled = !categoryId;
    ingredientInput.value = '';
    
    if (categoryId) {
        const category = categories.find(cat => cat.id == categoryId);
        if (category && category.products) {
            category.products.forEach(product => {
                const option = document.createElement('option');
                option.value = product.id;
                option.textContent = product.commercial_name;
                option.dataset.ingredient = product.active_ingredient;
                productSelect.appendChild(option);
            });
        }
    }
}

document.addEventListener('change', function(e) {
    if (e.target.matches('select[name*="[id]"]')) {
        const selectedOption = e.target.selectedOptions[0];
        const ingredientInput = e.target.closest('.row').querySelector('input[readonly]');
        ingredientInput.value = selectedOption.dataset.ingredient || '';
    }
});

function loadCodigoProducts(codigoId) {
    const container = document.getElementById('products-container');
    
    if (!codigoId) {
        return;
    }
    
    fetch('/aspersions/get-codigo-products', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ codigo_id: codigoId })
    })
    .then(response => response.json())
    .then(products => {
        // Limpiar productos existentes
        container.innerHTML = '';
        productIndex = 0;
        
        if (products.length === 0) {
            if (window.Swal) {
                Swal.fire('Este código no tiene productos asociados', '', 'info');
            } else {
                alert('Este código no tiene productos asociados');
            }
            return;
        }
        
        products.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.className = 'row mb-2 product-row';
            productDiv.innerHTML = `
                <div class="col-12 col-md-3 mb-2 mb-md-0">
                    <label class="form-label d-md-none"><small>Categoría:</small></label>
                    <input type="text" class="form-control form-control-sm" value="${product.category_name}" readonly>
                </div>
                <div class="col-12 col-md-3 mb-2 mb-md-0">
                    <label class="form-label d-md-none"><small>Producto:</small></label>
                    <input type="text" class="form-control form-control-sm" value="${product.commercial_name}" readonly>
                    <input type="hidden" name="products[${productIndex}][id]" value="${product.id}">
                </div>
                <div class="col-12 col-md-3 mb-2 mb-md-0">
                    <label class="form-label d-md-none"><small>Ingrediente:</small></label>
                    <input type="text" class="form-control form-control-sm" value="${product.active_ingredient}" readonly>
                </div>
                <div class="col-6 col-md-2 mb-2 mb-md-0">
                    <label class="form-label d-md-none"><small>Cantidad:</small></label>
                    <input type="number" class="form-control form-control-sm" name="products[${productIndex}][quantity]" value="${product.quantity}" step="0.01" min="0.01" required>
                </div>
                <div class="col-6 col-md-1">
                    <label class="form-label d-md-none"><small>Acción:</small></label>
                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeProduct(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            container.appendChild(productDiv);
            productIndex++;
        });
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.Swal) {
            Swal.fire('Error al cargar los productos del código', '', 'error');
        } else {
            alert('Error al cargar los productos del código');
        }
    });
}
</script>
@endpush