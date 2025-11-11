# 🚀 INSTRUCCIONES - MIGRACIONES UNIFICADAS

## ✅ MIGRACIONES CREADAS (15 archivos)

He creado **15 nuevas migraciones** en tu carpeta `database/migrations/`:

### 📦 Migraciones del Proyecto Electoral:
1. ✅ `2025_11_01_000001_create_asientos_table.php`
2. ✅ `2025_11_01_000002_modify_recintos_for_dual_support.php`
3. ✅ `2025_11_01_000003_rename_mesas_sufragio_to_mesas.php`
4. ✅ `2025_11_01_000004_create_personas_table.php`
5. ✅ `2025_11_01_000005_modify_users_table_for_unification.php`
6. ✅ `2025_11_01_000006_create_admin_users_table.php`
7. ✅ `2025_11_01_000007_create_partidos_table.php`
8. ✅ `2025_11_01_000008_create_instituciones_table.php`
9. ✅ `2025_11_01_000009_create_jurados_table.php`
10. ✅ `2025_11_01_000010_create_veedores_table.php`
11. ✅ `2025_11_01_000011_create_delegados_table.php`
12. ✅ `2025_11_01_000012_create_asistencia_table.php`
13. ✅ `2025_11_01_000013_create_historial_personas_table.php`
14. ✅ `2025_11_01_000014_create_credenciales_table.php`
15. ✅ `2025_11_01_000015_create_capacitaciones_tables.php` (5 tablas de academia)

---

## 🎯 PASO A PASO PARA IMPLEMENTAR

### **PASO 1: Configurar Base de Datos**

```bash
# Crear base de datos
mysql -u root -p
```

```sql
CREATE DATABASE sistema_electoral_votaciones 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;
exit
```

---

### **PASO 2: Configurar .env**

Edita tu archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_electoral_votaciones
DB_USERNAME=root
DB_PASSWORD=tu_password
```

---

### **PASO 3: Ejecutar TODAS las Migraciones**

```bash
# Desde la raíz del proyecto Votaciones
php artisan migrate
```

Este comando ejecutará:
1. ✅ Tus migraciones existentes (departamentos, provincias, municipios, circunscripciones, etc.)
2. ✅ Las 15 nuevas migraciones que creé
3. ✅ Creará la tabla unificada `mesas` (renombrando `mesas_sufragio`)
4. ✅ Modificará `users` para unificación
5. ✅ Creará todas las tablas del Proyecto Electoral

**Salida esperada:**
```
Migrating: 2025_11_01_000001_create_asientos_table
Migrated:  2025_11_01_000001_create_asientos_table (45.23ms)
Migrating: 2025_11_01_000002_modify_recintos_for_dual_support
Migrated:  2025_11_01_000002_modify_recintos_for_dual_support (52.34ms)
...
```

---

### **PASO 4: Verificar Tablas Creadas**

```bash
php artisan tinker
```

```php
// Ver todas las tablas
Schema::getTableListing();

// Verificar tablas específicas
DB::table('personas')->count();      // 0 (nueva tabla)
DB::table('jurados')->count();       // 0 (nueva tabla)
DB::table('mesas')->count();         // Los datos de mesas_sufragio
DB::table('partidos')->count();      // 0 (nueva tabla)
DB::table('capacitaciones')->count(); // 0 (nueva tabla)
```

---

### **PASO 5: Copiar Migraciones al Proyecto Electoral**

```bash
# Desde el proyecto Votaciones, copiar TODAS las migraciones
# (Incluyendo las que ya tenías + las 15 nuevas)

# Windows (PowerShell)
Copy-Item "i:\4Semestre\ProyectoDeSistemas\Elecciones_AyB\ProyectoVotaciones-main\database\migrations\*" `
  -Destination "RUTA_DEL_PROYECTO_ELECTORAL\database\migrations\" -Recurse

# O copia manualmente toda la carpeta migrations/
```

---

### **PASO 6: Configurar .env del Proyecto Electoral**

En el **Proyecto Electoral**, edita `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_electoral_votaciones  # ← MISMA BASE DE DATOS
DB_USERNAME=root
DB_PASSWORD=tu_password
```

---

### **PASO 7: NO Ejecutar Migrate en Proyecto Electoral**

⚠️ **IMPORTANTE:** Como ya ejecutaste `php artisan migrate` en el Proyecto Votaciones, NO lo ejecutes nuevamente en el Proyecto Electoral.

En su lugar, solo sincroniza el estado de migraciones:

```bash
# En el Proyecto Electoral
php artisan migrate:status

# Si dice que faltan migraciones, ejecuta:
php artisan migrate
```

Esto evitará errores de "tabla ya existe".

---

## 🔍 VERIFICACIÓN COMPLETA

