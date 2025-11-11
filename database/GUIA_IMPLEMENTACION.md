# 📘 GUÍA DE IMPLEMENTACIÓN - BASE DE DATOS UNIFICADA

## 🎯 Objetivo
Unificar las bases de datos de **Sistema de Votaciones** y **Sistema Electoral** en una sola base de datos compartida.

---

## 📋 PASO 1: PREPARACIÓN

### 1.1 Backup de Bases de Datos Actuales
```bash
# Si ya tienes bases de datos, haz backup primero
mysqldump -u root -p votaciones_db > backup_votaciones.sql
mysqldump -u root -p electoral_db > backup_electoral.sql
```

### 1.2 Crear Nueva Base de Datos Unificada
```sql
CREATE DATABASE sistema_electoral_votaciones 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE sistema_electoral_votaciones;
```

---

## 📊 PASO 2: EJECUTAR SCHEMA UNIFICADO

### 2.1 Estructura del Schema Unificado

El schema unificado contiene:
- ✅ **Tablas Laravel**: sessions, cache, jobs (compartidas)
- ✅ **Jerarquía Geográfica Unificada**: departamentos → provincias → municipios
- ✅ **Dos niveles intermedios**: circunscripciones (Proyecto 1) + asientos (Proyecto 2)
- ✅ **Mesas Unificadas**: campos de ambos proyectos
- ✅ **Usuarios Unificados**: tabla `users` con todos los campos
- ✅ **Tablas Específicas**: 
  - Proyecto 1: elections, candidates, actas, acta_candidate_votes
  - Proyecto 2: personas, jurados, veedores, delegados, partidos, instituciones, credenciales, academia

### 2.2 Ejecutar el Schema
```bash
# Desde la terminal en la raíz del proyecto
mysql -u root -p sistema_electoral_votaciones < database/schema_unificado.sql
```

O desde MySQL Workbench:
1. Abrir el archivo `schema_unificado.sql`
2. Seleccionar la base de datos `sistema_electoral_votaciones`
3. Ejecutar todo el script

---

## ⚙️ PASO 3: CONFIGURAR PROYECTOS LARAVEL

### 3.1 Proyecto de Votaciones (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_electoral_votaciones
DB_USERNAME=root
DB_PASSWORD=tu_password
```

### 3.2 Proyecto Electoral (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_electoral_votaciones  # <- MISMA BASE DE DATOS
DB_USERNAME=root
DB_PASSWORD=tu_password
```

---

## 🔧 PASO 4: AJUSTAR MODELOS ELOQUENT

### 4.1 Proyecto de Votaciones - Ajustes Necesarios

**PROBLEMA**: Los modelos actuales usan nombres de columnas diferentes

**SOLUCIÓN**: Crear mapeos en los modelos

#### Ejemplo: Model Departamento
```php
// app/Models/Departamento.php
protected $table = 'departamentos';
protected $primaryKey = 'id';  // Unificado como 'id'
```

#### Ejemplo: Model Provincia
```php
// app/Models/Provincia.php
protected $table = 'provincias';
protected $primaryKey = 'id';

public function departamento() {
    return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
}
```

### 4.2 Proyecto Electoral - Ajustes Necesarios

**CAMBIO CRÍTICO**: Las tablas ahora usan `id` en lugar de `id_departamento`, `id_provincia`, etc.

#### Crear archivo de configuración
```php
// config/database_mapping.php
return [
    'use_legacy_ids' => false, // Usar nuevos IDs unificados
    'tables' => [
        'departamentos' => ['pk' => 'id', 'legacy_pk' => 'id_departamento'],
        'provincias' => ['pk' => 'id', 'legacy_pk' => 'id_provincia'],
        // ...
    ]
];
```

#### Actualizar Modelos
```php
// app/Models/Departamento.php
protected $table = 'departamentos';
protected $primaryKey = 'id';  // Cambio de id_departamento a id
```

---

## 🗺️ PASO 5: RESOLVER JERARQUÍA GEOGRÁFICA

### 5.1 Estructura Unificada
```
departamentos (id, nombre, codigo, activo)
    └── provincias (id, departamento_id, nombre, codigo, activo)
        └── municipios (id, provincia_id, nombre, codigo, activo)
            ├── circunscripciones (id, municipio_id, nombre, codigo, activo)  # Para Proyecto 1
            │   └── recintos (id, circunscripcion_id, nombre, direccion, codigo)
            │       └── mesas_sufragio (id, recinto_id, numero_mesa, ...)
            │
            └── asientos (id, municipio_id, nombre)  # Para Proyecto 2
                └── recintos (id, asiento_id, nombre, direccion)  # Opcional
                    └── mesas (id, recinto_id, numero)
```

