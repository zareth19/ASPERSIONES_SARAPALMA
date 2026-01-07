<?php $__env->startSection('title', 'Ver Aspersión - Sara Palma'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-spray-can me-2"></i>Aspersión - <?php echo e($aspersion->application_date->format('d/m/Y')); ?></h2>
    <a href="<?php echo e(route('aspersions.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle me-2"></i>Información de la Aspersión</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Finca:</strong>
                        <p><?php echo e($aspersion->finca->name); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Usuario:</strong>
                        <p><?php echo e($aspersion->user ? $aspersion->user->name : 'Finca'); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Fecha de Aplicación:</strong>
                        <p><?php echo e($aspersion->application_date->format('d/m/Y')); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Semana:</strong>
                        <p>Semana <?php echo e($aspersion->week_number); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Hectáreas Aplicadas:</strong>
                        <p><?php echo e($aspersion->hectares); ?> ha</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Fecha de Registro:</strong>
                        <p><?php echo e($aspersion->created_at->format('d/m/Y H:i')); ?></p>
                    </div>
                </div>
                <?php if($aspersion->mix_description): ?>
                <div class="row">
                    <div class="col-12 mb-3">
                        <strong>Descripción de la Mezcla:</strong>
                        <p><?php echo e($aspersion->mix_description); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div> 
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-map me-2"></i>Información de Finca</h6>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> <?php echo e($aspersion->finca->name); ?></p>
                <p><strong>IBM:</strong> <?php echo e($aspersion->finca->ibm); ?></p>
                <p><strong>Hectáreas Totales:</strong> <?php echo e($aspersion->finca->hectares); ?> ha</p>
                <p><strong>Ubicación:</strong> <?php echo e($aspersion->finca->location ?? 'No especificada'); ?></p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="fas fa-chart-pie me-2"></i>Resumen</h6>
            </div>
            <div class="card-body">
                <p><strong>Porcentaje de Finca:</strong> 
                    <?php echo e(number_format(($aspersion->hectares / $aspersion->finca->hectares) * 100, 1)); ?>%
                </p>
                <p><strong>Categorías Usadas:</strong> 
                    <?php echo e($aspersion->products->pluck('category.name')->unique()->count()); ?>

                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/aspersions/show.blade.php ENDPATH**/ ?>