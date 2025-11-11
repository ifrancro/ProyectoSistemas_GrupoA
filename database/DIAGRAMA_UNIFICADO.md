# 🗺️ DIAGRAMA DE BASE DE DATOS UNIFICADA

## 📊 ESTRUCTURA COMPLETA

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    SISTEMA ELECTORAL + VOTACIONES                       │
│                         Base de Datos Unificada                         │
└─────────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────────┐
│                      1. JERARQUÍA GEOGRÁFICA                            │
└─────────────────────────────────────────────────────────────────────────┘

departamentos (id, nombre, codigo, activo)
    │
    └── provincias (id, departamento_id, nombre, codigo, activo)
            │
            └── municipios (id, provincia_id, nombre, codigo, activo)
                    │
                    ├──> circunscripciones (Proyecto Votaciones)
                    │    └── recintos
                    │         └── mesas
                    │
                    └──> asientos (Proyecto Electoral)
                         └── recintos
                              └── mesas

┌─────────────────────────────────────────────────────────────────────────┐
│                    2. USUARIOS Y PERSONAS                                │
└─────────────────────────────────────────────────────────────────────────┘

personas (Proyecto Electoral)
  │  ├── ci, nombre, apellido
  │  ├── correo, telefono
  │  └── estado (VIVO/FALLECIDO)
  │
  └──[1:1]── users (UNIFICADO)
               ├── Proyecto Votaciones: username, role, mesa_number
               ├── Proyecto Electoral: rol_electoral, cargo
               └── persona_id (FK a personas)

admin_users (auxiliar Proyecto Electoral)

┌─────────────────────────────────────────────────────────────────────────┐
│                    3. ROLES ELECTORALES                                  │
└─────────────────────────────────────────────────────────────────────────┘

personas
    │
    ├──[1:1]── jurados
    │            ├── mesa_id
    │            ├── cargo (PRESIDENTE/SECRETARIO/VOCAL/SUPLENTE)
    │            └── verificado
    │
    ├──[1:1]── veedores
    │            ├── institucion_id
    │            ├── estado (PENDIENTE/APROBADO/RECHAZADO)
    │            └── carta_respaldo
    │
    └──[1:1]── delegados
                 ├── partido_id
                 ├── mesa_id (opcional)
                 └── habilitado

┌─────────────────────────────────────────────────────────────────────────┐
│                    4. ELECCIONES Y VOTACIÓN                              │
└─────────────────────────────────────────────────────────────────────────┘

elections (Proyecto Votaciones)
    │
    ├── candidates
    │     └── acta_candidate_votes
    │             └── actas
    │
    └── actas
          ├── user_id (FK a users)
          ├── mesa_number
          ├── total_votes, null_votes, blank_votes
          └── photo_path

┌─────────────────────────────────────────────────────────────────────────┐
│                  5. PARTIDOS E INSTITUCIONES                             │
└─────────────────────────────────────────────────────────────────────────┘

partidos (Proyecto Electoral)
  ├── sigla, nombre
  ├── logo_url
  └── estado (ACTIVO/INACTIVO)
        │
        └──[1:N]── delegados
                    └── personas

instituciones (Proyecto Electoral)
  ├── nombre, sigla
  │
  └──[1:N]── veedores
              └── personas

┌─────────────────────────────────────────────────────────────────────────┐
│                  6. CREDENCIALES Y DOCUMENTOS                            │
└─────────────────────────────────────────────────────────────────────────┘

personas
    │
    └──[1:N]── credenciales
                 ├── rol (JURADO/VEEDOR/DELEGADO)
                 ├── ruta_archivo (PDF)
                 ├── contenido_qr
                 ├── estado (GENERADO/DESCARGADO/EXPIRADO)
                 └── timestamps

┌─────────────────────────────────────────────────────────────────────────┐
│                    7. ACADEMIA ELECTORAL                                 │
└─────────────────────────────────────────────────────────────────────────┘

capacitaciones
    ├── titulo, descripcion
    ├── rol_destino (JURADO/VEEDOR/DELEGADO)
    ├── total_niveles
    │
    ├──[1:N]── capacitacion_niveles
    │            ├── numero_nivel
    │            ├── contenido
    │            └── tipo_contenido
    │
    ├──[1:N]── quiz_preguntas
    │            └──[1:N]── quiz_respuestas
    │
    └──[N:N]── progreso_capacitaciones
                 ├── persona_id
                 ├── nivel_actual
                 ├── completado
                 └── puntaje_quiz

┌─────────────────────────────────────────────────────────────────────────┐
│                    8. TABLAS AUXILIARES                                  │
└─────────────────────────────────────────────────────────────────────────┘

asistencia (control de jurados)
historial_personas (histórico de roles)

┌─────────────────────────────────────────────────────────────────────────┐
│                    9. TABLAS LARAVEL (COMPARTIDAS)                       │
└─────────────────────────────────────────────────────────────────────────┘

sessions
cache, cache_locks
jobs, job_batches, failed_jobs
password_reset_tokens
```

---

## 🔗 RELACIONES CLAVE

### ✅ Relaciones COMPARTIDAS entre ambos proyectos:

```sql
-- 1. Geografía (Totalmente compartida)
departamentos → provincias → municipios
                  ↓               ↓
        (Proyecto 1)      (Proyecto 2)
       circunscripciones   asientos
                  ↓               ↓
                recintos ← ← ← ← ←
                     ↓
                  mesas (UNIFICADA)

