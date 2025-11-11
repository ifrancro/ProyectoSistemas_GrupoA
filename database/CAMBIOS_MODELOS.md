# 🔧 CAMBIOS NECESARIOS EN MODELOS ELOQUENT

## 📋 IMPORTANTE: Cambios de Nombres de Tablas

### Proyecto Electoral - Cambios Críticos

El schema unificado usa nombres **SIMPLIFICADOS** para mantener compatibilidad con Laravel:

| ❌ Nombre Antiguo (Proyecto Electoral) | ✅ Nombre Nuevo (Unificado) | Cambio Requerido |
|-----------------------------------|------------------------|------------------|
| `id_departamento` | `id` | PRIMARY KEY |
| `id_provincia` | `id` | PRIMARY KEY |
| `id_municipio` | `id` | PRIMARY KEY |
| `id_persona` | `id` | PRIMARY KEY |
| `id_mesa` | `id` | PRIMARY KEY |
| `id_jurado` | `id` | PRIMARY KEY |
| **TABLA:** `circunscripcions` | `circunscripciones` | Nombre corregido |
| **TABLA:** N/A | `mesas` | Reemplaza `mesas_sufragio` + `mesas` |

---

## 🔄 PROYECTO ELECTORAL - ACTUALIZAR MODELOS

### 1. Model: Departamento
```php
<?php
// app/Models/Departamento.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';
    protected $primaryKey = 'id'; // CAMBIO: era 'id_departamento'
    public $timestamps = false;
    
    protected $fillable = ['nombre', 'codigo', 'activo'];
    
    public function provincias() {
        return $this->hasMany(Provincia::class, 'departamento_id');
    }
}
```

### 2. Model: Provincia
```php
<?php
// app/Models/Provincia.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincias';
    protected $primaryKey = 'id'; // CAMBIO: era 'id_provincia'
    public $timestamps = false;
    
    protected $fillable = ['nombre', 'codigo', 'activo', 'departamento_id'];
    
    public function departamento() {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
    
    public function municipios() {
        return $this->hasMany(Municipio::class, 'provincia_id');
    }
}
```

### 3. Model: Municipio
```php
<?php
// app/Models/Municipio.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipios';
    protected $primaryKey = 'id'; // CAMBIO: era 'id_municipio'
    public $timestamps = false;
    
    protected $fillable = ['nombre', 'codigo', 'activo', 'provincia_id'];
    
    public function provincia() {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }
    
    public function asientos() {
        return $this->hasMany(Asiento::class, 'municipio_id');
    }
}
```

### 4. Model: Asiento
```php
<?php
// app/Models/Asiento.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    protected $table = 'asientos';
    protected $primaryKey = 'id'; // CAMBIO: era 'id_asiento'
    public $timestamps = false;
    
    protected $fillable = ['nombre', 'municipio_id'];
    
    public function municipio() {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }
    
    public function recintos() {
        return $this->hasMany(Recinto::class, 'asiento_id');
    }
}
```

### 5. Model: Recinto
```php
<?php
// app/Models/Recinto.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Recinto extends Model
{
    protected $table = 'recintos';
    protected $primaryKey = 'id'; // CAMBIO: era 'id_recinto'
    public $timestamps = false;
    
    protected $fillable = [
        'nombre', 'direccion', 'codigo', 'activo',
        'asiento_id',           // Para Proyecto Electoral
        'circunscripcion_id'    // Para Proyecto Votaciones
    ];
    
    // Relación con Asiento (Proyecto Electoral)
    public function asiento() {
        return $this->belongsTo(Asiento::class, 'asiento_id');
    }
    
    // Relación con Circunscripción (Proyecto Votaciones)
    public function circunscripcion() {
        return $this->belongsTo(Circunscripcion::class, 'circunscripcion_id');
    }
    
    public function mesas() {
        return $this->hasMany(Mesa::class, 'recinto_id');
    }
}
```

### 6. Model: Mesa (UNIFICADA)
```php
<?php
// app/Models/Mesa.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $table = 'mesas';
    protected $primaryKey = 'id'; // CAMBIO: era 'id_mesa'
    public $timestamps = false;
    
    protected $fillable = [
        'recinto_id',
        'numero_mesa',
        'cantidad_electores',
        'presidente_nombre',
        'secretario_nombre',
        'activa'
    ];
    
    public function recinto() {
        return $this->belongsTo(Recinto::class, 'recinto_id');
    }
    
    public function jurados() {
        return $this->hasMany(Jurado::class, 'mesa_id');
    }
    
    public function delegados() {
        return $this->hasMany(Delegado::class, 'mesa_id');
    }
}
```

### 7. Model: Persona
```php
<?php
// app/Models/Persona.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id'; // CAMBIO: era 'id_persona'
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;
    
    protected $fillable = [
        'ci', 'nombre', 'apellido', 'fecha_nacimiento',
        'correo', 'telefono', 'ciudad', 'estado', 'foto_carnet'
    ];
    
    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];
    
    // NUEVA RELACIÓN con Users
    public function user() {
        return $this->hasOne(User::class, 'persona_id');
    }
    
    public function jurado() {
        return $this->hasOne(Jurado::class, 'persona_id');
    }
    
    public function veedor() {
        return $this->hasOne(Veedor::class, 'persona_id');
    }
    
    public function delegado() {
        return $this->hasOne(Delegado::class, 'persona_id');
    }
    
    public function credenciales() {
        return $this->hasMany(Credencial::class, 'persona_id');
    }
}
```

