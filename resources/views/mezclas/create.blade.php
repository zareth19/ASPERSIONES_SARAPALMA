@extends('layouts.app')

@section('title', 'Nueva Mezcla - SaraPalma')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>Nueva Mezcla</h2>
    <a href="{{ route('mezclas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('mezclas.store') }}" id="mezclaForm">
                    @csrf
                    
                    <!-- PASO 1: NOMBRE DE LA MEZCLA -->
                    <div class="step" id="step1">
                        <h5><i class="fas fa-tag me-2"></i>Paso 1: Nombre de la Mezcla</h5>
                        <div class="mb-3">
                            <label for="mix_name" class="form-label">Nombre de la Mezcla *</label>
                            <input type="text" class="form-control" id="mix_name" name="nombre" 
                                   placeholder="Ej: sico 250 EC" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                            Siguiente <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </div>

                    <!-- PASO 2: CÓDIGOS -->
                    <div class="step d-none" id="step2">
                        <h5><i class="fas fa-code me-2"></i>Paso 2: Códigos de la Mezcla</h5>
                        <div class="mb-3">
                            <label class="form-label">Códigos *</label>
                            <div id="codigos-container">
                                <!-- Los códigos se agregarán aquí -->
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="addCodigo()">
                                <i class="fas fa-plus me-1"></i>Agregar Código
                            </button>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary" onclick="prevStep(1)">
                                <i class="fas fa-arrow-left me-1"></i> Anterior
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                                Siguiente <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <!-- PASO 3: PRODUCTOS POR CÓDIGO -->
                    <div class="step d-none" id="step3">
                        <h5><i class="fas fa-boxes me-2"></i>Paso 3: Productos por Código</h5>
                        <div id="productos-por-codigo">
                            <!-- Los productos por código se mostrarán aquí -->
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary" onclick="prevStep(2)">
                                <i class="fas fa-arrow-left me-1"></i> Anterior
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Crear Mezcla
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-info-circle me-2"></i>Progreso</h6>
            </div>
            <div class="card-body">
                <div class="progress mb-3">
                    <div class="progress-bar" id="progress-bar" style="width: 33%"></div>
                </div>
                <ul class="list-unstyled">
                    <li id="progress-1" class="text-primary"><i class="fas fa-circle me-2"></i>Nombre de mezcla</li>
                    <li id="progress-2" class="text-muted"><i class="far fa-circle me-2"></i>Códigos</li>
                    <li id="progress-3" class="text-muted"><i class="far fa-circle me-2"></i>Productos</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear producto -->
<div class="modal fade" id="createProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_commercial_name" class="form-label">Nombre Comercial *</label>
                            <input type="text" class="form-control" id="modal_commercial_name" 
                                   name="commercial_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="modal_active_ingredient" class="form-label">Ingrediente Activo *</label>
                            <input type="text" class="form-control" id="modal_active_ingredient" 
                                   name="active_ingredient" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_category_id" class="form-label">Categoría *</label>
                            <select class="form-select" id="modal_category_id" name="category_id" required>
                                <option value="">Seleccione...</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="modal_presentation" class="form-label">Presentación</label>
                            <input type="text" class="form-control" id="modal_presentation" 
                                   name="presentation" placeholder="Ej: 1L, 500ml">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" onclick="saveNewProduct()">
                    <i class="fas fa-save me-1"></i>Crear Producto
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentStep = 1;
let codigoIndex = 0;
let searchTimeout;

function nextStep(step) {
    if (validateCurrentStep()) {
        document.getElementById('step' + currentStep).classList.add('d-none');
        document.getElementById('step' + step).classList.remove('d-none');
        
        updateProgress(currentStep, step);
        
        if (step === 3) {
            generateProductosPorCodigo();
        }
        
        currentStep = step;
    }
}

function prevStep(step) {
    document.getElementById('step' + currentStep).classList.add('d-none');
    document.getElementById('step' + step).classList.remove('d-none');
    updateProgress(currentStep, step);
    currentStep = step;
}

function updateProgress(from, to) {
    const progress = (to / 3) * 100;
    document.getElementById('progress-bar').style.width = progress + '%';
    
    const fromEl = document.getElementById('progress-' + from);
    const toEl = document.getElementById('progress-' + to);
    
    fromEl.innerHTML = '<i class="fas fa-check-circle me-2 text-success"></i>' + fromEl.textContent.replace(/.*?(\w)/, '$1');
    fromEl.className = 'text-success';
    
    toEl.innerHTML = '<i class="fas fa-circle me-2"></i>' + toEl.textContent.replace(/.*?(\w)/, '$1');
    toEl.className = 'text-primary';
}

