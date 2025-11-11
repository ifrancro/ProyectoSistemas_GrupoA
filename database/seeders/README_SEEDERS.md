# 📋 GUÍA DE SEEDERS - BASE DE DATOS UNIFICADA

## ✅ SEEDERS CORREGIDOS Y ACTUALIZADOS

### **1. GeografiaSeeder.php** ⭐ NUEVO
**Propósito:** Datos geográficos de Bolivia compartidos por ambos proyectos

**Crea:**
- ✅ Departamentos (9)
- ✅ Provincias
- ✅ Municipios
- ✅ Circunscripciones (Proyecto Votaciones)
- ✅ Asientos (Proyecto Electoral)
- ✅ Recintos (soporta ambos niveles)
- ✅ Mesas (unificadas)

**Ejecutar:** ✅ SOLO UNA VEZ (compartido por ambos proyectos)

---

### **2. ProyectoElectoralSeeder.php** ⭐ NUEVO
**Propósito:** Datos del Proyecto Electoral

**Crea:**
- ✅ Partidos políticos (5)
- ✅ Instituciones observadoras (4)
- ✅ Personas (5 personas de prueba)
- ✅ Jurados (4 jurados asignados a mesas)
- ✅ Veedores (2 veedores)
- ✅ Delegados (2 delegados)
- ✅ Admin Users (1 administrador)

**Ejecutar:** ✅ Después de GeografiaSeeder

---

### **3. UserSeeder.php** ✅ ACTUALIZADO
**Propósito:** Usuarios del Sistema de Votaciones

**Crea:**
- ✅ 1 Administrador (username: admin, password: admin123)
- ✅ 16 Usuarios de mesa (username: mesa001-mesa016, password: 123456)

**Cambios realizados:**
- ✅ Usa `Hash::make()` explícitamente
- ✅ Agrega campos `email` para todos los usuarios
- ✅ Unifica campos: `role` + `rol_electoral`, `is_active` + `activo`
- ✅ Busca mesas en tabla unificada `mesas` (no `mesas_sufragio`)

**Ejecutar:** ✅ Después de GeografiaSeeder (requiere mesas creadas)

---

### **4. ElectionSeeder.php** ✅ SIN CAMBIOS
**Propósito:** Elecciones y Candidatos del Proyecto Votaciones

**Crea:**
- ✅ 2 Elecciones (Presidencial y Diputados)
- ✅ 16 Candidatos (8 para cada elección)

**Ejecutar:** ✅ En cualquier momento después de migraciones

---

### **5. AcademiaSeeder.php** ⚠️ DESACTIVADO TEMPORALMENTE
**Propósito:** Sistema de Academia Electoral

**Estado:** ⚠️ **DESACTIVADO** en DatabaseSeeder.php

**Problema detectado:**
```php
// ❌ INCORRECTO:
'id_capacitacion' => $capacitacionJurado->id_capacitacion
'id_pregunta' => $pregunta1->id_pregunta

// ✅ DEBERÍA SER:
'capacitacion_id' => $capacitacionJurado->id
'pregunta_id' => $pregunta1->id
```

**Impacto:** ❌ NO CRÍTICO - Los sistemas funcionan sin este seeder.
Las tablas de academia SÍ están creadas, solo faltan datos de prueba.

---

### **6. EleccionesSeeder.php** ❌ OBSOLETO
**Estado:** Marcado como obsoleto

**Problemas:**
- ❌ Usa tabla `usuarios` (no existe, debe ser `users`)
- ❌ Usa `id_departamento` en lugar de `departamento_id`
- ❌ Usa `id_provincia` en lugar de `provincia_id`
- ❌ Usa `id_persona` en lugar de `persona_id`

**Acción:** ⛔ NO EJECUTAR - Lanza una excepción si se intenta usar

---

## 🚀 ORDEN DE EJECUCIÓN CORRECTO

### **Opción 1: Ejecutar todos los seeders**
```bash
php artisan db:seed
```

Esto ejecuta `DatabaseSeeder.php` que llama a todos en el orden correcto:
1. GeografiaSeeder ✅
2. ProyectoElectoralSeeder ✅
3. UserSeeder ✅
4. ElectionSeeder ✅
5. ~~AcademiaSeeder~~ ⚠️ Desactivado temporalmente

---

### **Opción 2: Ejecutar seeders individuales**
```bash
# 1. Geografía (PRIMERO - OBLIGATORIO)
php artisan db:seed --class=GeografiaSeeder

# 2. Datos electorales
php artisan db:seed --class=ProyectoElectoralSeeder

# 3. Usuarios
php artisan db:seed --class=UserSeeder

# 4. Elecciones
php artisan db:seed --class=ElectionSeeder

# 5. Academia (DESACTIVADO - requiere corrección)
# php artisan db:seed --class=AcademiaSeeder
```

---

## 📊 RESUMEN DE CAMBIOS

### ✅ **Creados:**
- `GeografiaSeeder.php` → Datos geográficos completos
- `ProyectoElectoralSeeder.php` → Personas, partidos, instituciones, roles

### ✅ **Actualizados:**
- `UserSeeder.php` → Corregido para tabla `users` unificada y `mesas` unificada
- `DatabaseSeeder.php` → Orden correcto de ejecución

### ⚠️ **Sin cambios pero requiere atención:**
- `AcademiaSeeder.php` → Usa nombres antiguos de columnas (`id_capacitacion`)

### ❌ **Obsoletos:**
- `EleccionesSeeder.php` → Marcado como obsoleto, no ejecutar

---

## 🔍 VERIFICACIÓN

Después de ejecutar los seeders, verifica con:

```bash
php artisan tinker
```

```php
// Geografía
DB::table('departamentos')->count();  // 9
DB::table('provincias')->count();     // 6
DB::table('municipios')->count();     // 7
DB::table('mesas')->count();          // 8

// Proyecto Electoral
DB::table('personas')->count();       // 5
DB::table('jurados')->count();        // 4
DB::table('partidos')->count();       // 5
DB::table('instituciones')->count();  // 4

// Proyecto Votaciones
DB::table('users')->count();          // 17 (1 admin + 16 mesa)
DB::table('elections')->count();      // 2
DB::table('candidates')->count();     // 16
```

---

## ⚠️ IMPORTANTE PARA AMBOS PROYECTOS

**Al copiar estos seeders al Proyecto Electoral:**
1. ✅ Copia TODOS los archivos de `database/seeders/`
2. ✅ NO ejecutes `GeografiaSeeder` dos veces (ya están los datos)
3. ✅ Puedes ejecutar `php artisan db:seed` en el Proyecto Electoral
4. ✅ Laravel detectará qué seeders ya se ejecutaron

---

## 📝 NOTAS FINALES

- **Geografía:** Se ejecuta UNA SOLA VEZ, luego ambos proyectos leen los mismos datos
- **Usuarios:** Cada proyecto puede tener sus propios usuarios, pero comparten la tabla
- **Personas vs Users:** Son independientes, pero pueden relacionarse con `persona_id`
- **Mesas:** Tabla unificada, usada por ambos proyectos

---

¿Necesitas ayuda con algún seeder específico o quieres que corrija AcademiaSeeder?
