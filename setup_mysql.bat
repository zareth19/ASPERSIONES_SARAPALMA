@echo off
echo Configurando Sistema de Aspersiones Sara Palma con MySQL...
echo.

echo 1. Copiando archivo de configuracion...
copy .env.example .env

echo 2. Generando clave de aplicacion...
php artisan key:generate

echo 3. IMPORTANTE: Crear base de datos 'asperciones_sara_palma' en MySQL
echo    Puedes usar phpMyAdmin o ejecutar:
echo    CREATE DATABASE asperciones_sara_palma;
echo.
pause

echo 4. Ejecutando migraciones...
php artisan migrate

echo 5. Ejecutando seeders...
php artisan db:seed

echo 6. Limpiando cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo.
echo ¡Sistema configurado exitosamente con MySQL!
echo.
echo Datos de acceso inicial:
echo - Crear usuarios administrativos usando el registro web
echo - Fincas: Usuario = IBM, Contraseña = NombreFinca+IBM
echo.
pause