### 8. Model: Jurado
```php
<?php
// app/Models/Jurado.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Jurado extends Model
{
    protected $table = 'jurados';
    protected $primaryKey = 'id'; // CAMBIO: era 'id_jurado'
    public $timestamps = false;
    
    protected $fillable = [
        'persona_id',  // CAMBIO: era 'id_persona'
        'mesa_id',     // CAMBIO: era 'id_mesa'
        'cargo',
        'verificado'
    ];
    
    public function persona() {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    
    public function mesa() {
        return $this->belongsTo(Mesa::class, 'mesa_id');
    }
}
```

### 9. Model: Veedor
```php
<?php
// app/Models/Veedor.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Veedor extends Model
{
    protected $table = 'veedores';
    protected $primaryKey = 'id'; // CAMBIO: era 'id_veedor'
    public $timestamps = false;
    
    protected $fillable = [
        'persona_id',       // CAMBIO: era 'id_persona'
        'institucion_id',   // CAMBIO: era 'id_institucion'
        'carta_respaldo',
        'estado',
        'motivo_rechazo'
    ];
    
    public function persona() {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    
    public function institucion() {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }
}
```

### 10. Model: Delegado
```php
<?php
// app/Models/Delegado.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Delegado extends Model
{
    protected $table = 'delegados';
    protected $primaryKey = 'id'; // CAMBIO: era 'id_delegado'
    public $timestamps = false;
    
    protected $fillable = [
        'persona_id',   // CAMBIO: era 'id_persona'
        'partido_id',   // CAMBIO: era 'id_partido'
        'mesa_id',      // CAMBIO: era 'id_mesa'
        'habilitado'
    ];
    
    public function persona() {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    
    public function partido() {
        return $this->belongsTo(Partido::class, 'partido_id');
    }
    
    public function mesa() {
        return $this->belongsTo(Mesa::class, 'mesa_id');
    }
}
```

---

## 🔄 PROYECTO VOTACIONES - AJUSTES MENORES

### 1. Model: Circunscripcion
```php
<?php
// app/Models/Circunscripcion.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Circunscripcion extends Model
{
    protected $table = 'circunscripciones'; // CAMBIO: era 'circunscripcions'
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'municipio_id', 'nombre', 'codigo', 
        'numero_electores', 'activo'
    ];
    
    public function municipio() {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }
    
    public function recintos() {
        return $this->hasMany(Recinto::class, 'circunscripcion_id');
    }
}
```

### 2. Model: User (UNIFICADO)
```php
<?php
// app/Models/User.php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password',
        'username', 'mesa_number', 'role', 'is_active',
        'mesa_id', 'circunscripcion_id',
        'rol_electoral', 'cargo', 'activo',
        'persona_id'  // NUEVA relación
    ];
    
    protected $hidden = ['password', 'remember_token'];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'activo' => 'boolean',
    ];
    
    // NUEVA RELACIÓN con Personas (Proyecto Electoral)
    public function persona() {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    
    // Relaciones existentes (Proyecto Votaciones)
    public function actas() {
        return $this->hasMany(Acta::class, 'user_id');
    }
}
```

---

## 🛠️ COMANDO PARA ACTUALIZAR MODELOS

### Opción 1: Buscar y Reemplazar en Todo el Proyecto Electoral

```bash
# En el directorio del proyecto electoral
# Buscar todas las referencias a 'id_departamento' y reemplazar por 'id'
grep -r "id_departamento" app/
grep -r "id_provincia" app/
grep -r "id_municipio" app/
grep -r "id_persona" app/
grep -r "id_mesa" app/
```

### Opción 2: Script de Migración (PHP)
```php
<?php
// database/scripts/migrate_model_references.php

// Actualizar referencias en controladores
$patterns = [
    'id_departamento' => 'id',
    'id_provincia' => 'id',
    'id_municipio' => 'id',
    'id_asiento' => 'id',
    'id_recinto' => 'id',
    'id_mesa' => 'id',
    'id_persona' => 'id',
    'id_jurado' => 'id',
    'id_veedor' => 'id',
    'id_delegado' => 'id',
    'id_partido' => 'id',
    'id_institucion' => 'id',
];

// NOTA: Este es solo un ejemplo, revisar manualmente cada cambio
```

---

## ⚠️ CAMBIOS EN CONTROLADORES

### Ejemplo: SorteoJuradosService
```php
// ANTES:
$mesa = Mesa::where('id_mesa', $mesaId)->first();
$jurado = new Jurado();
$jurado->id_persona = $persona->id_persona;
$jurado->id_mesa = $mesa->id_mesa;

// DESPUÉS:
$mesa = Mesa::where('id', $mesaId)->first();
$jurado = new Jurado();
$jurado->persona_id = $persona->id;
$jurado->mesa_id = $mesa->id;
```

---

## 📋 CHECKLIST DE ACTUALIZACIÓN

- [ ] Actualizar todos los modelos con `protected $primaryKey = 'id'`
- [ ] Cambiar `id_campo` por `campo_id` en fillables
- [ ] Actualizar relaciones Eloquent
- [ ] Buscar y reemplazar referencias en controladores
- [ ] Actualizar servicios (SorteoJuradosService, CredencialService)
- [ ] Revisar queries directas en Blade
- [ ] Actualizar seeders
- [ ] Probar migraciones

---

¿Necesitas ayuda con algún modelo o controlador específico?
