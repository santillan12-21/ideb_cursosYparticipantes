@echo off
:: Iniciar XAMPP (Apache y MySQL)
echo Iniciando XAMPP...
"C:\xampp\xampp_start.exe"

:: Esperar unos segundos para asegurarse de que los servicios estén listos
echo Esperando a que los servicios de XAMPP inicien...
timeout /t 10 >nul

:: Verificar si Apache y MySQL están funcionando
tasklist | findstr mysqld >nul
if errorlevel 1 (
    echo Error: MySQL no se pudo iniciar. Por favor, verifica el Panel de Control de XAMPP.
    pause
    exit /b
)

tasklist | findstr httpd >nul
if errorlevel 1 (
    echo Error: Apache no se pudo iniciar. Por favor, verifica el Panel de Control de XAMPP.
    pause
    exit /b
)

:: Iniciar el servidor de Laravel
echo Iniciando servidor de Laravel...
start cmd /k "php artisan serve"

:: Iniciar el servidor de desarrollo de Node.js
echo Iniciando servidor de Node.js...
start cmd /k "npm run dev"

echo Proyecto iniciado correctamente.
pause
