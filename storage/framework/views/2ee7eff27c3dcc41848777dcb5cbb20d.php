<?php $__env->startSection('title', 'Mezcla: ' . $mezcla->nombre . ' - SaraPalma'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i><?php echo e($mezcla->nombre); ?></h2>
    <div>
        <a href="<?php echo e(route('codigos.create', $mezcla)); ?>" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Nuevo Código
        </a>
        <a href="<?php echo e(route('mezclas.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Códigos de la Mezcla</h5>
    </div>
    <div class="card-body">
        <?php if($mezcla->codigos->count() > 0): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Productos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $mezcla->codigos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $codigo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($codigo->codigo); ?></td>
                                <td><?php echo e($codigo->productos->count()); ?></td>
                                <td>
                                    <a href="<?php echo e(route('codigos.edit', $codigo)); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo e(route('codigos.productos', $codigo)); ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-cog"></i> Gestionar Productos
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No hay códigos asociados a esta mezcla.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/mezclas/show.blade.php ENDPATH**/ ?>