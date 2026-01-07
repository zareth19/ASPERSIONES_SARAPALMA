<?php $__env->startSection('title', 'Iniciar Sesión - SaraPalma'); ?>

<?php $__env->startPush('styles'); ?>
<style>
body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: url('<?php echo e(asset('images/imagenLogin/image.png')); ?>') no-repeat center center fixed;
    background-size: cover;
}
.login-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 10;
    gap: 20px;
}
.login-card {
    background: rgba(255, 255, 255, 0.7);
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    overflow: hidden;
    max-width: 400px;
    width: 100%;
    padding: 40px 30px;
}
.logo-section {
    text-align: center;
    margin-bottom: 30px;
}
.logo-section img {
    max-height: 80px;
    width: auto;
}
.form-title {
    text-align: center;
    color: #333;
    font-weight: 600;
    font-size: 24px;
    margin-bottom: 30px;
}
.form-group {
    margin-bottom: 20px;
}
.form-label {
    color: #666;
    font-weight: 500;
    margin-bottom: 8px;
    display: block;
    font-size: 14px;
}
.form-control, .form-select {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 12px 15px;
    font-size: 16px;
    width: 100%;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}
.form-control:focus, .form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    outline: none;
}
.form-control::placeholder {
    color: #999;
}
.btn-login {
    background: #28a745;
    border: 1px solid #28a745;
    border-radius: 5px;
    padding: 12px;
    font-size: 16px;
    font-weight: 600;
    color: white;
    width: 100%;
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-login:hover {
    background: #218838;
    border-color: #218838;
}
.forgot-password {
    text-align: center;
    margin-top: 15px;
}
.forgot-password a {
    color: #28a745;
    text-decoration: none;
    font-size: 14px;
}
.forgot-password a:hover {
    text-decoration: underline;
}
.invalid-feedback {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
}
.is-invalid {
    border-color: #dc3545;
}
.developer-info {
    text-align: center;
    color: #666;
    font-size: 14px;
    padding: 20px;
}
.developer-info p {
    margin: 0;
}
.developer-info strong {
    color: #545c57;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-container">
    <div class="login-card">
        <div class="logo-section">
            <img src="<?php echo e(asset('images/image.png')); ?>" alt="Sara Palma">
        </div>
        
        <h2 class="form-title">INGRESO USUARIOS</h2>
        
        <form method="POST" action="<?php echo e(route('login')); ?>" id="loginForm">
            <?php echo csrf_field(); ?>
            
            <div class="form-group">
                <input type="text" 
                       class="form-control <?php $__errorArgs = ['document_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       id="document_number" 
                       name="document_number" 
                       value="<?php echo e(old('document_number')); ?>"
                       placeholder="Número de Documento o IBM"
                       required>
                <?php $__errorArgs = ['document_number'];
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

            <div class="form-group">
                <input type="password" 
                       class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       id="password" 
                       name="password" 
                       placeholder="Contraseña"
                       required>
                <?php $__errorArgs = ['password'];
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

            <div class="forgot-password">
                <a href="#" onclick="showForgotPassword()">Olvidé mi contraseña</a>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <button type="submit" class="btn-login">
                    INGRESAR
                </button>
            </div>
        </form>
    </div>
    <div class="developer-info">
        <p>Desarrollado por <strong>Zareth Fuentes</strong></p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Permitir tanto números como texto para IBM
document.getElementById('document_number').addEventListener('input', function(e) {
    // No restringir caracteres para permitir tanto documentos como IBM
});

function showForgotPassword() {
    Swal.fire({
        title: 'Recuperar Contraseña',
        text: 'Contacte al administrador del sistema para recuperar su contraseña',
        icon: 'info',
        confirmButtonColor: '#28a745'
    });
}

document.getElementById('loginForm').addEventListener('submit', function(e) {
    const documentNumber = document.getElementById('document_number').value;
    const password = document.getElementById('password').value;
    
    if (!documentNumber || !password) {
        e.preventDefault();
        Swal.fire({
            title: 'Campos requeridos',
            text: 'Por favor complete todos los campos',
            icon: 'warning',
            timer: 6000,
            timerProgressBar: true,
            confirmButtonColor: '#28a745'
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel\asperciones_sara_palma\resources\views/auth/login.blade.php ENDPATH**/ ?>