function validateCurrentStep() {
    if (currentStep === 1) {
        const mixName = document.getElementById('mix_name').value.trim();
        if (!mixName) {
            alert('Por favor ingrese el nombre de la mezcla');
            return false;
        }
    } else if (currentStep === 2) {
        const codigos = document.querySelectorAll('.codigo-input');
        if (codigos.length === 0) {
            alert('Por favor agregue al menos un código');
            return false;
        }
        for (let codigo of codigos) {
            if (!codigo.value.trim()) {
                alert('Por favor complete todos los códigos');
                return false;
            }
        }
    }
    return true;
}

function addCodigo() {
    const container = document.getElementById('codigos-container');
    const codigoDiv = document.createElement('div');
    codigoDiv.className = 'row mb-2 codigo-row align-items-end';
    codigoDiv.innerHTML = `
        <div class="col-md-8 mb-2">
            <label class="form-label"><small>Código ${codigoIndex + 1} *</small></label>
            <input type="text" class="form-control codigo-input" 
                   name="codigos[]" 
                   placeholder="Ingrese código (solo números)"
                   pattern="[0-9]*"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   required>
        </div>
        <div class="col-md-4 mb-2">
            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeCodigo(this)">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
    `;
    container.appendChild(codigoDiv);
    codigoIndex++;
}

function removeCodigo(button) {
    const container = document.getElementById('codigos-container');
    if (container.children.length > 1) {
        button.closest('.codigo-row').remove();
    } else {
        alert('Debe haber al menos un código');
    }
}

function generateProductosPorCodigo() {
    const codigos = Array.from(document.querySelectorAll('.codigo-input')).map(input => input.value.trim());
    const container = document.getElementById('productos-por-codigo');
    
    container.innerHTML = '';
    
    codigos.forEach((codigo, index) => {
        if (codigo) {
            const codigoSection = document.createElement('div');
            codigoSection.className = 'mb-4 border rounded p-3';
            codigoSection.innerHTML = `
                <h6><i class="fas fa-code me-2"></i>Código: ${codigo}</h6>
                <div class="productos-container" id="productos-${index}">
                    <!-- Productos para este código -->
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addProducto(${index})">
                    <i class="fas fa-plus me-1"></i>Agregar Producto
                </button>
            `;
            container.appendChild(codigoSection);
            
            addProducto(index);
        }
    });
}

function addProducto(codigoIndex) {
    const container = document.getElementById(`productos-${codigoIndex}`);
    const productoIndex = container.children.length;
    
    const productoDiv = document.createElement('div');
    productoDiv.className = 'row mb-2 producto-row align-items-end';
    productoDiv.innerHTML = `
        <div class="col-md-4 mb-2 position-relative">
            <label class="form-label"><small>Producto *</small></label>
            <input type="text" class="form-control producto-input" 
                   id="producto-${codigoIndex}-${productoIndex}"
                   name="productos[${codigoIndex}][${productoIndex}][name]"
                   placeholder="Escriba para buscar productos..."
                   oninput="searchProducts(this, ${codigoIndex}, ${productoIndex})"
                   onblur="setTimeout(() => hideSuggestions(${codigoIndex}, ${productoIndex}), 200)"
                   onfocus="showSuggestions(${codigoIndex}, ${productoIndex})"
                   autocomplete="off"
                   required>
            <div class="suggestions-dropdown" id="suggestions-${codigoIndex}-${productoIndex}" 
                 style="display: none; position: absolute; top: 100%; left: 0; right: 0; z-index: 1000; 
                        background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto;"></div>
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label"><small>Cantidad *</small></label>
            <input type="number" class="form-control" 
                   name="productos[${codigoIndex}][${productoIndex}][quantity]"
                   step="0.01" min="0.01" placeholder="0.00" required>
        </div>
        <div class="col-md-3 mb-2">
            <label class="form-label"><small>Unidad *</small></label>
            <select class="form-select" name="productos[${codigoIndex}][${productoIndex}][unit]" required>
                <option value="">Seleccione...</option>
                <option value="ml">ml</option>
                <option value="L">L</option>
                <option value="g">g</option>
                <option value="kg">kg</option>
                <option value="cc">cc</option>
            </select>
        </div>
        <div class="col-md-2 mb-2">
            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeProducto(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(productoDiv);
}

function removeProducto(button) {
    button.closest('.producto-row').remove();
}

function searchProducts(input, codigoIndex, productoIndex) {
    const query = input.value.trim();
    
    clearTimeout(searchTimeout);
    
    if (query.length < 2) {
        hideSuggestions(codigoIndex, productoIndex);
        return;
    }
    
    searchTimeout = setTimeout(() => {
        fetch(`/products/suggestions?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(products => {
                console.log('Productos encontrados:', products);
                showProductSuggestions(products, codigoIndex, productoIndex);
            })
            .catch(error => {
                console.error('Error:', error);
                // Si hay error, mostrar opción de crear producto
                showProductSuggestions([], codigoIndex, productoIndex);
            });
    }, 300);
}