-- 2. Usuarios/Personas (Relacionados opcionalmente)
personas ← ← [persona_id] ← ← users
   ↓                            ↓
jurados                       actas
veedores                    (digitador)
delegados

-- 3. Mesas (COMPARTIDAS)
mesas
  ├── Usadas por jurados (Proyecto Electoral)
  └── Referenciadas en actas (Proyecto Votaciones)
```

### ⚠️ Relaciones OPCIONALES (para integración futura):

```php
// Un jurado (Proyecto Electoral) podría ser también un digitador (Proyecto Votaciones)
$jurado = Jurado::find(1);
$persona = $jurado->persona;
if ($persona->user) {
    $actasDigitadas = $persona->user->actas;
}

// Una persona con rol de veedor puede consultar resultados
$veedor = Veedor::where('persona_id', $personaId)->first();
if ($veedor->estado === 'APROBADO') {
    $persona = $veedor->persona;
    $credencial = $persona->credenciales()
        ->where('rol', 'VEEDOR')
        ->where('estado', 'GENERADO')
        ->first();
}
```

---

## 📋 TABLAS POR PROYECTO

### 🟦 EXCLUSIVAS DEL PROYECTO VOTACIONES:
- `elections`
- `candidates`
- `actas`
- `acta_candidate_votes`

### 🟩 EXCLUSIVAS DEL PROYECTO ELECTORAL:
- `personas`
- `jurados`, `veedores`, `delegados`
- `partidos`, `instituciones`
- `credenciales`
- `capacitaciones`, `capacitacion_niveles`
- `progreso_capacitaciones`
- `quiz_preguntas`, `quiz_respuestas`
- `asistencia`
- `historial_personas`
- `admin_users`

### 🟨 COMPARTIDAS (UNIFICADAS):
- `departamentos`, `provincias`, `municipios`
- `recintos`, `mesas`
- `users`
- `sessions`, `cache`, `jobs`

### 🟧 ESPECÍFICAS DE CADA PROYECTO:
- **Proyecto 1:** `circunscripciones`
- **Proyecto 2:** `asientos`

---

## 🎯 CASOS DE USO DE INTEGRACIÓN

### Caso 1: Geolocalización Compartida
```php
// Ambos proyectos usan la misma estructura geográfica
$departamento = Departamento::where('nombre', 'La Paz')->first();
$municipios = $departamento->provincias()
    ->with('municipios')
    ->get()
    ->pluck('municipios')
    ->flatten();

// Proyecto Electoral: Buscar asientos
$asientos = Asiento::whereHas('municipio.provincia.departamento', 
    fn($q) => $q->where('nombre', 'La Paz')
)->get();

// Proyecto Votaciones: Buscar circunscripciones
$circunscripciones = Circunscripcion::whereHas('municipio.provincia.departamento',
    fn($q) => $q->where('nombre', 'La Paz')
)->get();
```

### Caso 2: Persona con Usuario
```php
// Crear persona en Proyecto Electoral
$persona = Persona::create([
    'ci' => '12345678',
    'nombre' => 'Juan',
    'apellido' => 'Pérez'
]);

// Asignarle un usuario para Proyecto Votaciones
$user = User::create([
    'name' => $persona->nombre . ' ' . $persona->apellido,
    'username' => $persona->ci,
    'password' => Hash::make('password'),
    'persona_id' => $persona->id,
    'role' => 'user'
]);

// Ahora puede ser jurado Y digitador
$jurado = Jurado::create([
    'persona_id' => $persona->id,
    'mesa_id' => 1,
    'cargo' => 'PRESIDENTE'
]);

// Y puede digitar actas
$acta = Acta::create([
    'user_id' => $user->id,
    'election_id' => 1,
    'mesa_number' => 1,
    // ...
]);
```

### Caso 3: Consulta de Mesas
```php
// Proyecto Electoral: Sorteo de jurados
$mesa = Mesa::find(1);
$recinto = $mesa->recinto;
if ($recinto->asiento_id) {
    $municipio = $recinto->asiento->municipio;
} else {
    $municipio = $recinto->circunscripcion->municipio;
}

// Proyecto Votaciones: Digitación de actas
$mesaNumero = 1;
$acta = Acta::where('mesa_number', $mesaNumero)->first();
```

---

## ✅ VENTAJAS DE LA UNIFICACIÓN

1. **Datos geográficos únicos** → No hay duplicación de departamentos/provincias/municipios
2. **Mesas compartidas** → Un solo registro de mesas electorales para ambos sistemas
3. **Usuarios relacionados con personas** → Posibilidad de cruce de información
4. **Independencia funcional** → Cada proyecto mantiene su lógica propia
5. **Escalabilidad** → Fácil añadir nuevas funcionalidades que crucen ambos sistemas

---

## 🚨 PRECAUCIONES

1. **No eliminar datos geográficos** sin verificar ambos proyectos
2. **Las mesas son compartidas** → Cambios afectan a ambos sistemas
3. **Cuidado con migraciones** → Deben ser compatibles con ambos proyectos
4. **Seeders de geografía** → Ejecutar solo una vez
5. **Backup regular** es crítico

---

¿Alguna duda sobre las relaciones o la estructura?
