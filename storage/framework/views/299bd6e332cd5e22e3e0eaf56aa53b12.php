<?php $__env->startSection('title', 'Productos - Código <?php echo e($codigo->codigo); ?> - SaraPalma'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>Productos - Código <?php echo e($codigo->codigo); ?></h2>
    <a href="<?php echo e(route('codigos.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5>Agregar Producto</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('codigos.productos.store', $codigo)); ?>">
            <?php echo csrf_field(); ?>
            
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th width="5%">Sel.</th>
                            <th width="50%">Producto</th>
                            <th width="20%">Cantidad</th>
                            <th width="25%">Unidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="productos[]" value="<?php echo e($producto->id); ?>" 
                                       class="form-check-input"
                                       <?php echo e($productosAsociados->contains('id', $producto->id) ? 'disabled checked' : ''); ?>>
                            </td>
                            <td><?php echo e($producto->commercial_name); ?></td>
                            <td>
                                <input type="number" class="form-control form-control-sm" 
                                       value="<?php echo e($producto->cantidad_producto); ?>" 
                                       step="0.01" readonly>
                            </td>
                            <td><?php echo e($producto->unit); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Agregar Productos Seleccionados
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Productos Asociados</h5>
    </div>
    <div class="card-body">
        <?php if($productosAsociados->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $productosAsociados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($producto->commercial_name); ?></td>
                        <td><?php echo e($producto->pivot->cantidad_aplicacion ?? $producto->cantidad_producto); ?></td>
                        <td><?php echo e($producto->unit); ?></td>
                        <td>
                            <form action="<?php echo e(route('codigos.productos.destroy', [$codigo, $producto->id])); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar producto?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="text-center text-muted">No hay productos asociados a este código.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/codigos/productos.blade.php ENDPATH**/ ?>