### 1. Proyecto Votaciones

```bash
php artisan tinker
```

```php
// Verificar geografía (compartida)
DB::table('departamentos')->count();
DB::table('provincias')->count();
DB::table('municipios')->count();

// Verificar tablas propias
DB::table('elections')->count();
DB::table('candidates')->count();

// Verificar tablas compartidas del Electoral
DB::table('personas')->count();
DB::table('jurados')->count();
```

### 2. Proyecto Electoral

```bash
php artisan tinker
```

```php
// Verificar geografía (compartida)
DB::table('departamentos')->count();  // Mismo resultado que Proyecto Votaciones

// Verificar tablas propias
DB::table('personas')->count();
DB::table('jurados')->count();
DB::table('partidos')->count();
DB::table('credenciales')->count();
```

---

## 📊 ESTRUCTURA FINAL

Después de ejecutar las migraciones, tendrás:

### 🟦 Tablas del Proyecto Votaciones (existentes):
- `elections`, `candidates`, `actas`, `acta_candidate_votes`
- `departamentos`, `provincias`, `municipios`, `circunscripciones`
- `recintos` (modificado para soportar asientos)
- `users` (modificado para unificación)

### 🟩 Tablas del Proyecto Electoral (nuevas):
- `asientos`
- `personas`
- `admin_users`
- `partidos`, `instituciones`
- `jurados`, `veedores`, `delegados`
- `asistencia`, `historial_personas`
- `credenciales`
- `capacitaciones`, `capacitacion_niveles`, `progreso_capacitaciones`
- `quiz_preguntas`, `quiz_respuestas`

### 🟨 Tablas Compartidas/Modificadas:
- `mesas` (unificada, antes `mesas_sufragio`)
- `users` (unificada con campos adicionales)
- `recintos` (soporta circunscripciones + asientos)

### 🟧 Tablas Laravel (existentes):
- `sessions`, `cache`, `jobs`, `password_reset_tokens`

---

## ⚠️ CAMBIOS IMPORTANTES EN TU CÓDIGO

### 1. Renombrar Referencias a `mesas_sufragio`

```php
// ANTES:
use App\Models\MesaSufragio;
$mesa = MesaSufragio::find(1);

// DESPUÉS:
use App\Models\Mesa;
$mesa = Mesa::find(1);
```

### 2. Actualizar Model Mesa

```php
// app/Models/Mesa.php
class Mesa extends Model
{
    protected $table = 'mesas'; // Cambio de 'mesas_sufragio'
    
    protected $fillable = [
        'recinto_id',
        'numero_mesa',        // Antes era 'numero'
        'cantidad_electores',
        'presidente_nombre',
        'secretario_nombre',
        'activa'
    ];
}
```

### 3. Actualizar Referencias en Controladores

```php
// Buscar en todo el proyecto:
// mesas_sufragio → mesas
// mesa_sufragio_id → mesa_id (si aplica)
```

---

## 🚨 SI ALGO SALE MAL

### Rollback de migraciones:

```bash
# Deshacer la última migración
php artisan migrate:rollback

# Deshacer las últimas 15 migraciones
php artisan migrate:rollback --step=15

# Deshacer TODAS las migraciones
php artisan migrate:reset
```

### Recrear desde cero:

```bash
# Borrar todas las tablas y recrear
php artisan migrate:fresh

# Con seeders
php artisan migrate:fresh --seed
```

---

## ✅ CHECKLIST FINAL

- [ ] Base de datos `sistema_electoral_votaciones` creada
- [ ] `.env` configurado en Proyecto Votaciones
- [ ] `php artisan migrate` ejecutado en Proyecto Votaciones
- [ ] Verificado que todas las tablas existen
- [ ] Migraciones copiadas al Proyecto Electoral
- [ ] `.env` configurado en Proyecto Electoral
- [ ] Estado de migraciones sincronizado en Proyecto Electoral
- [ ] Modelo `Mesa` actualizado (renombrar de `MesaSufragio`)
- [ ] Referencias a `mesas_sufragio` actualizadas en código
- [ ] Ambos proyectos apuntan a la misma BD

---

## 🎓 NOTAS IMPORTANTES

1. **Las migraciones se ejecutan en ORDEN alfabético** por el timestamp en el nombre
2. **Rollback deshace en orden inverso** (LIFO - Last In First Out)
3. **La tabla `migrations` registra qué migraciones se ejecutaron**
4. **Ambos proyectos comparten la misma tabla `migrations`**
5. **No ejecutes `migrate:fresh` si ya tienes datos importantes**

---

## 📞 SIGUIENTE PASO

**Ejecuta:**
```bash
php artisan migrate
```

**Y avísame si hay algún error.** 🚀

Cualquier problema que aparezca, lo solucionamos juntos paso a paso.
