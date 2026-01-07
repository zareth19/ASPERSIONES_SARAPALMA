<?php $__env->startSection('title', 'Dashboard Finca - SaraPalma'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard - <?php echo e(session('finca_name', Auth::user()->finca->name ?? 'Finca')); ?></h2>
    <a href="<?php echo e(route('aspersions.create')); ?>" class="btn btn-success">
        <i class="fas fa-spray-can me-2"></i>Nueva Aspersión
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo e(session('finca_logged') ? session('finca_hectares', '0') : (Auth::user()->finca->hectares ?? 'N/A')); ?> ha</h4>
                        <p class="mb-0">Hectáreas Totales</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-map fa-2x"></i>
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
                        <h4><?php echo e($totalAspersiones); ?></h4>
                        <p class="mb-0">Total Aspersiones</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-spray-can fa-2x"></i>
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
                        <h4><?php echo e($aspersionesMes); ?></h4>
                        <p class="mb-0">Este Mes</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo e($hectareasAsperjadas); ?></h4>
                        <p class="mb-0">Ha. Asperjadas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-area fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-history me-2"></i>Aspersiones Recientes</h5>
            </div>
            <div class="card-body">
                <?php if($aspersionesRecientes->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Semana</th>
                                <th>Hectáreas</th>
                                <th>Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $aspersionesRecientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aspersion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($aspersion->application_date->format('d/m/Y')); ?></td>
                                <td><span class="badge bg-secondary">Semana <?php echo e($aspersion->week_number); ?></span></td>
                                <td><?php echo e($aspersion->hectares); ?> ha</td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($aspersion->products->count()); ?> productos</span>
                                    <?php if($aspersion->mix_description): ?>
                                        <i class="fas fa-comment-alt text-muted ms-1" title="<?php echo e($aspersion->mix_description); ?>"></i>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    <i class="fas fa-spray-can fa-2x mb-2 d-block"></i>
                                    No hay aspersiones registradas
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted">No hay aspersiones registradas aún.</p>
                <?php endif; ?>
                
                <div class="text-center mt-3">
                    <a href="<?php echo e(route('aspersions.index')); ?>" class="btn btn-outline-primary">
                        Ver Todas las Aspersiones
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="fas fa-info-circle me-2"></i>Información de la Finca</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong><i class="fas fa-map-marker-alt text-success me-1"></i>Nombre:</strong><br>
                    <span class="text-muted"><?php echo e(session('finca_name', Auth::user()->finca->name ?? 'N/A')); ?></span>
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-barcode text-warning me-1"></i>IBM:</strong><br>
                    <code><?php echo e(session('finca_ibm', Auth::user()->finca->ibm ?? 'N/A')); ?></code>
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-ruler text-info me-1"></i>Hectáreas:</strong><br>
                    <span class="text-muted"><?php echo e(session('finca_logged') ? session('finca_hectares', '0') : 'N/A'); ?> ha</span>
                </div>
                <div class="mb-3">
                    <strong><i class="fas fa-user text-primary me-1"></i>Usuario:</strong><br>
                    <span class="text-muted"><?php echo e(session('finca_logged') ? 'Acceso Finca' : Auth::user()->name); ?></span>
                </div>
                <?php if(!session('finca_logged') && Auth::user()->finca && Auth::user()->finca->location): ?>
                <div class="mb-3">
                    <strong><i class="fas fa-location-arrow text-secondary me-1"></i>Ubicación:</strong><br>
                    <span class="text-muted"><?php echo e(Auth::user()->finca->location); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/dashboard/finca.blade.php ENDPATH**/ ?>