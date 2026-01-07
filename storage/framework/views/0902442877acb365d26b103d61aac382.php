<?php $__env->startSection('title', 'Productos - Sara Palma'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-flask me-2"></i>Gestión de Productos</h2>
    <a href="<?php echo e(route('products.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Nuevo Producto
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('products.index')); ?>">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="<?php echo e($search); ?>" 
                           placeholder="Buscar por nombre comercial, ingrediente activo o categoría...">
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
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre Comercial</th>
                        <th>Ingrediente Activo</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($product->commercial_name); ?></td>
                        <td><?php echo e($product->active_ingredient); ?></td>
                        <td><?php echo e($product->unit); ?></td>
                        <td><?php echo e($product->cantidad_producto ?? 'N/A'); ?></td>
                        <td>
                            <span class="badge bg-info"><?php echo e($product->category->name); ?></span>
                        </td>
                        <td>
                            <span class="badge <?php echo e($product->active ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($product->active ? 'Activo' : 'Inactivo'); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('products.show', $product)); ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('products.edit', $product)); ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <?php echo e($products->appends(['search' => $search])->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/products/index.blade.php ENDPATH**/ ?>