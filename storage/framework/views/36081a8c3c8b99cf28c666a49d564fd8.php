<?php $__env->startSection('title', 'Usuarios - Sara Palma'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users me-2"></i>Gestión de Usuarios</h2>
    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-success">
        <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
    </a>
</div>

<?php if(session('temp_password')): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <strong>¡Importante!</strong> El correo no pudo ser enviado debido a restricciones corporativas.
    <br><strong>Email:</strong> <?php echo e(session('user_email')); ?>

    <br><strong>Contraseña temporal:</strong> <code><?php echo e(session('temp_password')); ?></code>
    <br><small>Por favor, proporciona estas credenciales al usuario manualmente.</small>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Finca</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->documentType->abbreviation); ?> <?php echo e($user->document_number); ?></td>
                        <td><?php echo e($user->email ?? 'N/A'); ?></td>
                        <td>
                            <span class="badge bg-primary"><?php echo e(ucfirst($user->role->name)); ?></span>
                        </td>
                        <td><?php echo e($user->finca->name ?? 'N/A'); ?></td>
                        <td>
                            <span class="badge <?php echo e($user->active ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($user->active ? 'Activo' : 'Inactivo'); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('users.show', $user)); ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if($user->active): ?>
                            <button class="btn btn-sm btn-danger" onclick="deleteUser(<?php echo e($user->id); ?>, '<?php echo e($user->name); ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <?php echo e($users->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function deleteUser(userId, userName) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Deseas eliminar permanentemente al usuario "${userName}"? Esta acción NO se puede revertir.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear formulario para enviar DELETE request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/users/${userId}`;
            form.innerHTML = `
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/users/index.blade.php ENDPATH**/ ?>