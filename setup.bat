@echo off
echo Configurando Sistema de Aspersiones Sara Palma...
echo.

echo 1. Copiando archivo de configuracion...
copy .env.example .env

echo 2. Generando clave de aplicacion...
php artisan key:generate

echo 3. Ejecutando migraciones...
php artisan migrate

echo 4. Ejecutando seeders...
php artisan db:seed

echo 5. Limpiando cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo.
echo ¡Sistema configurado exitosamente!
echo.
echo Datos de acceso inicial:
echo - Para crear usuarios administrativos, usar el registro web
echo - Las fincas pueden usar: Usuario: IBM, Contraseña: NombreFinca+IBM
echo.
pause