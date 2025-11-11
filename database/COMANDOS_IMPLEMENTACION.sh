#!/bin/bash

# ========================================
# SCRIPT DE IMPLEMENTACIÓN RÁPIDA
# Base de Datos Unificada
# ========================================

echo "=================================================="
echo "  IMPLEMENTACIÓN BASE DE DATOS UNIFICADA"
echo "=================================================="

# ========================================
# PASO 1: CREAR BASE DE DATOS
# ========================================
echo ""
echo "[1/10] Creando base de datos..."

mysql -u root -p << EOF
CREATE DATABASE IF NOT EXISTS sistema_electoral_votaciones 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

SHOW DATABASES LIKE 'sistema_electoral_votaciones';
EOF

# ========================================
# PASO 2: EJECUTAR SCHEMA UNIFICADO
# ========================================
echo ""
echo "[2/10] Ejecutando schema unificado..."

mysql -u root -p sistema_electoral_votaciones < database/schema_unificado.sql

echo "✅ Schema ejecutado correctamente"

# ========================================
# PASO 3: VERIFICAR TABLAS
# ========================================
echo ""
echo "[3/10] Verificando tablas creadas..."

mysql -u root -p sistema_electoral_votaciones -e "SHOW TABLES;"

# ========================================
# PASO 4: CONFIGURAR .ENV PROYECTO VOTACIONES
# ========================================
echo ""
echo "[4/10] Configurando .env del Proyecto Votaciones..."

cat > .env << 'EOF'
APP_NAME="Sistema de Votaciones"
APP_ENV=local
APP_KEY=base64:your_key_here
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_electoral_votaciones
DB_USERNAME=root
DB_PASSWORD=

# Resto de configuración...
EOF

echo "✅ .env configurado"

# ========================================
# PASO 5: GENERAR APP_KEY
# ========================================
echo ""
echo "[5/10] Generando APP_KEY..."

php artisan key:generate

# ========================================
# PASO 6: LIMPIAR CACHE
# ========================================
echo ""
echo "[6/10] Limpiando cache de Laravel..."

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# ========================================
# PASO 7: CREAR SYMLINK DE STORAGE
# ========================================
echo ""
echo "[7/10] Creando symlink de storage..."

php artisan storage:link

# ========================================
# PASO 8: VERIFICAR CONEXIÓN
# ========================================
echo ""
echo "[8/10] Verificando conexión a la base de datos..."

php artisan tinker --execute="echo DB::connection()->getDatabaseName(); echo PHP_EOL;"

# ========================================
# PASO 9: EJECUTAR SEEDERS (OPCIONAL)
# ========================================
echo ""
echo "[9/10] ¿Deseas ejecutar los seeders? (s/n)"
read -r ejecutar_seeders

if [ "$ejecutar_seeders" = "s" ]; then
    echo "Ejecutando seeders..."
    
    # Seeders de datos geográficos (ejecutar solo una vez)
    php artisan db:seed --class=DepartamentosSeeder
    
    # Seeders de prueba
    php artisan db:seed --class=UserSeeder
    php artisan db:seed --class=ElectionSeeder
    
    echo "✅ Seeders ejecutados"
else
    echo "⏭️  Seeders omitidos"
fi

# ========================================
# PASO 10: RESUMEN
# ========================================
echo ""
echo "=================================================="
echo "  ✅ IMPLEMENTACIÓN COMPLETADA"
echo "=================================================="
echo ""
echo "📊 Base de datos: sistema_electoral_votaciones"
echo "🔗 Conexión: Configurada en .env"
echo "📁 Storage: Symlink creado"
echo ""
echo "🚀 PRÓXIMOS PASOS:"
echo ""
echo "1. Verificar que todas las tablas existen:"
echo "   mysql -u root -p sistema_electoral_votaciones -e 'SHOW TABLES;'"
echo ""
echo "2. Actualizar modelos Eloquent según CAMBIOS_MODELOS.md"
echo ""
echo "3. Ejecutar el servidor:"
echo "   php artisan serve"
echo ""
echo "4. Probar la aplicación:"
echo "   http://localhost:8000"
echo ""
echo "=================================================="

# ========================================
# COMANDOS ÚTILES
# ========================================
echo ""
echo "📋 COMANDOS ÚTILES:"
echo ""
echo "Ver estructura de una tabla:"
echo "  mysql -u root -p sistema_electoral_votaciones -e 'DESCRIBE departamentos;'"
echo ""
echo "Contar registros:"
echo "  mysql -u root -p sistema_electoral_votaciones -e 'SELECT COUNT(*) FROM users;'"
echo ""
echo "Entrar a MySQL:"
echo "  mysql -u root -p sistema_electoral_votaciones"
echo ""
echo "Backup de la base de datos:"
echo "  mysqldump -u root -p sistema_electoral_votaciones > backup_$(date +%Y%m%d).sql"
echo ""
echo "=================================================="
