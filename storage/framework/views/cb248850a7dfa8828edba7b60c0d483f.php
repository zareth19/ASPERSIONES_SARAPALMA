<?php $__env->startSection('title', 'Códigos - SaraPalma'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-code me-2"></i>Códigos</h2>
    <a href="<?php echo e(route('mezclas.index')); ?>" class="btn btn-success">
        <i class="fas fa-flask me-2"></i>Ver Mezclas
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('codigos.index')); ?>">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="<?php echo e($search); ?>" 
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
        <?php if($mezclas->count() > 0): ?>
            <div class="accordion" id="mezclasAccordion">
                <?php $__currentLoopData = $mezclas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mezcla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?php echo e($mezcla->id); ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($mezcla->id); ?>">
                                <div class="d-flex justify-content-between w-100 me-3">
                                    <span><strong><?php echo e($mezcla->nombre); ?></strong></span>
                                    <span class="badge bg-primary"><?php echo e($mezcla->codigos_count); ?> códigos</span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse<?php echo e($mezcla->id); ?>" class="accordion-collapse collapse" data-bs-parent="#mezclasAccordion">
                            <div class="accordion-body">
                                <?php if($mezcla->codigos->count() > 0): ?>
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
                                                <?php $__currentLoopData = $mezcla->codigos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $codigo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($codigo->codigo); ?></td>
                                                        <td><?php echo e($codigo->productos->count()); ?></td>
                                                        <td><?php echo e($codigo->aspersions_count); ?></td>
                                                        <td>
                                                            <a href="<?php echo e(route('codigos.edit', $codigo)); ?>" class="btn btn-sm btn-warning">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="<?php echo e(route('codigos.productos', $codigo)); ?>" class="btn btn-sm btn-info">
                                                                <i class="fas fa-cog"></i>
                                                            </a>
                                                            <?php if($codigo->aspersions_count == 0): ?>
                                                                <form action="<?php echo e(route('codigos.destroy', $codigo)); ?>" method="POST" class="d-inline">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar código?')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">No hay códigos para esta mezcla.</p>
                                <?php endif; ?>
                                <div class="mt-3">
                                    <a href="<?php echo e(route('codigos.create', $mezcla)); ?>" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i>Agregar Código
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-muted">No hay mezclas registradas.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/codigos/index.blade.php ENDPATH**/ ?>