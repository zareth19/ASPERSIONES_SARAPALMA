<?php $__env->startSection('title', 'Mezclas - SaraPalma'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>Mezclas</h2>
    <a href="<?php echo e(route('mezclas.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Nueva Mezcla
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if($mezclas->count() > 0): ?>
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
                        <?php $__currentLoopData = $mezclas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mezcla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($mezcla->id); ?></td>
                            <td><?php echo e($mezcla->nombre); ?></td>
                            <td><?php echo e($mezcla->codigos->count()); ?></td>
                            <td><?php echo e($mezcla->created_at->format('d/m/Y')); ?></td>
                            <td>
                                <a href="<?php echo e(route('mezclas.show', $mezcla)); ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No hay mezclas registradas.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/mezclas/index.blade.php ENDPATH**/ ?>