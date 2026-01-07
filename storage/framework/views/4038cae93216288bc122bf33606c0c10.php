<?php $__env->startSection('title', 'Fincas - SaraPalma'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
    <h2><i class="fas fa-map me-2"></i>Gestión de Fincas</h2>
    <a href="<?php echo e(route('fincas.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus me-2"></i><span class="d-none d-sm-inline">Nueva </span>Finca
    </a>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo e($fincas->total()); ?></h4>
                        <p class="mb-0">Total Fincas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-map fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo e($fincas->where('active', true)->count()); ?></h4>
                        <p class="mb-0">Activas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo e($fincas->sum('hectares')); ?></h4>
                        <p class="mb-0">Total Hectáreas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-ruler fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo e($fincas->sum('aspersions_count')); ?></h4>
                        <p class="mb-0">Aspersiones</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-spray-can fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros de Búsqueda</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('fincas.index')); ?>">
            <div class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, IBM, administrador, oficinista o coordinador..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Activas</option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactivas</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="col-md-1">
                    <a href="<?php echo e(route('fincas.index')); ?>" class="btn btn-outline-secondary w-100" title="Limpiar filtros">
                        <i class="fas fa-times"></i>
                    </a>
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
                        <th>CC</th>
                        <th>HA</th>
                        <th>IBM</th>
                        <th>FINCA</th>
                        <th>EXT</th>
                        <th>Tel. Directo</th>
                        <th>ADMINISTRADOR</th>
                        <th>#CELULAR</th>
                        <th>OFICINISTA</th>
                        <th>#CELULAR</th>
                        <th>COORD.EMPAQUE</th>
                        <th>#CELULAR</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $fincas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $finca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e(!$finca->active ? 'table-secondary' : ''); ?>">
                        <td><?php echo e($finca->cc); ?></td>
                        <td><?php echo e($finca->hectares); ?> ha</td>
                        <td><code><?php echo e($finca->ibm); ?></code></td>
                        <td>
                            <?php echo e($finca->name); ?>

                            <?php if(!$finca->active): ?>
                                <span class="badge bg-secondary ms-1">Inactiva</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($finca->extension); ?></td>
                        <td><?php echo e($finca->direct_phone); ?></td>
                        <td><?php echo e($finca->administrator_name); ?></td>
                        <td><?php echo e($finca->administrator_phone); ?></td>
                        <td><?php echo e($finca->office_worker_name); ?></td>
                        <td><?php echo e($finca->office_worker_phone); ?></td>
                        <td><?php echo e($finca->coordinator_name); ?></td>
                        <td><?php echo e($finca->coordinator_phone); ?></td>
                        <td style="min-width: 150px;">
                            <div class="btn-group-vertical btn-group-sm" role="group">
                                <a href="<?php echo e(route('fincas.show', $finca)); ?>" class="btn btn-info btn-sm mb-1" title="Ver detalles">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="<?php echo e(route('fincas.edit', $finca)); ?>" class="btn btn-warning btn-sm mb-1" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <button class="btn btn-success btn-sm mb-1" onclick="setPassword(<?php echo e($finca->id); ?>, '<?php echo e($finca->name); ?>')" title="Asignar contraseña">
                                    <i class="fas fa-key"></i> Clave
                                </button>
                                <?php if($finca->aspersions_count > 0): ?>
                                <span class="badge bg-info"><?php echo e($finca->aspersions_count); ?> aspersiones</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="13" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-search fa-2x mb-2"></i>
                                <p class="mb-0">No se encontraron fincas</p>
                                <?php if(request('search') || request('status')): ?>
                                    <small>Intenta ajustar los filtros de búsqueda</small>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    <?php echo e($fincas->links('pagination::bootstrap-5')); ?>

</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<style>
/* === Paginación personalizada === */
.pagination {
    justify-content: center;
    gap: 5px;
}

.page-item .page-link {
    color: #198754 !important; /* Verde Bootstrap */
    border-radius: 10px !important;
    border: 1px solid #19875420;
    padding: 6px 12px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.page-item.active .page-link {
    background-color: #198754 !important;
    border-color: #198754 !important;
    color: #fff !important;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(25, 135, 84, 0.4);
}

.page-item.disabled .page-link {
    color: #ccc !important;
    background-color: #f9f9f9 !important;
    border: none;
}

.page-link:hover {
    background-color: #19875415;
    border-color: #198754;
}

/* Flechas pequeñas y centradas */
.page-link svg {
    width: 12px;
    height: 12px;
    vertical-align: middle;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

<script>
function setPassword(fincaId, fincaName) {
    Swal.fire({
        title: 'Asignar Contraseña',
        text: `Finca: ${fincaName}`,
        input: 'password',
        inputPlaceholder: 'Ingrese la contraseña',
        showCancelButton: true,
        confirmButtonText: 'Asignar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#28a745',
        inputValidator: (value) => {
            if (!value) {
                return 'Debe ingresar una contraseña';
            }
            if (value.length < 6) {
                return 'La contraseña debe tener al menos 6 caracteres';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/fincas/${fincaId}/password`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    password: result.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Contraseña asignada correctamente',
                        icon: 'success',
                        confirmButtonColor: '#28a745'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo asignar la contraseña',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Error de conexión',
                    icon: 'error'
                });
            });
        }
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/fincas/index.blade.php ENDPATH**/ ?>