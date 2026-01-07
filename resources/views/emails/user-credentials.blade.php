<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Credenciales de Acceso</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #28a745; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f8f9fa; }
        .credentials { background: white; padding: 15px; border-left: 4px solid #28a745; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sistema de Aspersiones Sara Palma</h1>
        </div>
        
        <div class="content">
            <h2>¡Bienvenido {{ $user->name }}!</h2>
            
            <p>Se ha creado tu cuenta en el Sistema de Aspersiones Sara Palma. A continuación encontrarás tus credenciales de acceso:</p>
            
            <div class="credentials">
                <h3>Credenciales de Acceso:</h3>
                <p><strong>Usuario:</strong> {{ $user->document_number }}</p>
                <p><strong>Contraseña Temporal:</strong> {{ $temporaryPassword }}</p>
                <p><strong>Rol:</strong> {{ ucfirst($user->role->name) }}</p>
                @if($user->finca)
                <p><strong>Finca Asignada:</strong> {{ $user->finca->name }}</p>
                @endif
            </div>
            
            <div class="warning">
                <h4>⚠️ Importante:</h4>
                <ul>
                    <li>Esta es una contraseña temporal que debes cambiar en tu primer acceso</li>
                    <li>Ingresa al sistema usando tu número de documento como usuario</li>
                    <li>Por seguridad, no compartas estas credenciales</li>
                    <li>Si tienes problemas para acceder, contacta al administrador</li>
                </ul>
            </div>
            
            <p>Puedes acceder al sistema en: <a href="{{ url('/') }}">{{ url('/') }}</a></p>
        </div>
        
        <div class="footer">
            <p>Sistema de Aspersiones Sara Palma<br>
            Este es un correo automático, no responder.</p>
        </div>
    </div>
</body>
</html>