### 5.2 Tabla `recintos` Flexible
```sql
-- La tabla recintos soporta AMBOS niveles
CREATE TABLE `recintos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `circunscripcion_id` BIGINT UNSIGNED NULL,  -- Para Proyecto 1
  `asiento_id` BIGINT UNSIGNED NULL,          -- Para Proyecto 2
  `nombre` VARCHAR(150) NOT NULL,
  `direccion` TEXT,
  `codigo` VARCHAR(10) UNIQUE,
  `activo` TINYINT(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  -- Al menos UNO debe estar presente
  CONSTRAINT `check_recinto_parent` CHECK (
    `circunscripcion_id` IS NOT NULL OR `asiento_id` IS NOT NULL
  )
);
```

---

## 👥 PASO 6: UNIFICAR USUARIOS

### 6.1 Tabla `users` Unificada
```sql
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  -- Campos Laravel estándar
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  
  -- Campos Proyecto Votaciones
  `username` VARCHAR(50) UNIQUE,
  `mesa_number` INT NULL,
  `role` ENUM('admin', 'user') DEFAULT 'user',
  `is_active` TINYINT(1) DEFAULT 1,
  `mesa_id` BIGINT UNSIGNED NULL,
  `circunscripcion_id` BIGINT UNSIGNED NULL,
  
  -- Campos Proyecto Electoral
  `rol_electoral` VARCHAR(50) NULL,  -- ADMIN, VOLUNTARIO
  `cargo` VARCHAR(100) NULL,
  `activo` TINYINT(1) DEFAULT 1,
  
  -- Relación con personas (Proyecto Electoral)
  `persona_id` BIGINT UNSIGNED NULL,
  
  `remember_token` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_persona` FOREIGN KEY (`persona_id`) 
    REFERENCES `personas` (`id`) ON DELETE SET NULL
);
```

### 6.2 Migración de Datos de Usuarios

Si ya tienes usuarios en ambas bases de datos:

```sql
-- Migrar usuarios del Proyecto Electoral
INSERT INTO users (name, username, password, rol_electoral, activo, created_at)
SELECT 
  username as name,
  username,
  password_hash,
  rol,
  1,
  creado_en
FROM usuarios_old;  -- Tu tabla antigua

-- Migrar admin_users
INSERT INTO users (name, email, username, password, role, activo, created_at)
SELECT 
  username,
  email,
  username,
  password,
  'admin',
  activo,
  created_at
FROM admin_users_old;
```

---

## 🔗 PASO 7: CREAR RELACIONES CRUZADAS

### 7.1 Personas ↔ Users (Opcional pero Recomendado)

```php
// app/Models/Persona.php
public function user() {
    return $this->hasOne(User::class, 'persona_id');
}

// app/Models/User.php
public function persona() {
    return $this->belongsTo(Persona::class, 'persona_id');
}
```

### 7.2 Jurados ↔ Actas

```php
// app/Models/Jurado.php
public function persona() {
    return $this->belongsTo(Persona::class, 'id_persona');
}

public function mesa() {
    return $this->belongsTo(Mesa::class, 'id_mesa');
}

// Si un jurado también es usuario del sistema de votaciones
public function actasDigitadas() {
    $persona = $this->persona;
    if ($persona && $persona->user) {
        return $persona->user->actas();
    }
    return null;
}
```

---

## 📝 PASO 8: EJECUTAR SEEDERS

### 8.1 Datos Geográficos (Ejecutar SOLO UNA VEZ)

```bash
# Proyecto de Votaciones
php artisan db:seed --class=GeografiaSeeder

# O Proyecto Electoral
php artisan db:seed --class=DepartamentosSeeder
```

### 8.2 Datos de Prueba

```bash
# Proyecto Votaciones
php artisan db:seed --class=ElectionSeeder
php artisan db:seed --class=UserSeeder

# Proyecto Electoral
php artisan db:seed --class=PersonasSeeder
php artisan db:seed --class=PartidosSeeder
```

---

## ✅ PASO 9: VERIFICACIÓN

### 9.1 Verificar Estructura
```sql
-- Ver todas las tablas
SHOW TABLES;

-- Verificar relaciones
SELECT 
  TABLE_NAME,
  CONSTRAINT_NAME,
  REFERENCED_TABLE_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'sistema_electoral_votaciones'
  AND REFERENCED_TABLE_NAME IS NOT NULL;
```

### 9.2 Probar Conexiones

**Proyecto Votaciones:**
```bash
php artisan tinker
>>> \DB::table('departamentos')->count();
>>> User::first();
```

**Proyecto Electoral:**
```bash
php artisan tinker
>>> \DB::table('personas')->count();
>>> Persona::first();
```

---

## 🚨 PROBLEMAS COMUNES Y SOLUCIONES

### Error: "Table doesn't exist"
```bash
# Verificar que ejecutaste el schema
mysql -u root -p -e "USE sistema_electoral_votaciones; SHOW TABLES;"
```

### Error: "Unknown column 'id_departamento'"
```php
// Actualizar el modelo para usar 'id' en lugar de 'id_departamento'
protected $primaryKey = 'id';
```

### Error: "SQLSTATE[23000]: Integrity constraint violation"
```sql
-- Verificar que las FKs están correctas
SET FOREIGN_KEY_CHECKS = 0;
-- Hacer cambios necesarios
SET FOREIGN_KEY_CHECKS = 1;
```

---

## 📚 PRÓXIMOS PASOS

1. ✅ Ejecutar schema unificado
2. ✅ Configurar `.env` en ambos proyectos
3. ✅ Ajustar modelos Eloquent
4. ✅ Ejecutar seeders de datos geográficos
5. ✅ Migrar usuarios existentes (si aplica)
6. ✅ Probar funcionalidades de ambos sistemas
7. ✅ Crear relaciones cruzadas si es necesario

---

## 🎓 NOTAS IMPORTANTES

1. **Ambos proyectos comparten la misma BD** pero mantienen su independencia funcional
2. **Los datos geográficos se comparten** (departamentos → mesas)
3. **Los usuarios se pueden unificar** mediante `persona_id`
4. **Las migraciones futuras** deben ejecutarse con cuidado para no romper el otro proyecto
5. **Backup regular** es crítico durante la integración

---

¿Tienes dudas sobre algún paso específico?