function showProductSuggestions(products, codigoIndex, productoIndex) {
    const suggestionsDiv = document.getElementById(`suggestions-${codigoIndex}-${productoIndex}`);
    const input = document.getElementById(`producto-${codigoIndex}-${productoIndex}`);
    const productName = input.value.trim();
    
    console.log('Mostrando sugerencias para:', productName, 'Productos:', products);
    
    if (products.length === 0) {
        suggestionsDiv.innerHTML = `
            <div class="p-2 text-center">
                <div class="text-muted mb-2">
                    <i class="fas fa-search"></i> No se encontraron productos
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" 
                        onclick="createNewProduct('${productName}', ${codigoIndex}, ${productoIndex})">
                    <i class="fas fa-plus me-1"></i>Crear "${productName}"
                </button>
            </div>
        `;
    } else {
        let html = products.map(product => `
            <div class="suggestion-item p-2 border-bottom" 
                 style="cursor: pointer; transition: background-color 0.2s;"
                 onmouseover="this.style.backgroundColor='#f8f9fa'"
                 onmouseout="this.style.backgroundColor='white'"
                 onclick="selectProduct('${product.commercial_name}', ${codigoIndex}, ${productoIndex})">
                <div class="fw-bold">${product.commercial_name}</div>
                <small class="text-muted">${product.active_ingredient}</small>
            </div>
        `).join('');
        
        // Agregar opción de crear nuevo producto al final
        html += `
            <div class="p-2 border-top text-center">
                <button type="button" class="btn btn-sm btn-outline-secondary" 
                        onclick="createNewProduct('${productName}', ${codigoIndex}, ${productoIndex})">
                    <i class="fas fa-plus me-1"></i>Crear nuevo producto
                </button>
            </div>
        `;
        
        suggestionsDiv.innerHTML = html;
    }
    
    suggestionsDiv.style.display = 'block';
    console.log('Sugerencias mostradas');
}

function selectProduct(name, codigoIndex, productoIndex) {
    const input = document.getElementById(`producto-${codigoIndex}-${productoIndex}`);
    input.value = name;
    hideSuggestions(codigoIndex, productoIndex);
}

function hideSuggestions(codigoIndex, productoIndex) {
    const suggestionsDiv = document.getElementById(`suggestions-${codigoIndex}-${productoIndex}`);
    if (suggestionsDiv) {
        suggestionsDiv.style.display = 'none';
    }
}

function showSuggestions(codigoIndex, productoIndex) {
    const input = document.getElementById(`producto-${codigoIndex}-${productoIndex}`);
    if (input.value.length >= 2) {
        searchProducts(input, codigoIndex, productoIndex);
    }
}

function createNewProduct(productName, codigoIndex, productoIndex) {
    window.currentProductContext = { codigoIndex, productoIndex };
    document.getElementById('modal_commercial_name').value = productName;
    hideSuggestions(codigoIndex, productoIndex);
    new bootstrap.Modal(document.getElementById('createProductModal')).show();
}

function saveNewProduct() {
    const form = document.getElementById('createProductForm');
    const formData = new FormData(form);
    
    // Validar campos requeridos
    const commercialName = document.getElementById('modal_commercial_name').value.trim();
    const activeIngredient = document.getElementById('modal_active_ingredient').value.trim();
    const categoryId = document.getElementById('modal_category_id').value;
    
    if (!commercialName) {
        alert('El nombre comercial es obligatorio');
        return;
    }
    
    if (!activeIngredient) {
        alert('El ingrediente activo es obligatorio');
        return;
    }
    
    if (!categoryId) {
        alert('Debe seleccionar una categoría');
        return;
    }
    
    fetch('/products/store-ajax', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('createProductModal')).hide();
            
            if (window.currentProductContext) {
                const { codigoIndex, productoIndex } = window.currentProductContext;
                const input = document.getElementById(`producto-${codigoIndex}-${productoIndex}`);
                if (input) {
                    input.value = data.product.commercial_name;
                }
            }
            
            form.reset();
            alert('Producto creado exitosamente');
        } else {
            alert('Error al crear el producto: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error completo:', error);
        if (error.message) {
            alert('Error: ' + error.message);
        } else if (error.errors) {
            const errorMessages = Object.values(error.errors).flat().join('\n');
            alert('Errores de validación:\n' + errorMessages);
        } else {
            alert('Error al crear el producto');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    addCodigo();
});
</script>
@endpush