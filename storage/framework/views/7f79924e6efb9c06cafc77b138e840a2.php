<?php $__env->startSection('title', 'Aspersiones - Sara Palma'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-spray-can me-2"></i>Aspersiones</h2>
    <?php if(session('finca_logged') || (auth()->check() && !Auth::user()->isAdmin())): ?>
    <a href="<?php echo e(route('aspersions.create')); ?>" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>Nueva Aspersión
    </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <?php if(auth()->check() && Auth::user()->isAdmin()): ?>
                        <th>Finca</th>
                        <th>Usuario</th>
                        <?php endif; ?>
                        <th>Fecha</th>
                        <th>Semana</th>
                        <th>Tipo</th>
                        <th>Hectáreas</th>
                        <th>Lotes</th>
                        <th>Código Mezcla</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $aspersions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aspersion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if(auth()->check() && Auth::user()->isAdmin()): ?>
                        <td><?php echo e($aspersion->finca->name); ?></td>
                        <td><?php echo e($aspersion->user->name ?? 'Finca'); ?></td>
                        <?php endif; ?>
                        <td><?php echo e($aspersion->application_date->format('d/m/Y')); ?></td>
                        <td><span class="badge bg-secondary">Semana <?php echo e($aspersion->week_number); ?></span></td>
                        <td>
                            <span class="badge <?php echo e($aspersion->application_type == 'aplicacion_1' ? 'bg-primary' : 'bg-success'); ?>">
                                <?php echo e($aspersion->application_type == 'aplicacion_1' ? 'Aplicación 1' : 'Aplicación 2'); ?>

                            </span>
                        </td>
                        <td><?php echo e($aspersion->hectares); ?> ha</td>
                        <td>
                            <small class="text-muted"><?php echo e(Str::limit($aspersion->aspersed_lots ?? 'N/A', 30)); ?></small>
                        </td>
                      
                        <td>
                            <?php if($aspersion->codigos && $aspersion->codigos->count() > 0): ?>
                                <?php $__currentLoopData = $aspersion->codigos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $codigo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <code><?php echo e($codigo->codigo); ?></code>
                                    <br><small class="text-muted"><?php echo e($codigo->mezcla?->nombre ?? 'Sin mezcla'); ?></small>
                                    <?php if(!$loop->last): ?><br><?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php elseif($aspersion->codigo): ?>
                                <code><?php echo e($aspersion->codigo->codigo); ?></code>
                                <br><small class="text-muted"><?php echo e($aspersion->codigo->mezcla?->nombre ?? 'Sin mezcla'); ?></small>
                            <?php else: ?>
                                <small class="text-muted">N/A</small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('aspersions.show', $aspersion)); ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <?php echo e($aspersions->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/aspersions/index.blade.php ENDPATH**/ ?>