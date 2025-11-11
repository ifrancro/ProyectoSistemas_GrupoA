@echo off
REM ========================================
REM SCRIPT DE IMPLEMENTACIÓN RÁPIDA - WINDOWS
REM Base de Datos Unificada
REM ========================================

echo ==================================================
echo   IMPLEMENTACIÓN BASE DE DATOS UNIFICADA
echo ==================================================
echo.

REM ========================================
REM VERIFICAR MYSQL
REM ========================================
echo [Verificando MySQL...]
mysql --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: MySQL no está instalado o no está en PATH
    echo Por favor instala MySQL o agrega mysql.exe al PATH
    pause
    exit /b 1
)
echo ✓ MySQL encontrado
echo.

REM ========================================
REM PASO 1: CREAR BASE DE DATOS
REM ========================================
echo [1/9] Creando base de datos...
echo.
echo Ingresa tu password de MySQL:

mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS sistema_electoral_votaciones CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; SHOW DATABASES LIKE 'sistema_electoral_votaciones';"

if %errorlevel% neq 0 (
    echo ERROR: No se pudo crear la base de datos
    pause
    exit /b 1
)

echo ✓ Base de datos creada
echo.

REM ========================================
REM PASO 2: EJECUTAR SCHEMA
REM ========================================
echo [2/9] Ejecutando schema unificado...
echo Este proceso puede tomar unos segundos...
echo.

mysql -u root -p sistema_electoral_votaciones < database\schema_unificado.sql

if %errorlevel% neq 0 (
    echo ERROR: No se pudo ejecutar el schema
    pause
    exit /b 1
)

echo ✓ Schema ejecutado correctamente
echo.

REM ========================================
REM PASO 3: VERIFICAR TABLAS
REM ========================================
echo [3/9] Verificando tablas creadas...
echo.

mysql -u root -p sistema_electoral_votaciones -e "SHOW TABLES;"

echo.
echo ✓ Tablas verificadas
echo.

REM ========================================
REM PASO 4: CONFIGURAR .ENV
REM ========================================
echo [4/9] Configurando archivo .env...
echo.

if exist .env (
    echo Ya existe un archivo .env
    echo ¿Deseas crear un backup? (S/N)
    set /p backup=
    if /i "%backup%"=="S" (
        copy .env .env.backup.%date:~-4,4%%date:~-7,2%%date:~-10,2%
        echo ✓ Backup creado: .env.backup
    )
)

REM Actualizar solo la sección de base de datos
echo.
echo Actualiza manualmente tu archivo .env con estos valores:
echo.
echo DB_CONNECTION=mysql
echo DB_HOST=127.0.0.1
echo DB_PORT=3306
echo DB_DATABASE=sistema_electoral_votaciones
echo DB_USERNAME=root
echo DB_PASSWORD=tu_password_aqui
echo.
pause

REM ========================================
REM PASO 5: GENERAR APP_KEY
REM ========================================
echo.
echo [5/9] Generando APP_KEY...
php artisan key:generate

if %errorlevel% neq 0 (
    echo ERROR: No se pudo generar APP_KEY
    echo Asegúrate de estar en el directorio raíz del proyecto Laravel
    pause
    exit /b 1
)

echo ✓ APP_KEY generado
echo.

REM ========================================
REM PASO 6: LIMPIAR CACHE
REM ========================================
echo [6/9] Limpiando cache de Laravel...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo ✓ Cache limpiado
echo.

REM ========================================
REM PASO 7: CREAR SYMLINK
REM ========================================
echo [7/9] Creando symlink de storage...
php artisan storage:link

echo ✓ Symlink creado
echo.

REM ========================================
REM PASO 8: VERIFICAR CONEXIÓN
REM ========================================
echo [8/9] Verificando conexión a la base de datos...
php artisan tinker --execute="echo 'DB: ' . DB::connection()->getDatabaseName(); echo PHP_EOL;"

if %errorlevel% neq 0 (
    echo.
    echo ERROR: No se pudo conectar a la base de datos
    echo Verifica tu archivo .env
    pause
    exit /b 1
)

echo ✓ Conexión exitosa
echo.

REM ========================================
REM PASO 9: SEEDERS (OPCIONAL)
REM ========================================
echo [9/9] ¿Deseas ejecutar los seeders de prueba? (S/N)
set /p ejecutar_seeders=

if /i "%ejecutar_seeders%"=="S" (
    echo.
    echo Ejecutando seeders...
    
    REM Seeders básicos
    php artisan db:seed --class=UserSeeder
    php artisan db:seed --class=ElectionSeeder
    
    echo ✓ Seeders ejecutados
) else (
    echo ⏭  Seeders omitidos
)

echo.

REM ========================================
REM RESUMEN
REM ========================================
echo.
echo ==================================================
echo   ✓ IMPLEMENTACIÓN COMPLETADA
echo ==================================================
echo.
echo 📊 Base de datos: sistema_electoral_votaciones
echo 🔗 Conexión: Configurada en .env
echo 📁 Storage: Symlink creado
echo.
echo 🚀 PRÓXIMOS PASOS:
echo.
echo 1. Lee el archivo GUIA_IMPLEMENTACION.md
echo.
echo 2. Actualiza los modelos según CAMBIOS_MODELOS.md
echo.
echo 3. Ejecuta el servidor:
echo    php artisan serve
echo.
echo 4. Abre en el navegador:
echo    http://localhost:8000
echo.
echo ==================================================
echo.
echo 📋 COMANDOS ÚTILES:
echo.
echo Ver tablas:
echo   mysql -u root -p sistema_electoral_votaciones -e "SHOW TABLES;"
echo.
echo Ver estructura de tabla:
echo   mysql -u root -p sistema_electoral_votaciones -e "DESCRIBE users;"
echo.
echo Backup:
echo   mysqldump -u root -p sistema_electoral_votaciones ^> backup.sql
echo.
echo ==================================================
echo.
pause
