<?php $__env->startSection('title', 'Nuevo Código - SaraPalma'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus me-2"></i>Nuevo Código<?php echo e(isset($mezcla) ? ' para ' . $mezcla->nombre : ''); ?></h2>
    <a href="<?php echo e(isset($mezcla) ? route('mezclas.show', $mezcla) : route('codigos.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('codigos.store')); ?>">
            <?php echo csrf_field(); ?>
            
            <?php if(isset($mezcla)): ?>
                <div class="mb-3">
                    <label class="form-label">Mezcla</label>
                    <input type="text" class="form-control" value="<?php echo e($mezcla->nombre); ?>" readonly>
                    <input type="hidden" name="mezcla_id" value="<?php echo e($mezcla->id); ?>">
                </div>
            <?php else: ?>
                <div class="mb-3">
                    <label for="mezcla_id" class="form-label">Mezcla *</label>
                    <select class="form-select <?php $__errorArgs = ['mezcla_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            id="mezcla_id" name="mezcla_id" required>
                        <option value="">Seleccione una mezcla...</option>
                        <?php $__currentLoopData = \App\Models\Mezcla::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m->id); ?>" <?php echo e(old('mezcla_id') == $m->id ? 'selected' : ''); ?>>
                                <?php echo e($m->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['mezcla_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            <?php endif; ?>
            
            <div class="mb-3">
                <label for="codigo" class="form-label">Código *</label>
                <input type="text" 
                       class="form-control <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       id="codigo" 
                       name="codigo" 
                       value="<?php echo e(old('codigo')); ?>"
                       placeholder="Ej: 12521001"
                       required>
                <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Crear Código
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/codigos/create.blade.php ENDPATH**/ ?>