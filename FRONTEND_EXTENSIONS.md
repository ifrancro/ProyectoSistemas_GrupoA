# Extensiones del Frontend - Sistema Electoral

## Resumen de Funcionalidades Implementadas

### ✅ 1. Votos de Diputados
- **Ruta**: `/votos/diputados`
- **Archivo**: `resources/views/votos/diputados.blade.php`
- **Características**:
  - Replica el patrón de votos de Presidente/Vice
  - Incluye campos para votos totales y votos uninominales
  - Validación para que votos uninominales no excedan votos totales
  - Cálculo automático de ganador considerando ajuste por votación uninominal

### ✅ 2. Filtros Geográficos
- **Componente**: `resources/views/components/filtros-geograficos.blade.php`
- **Características**:
  - Selects en cascada: Departamento → Provincia → Municipio → Circunscripción → Recinto → Mesa
  - Carga dinámica de opciones desde mocks (`/js/mocks/geo.json`)
  - Eventos personalizados para comunicación entre componentes
  - Botones para aplicar y limpiar filtros

### ✅ 3. Nivel de Agregación
- **Componente**: `resources/views/components/nivel-agregacion.blade.php`
- **Características**:
  - Radio buttons para seleccionar nivel: Nacional, Departamento, Circunscripción
  - Descripción dinámica del nivel seleccionado
  - Eventos personalizados para actualizar vistas

### ✅ 4. Control por Roles
- **Componente**: `resources/views/components/require-role.blade.php`
- **Roles implementados**:
  - `admin`: Acceso completo
  - `presidente_tse`: Acceso a búsqueda de actas
  - `user`: Acceso básico (votos)
- **Protecciones**:
  - Búsqueda de actas solo para admin y presidente_tse
  - Sidebar actualizado con enlaces condicionales

### ✅ 5. Cálculos de Ganadores Provisionales
- **Componente**: `resources/views/components/ganador-provisional.blade.php`
- **Características**:
  - Mensajes diferenciados para Presidente/Vice y Diputados
  - Cálculo automático considerando votación uninominal para diputados
  - Mensajes de "datos insuficientes" cuando corresponde
  - Auto-hide de alertas

### ✅ 6. Sistema de Mocks
- **Configuración**: `public/js/config.js`
- **Archivos de mocks**:
  - `public/js/mocks/geo.json`: Datos geográficos
  - `public/js/mocks/diputados.json`: Candidatos y votos de diputados
- **Servicio API**: `public/js/services/api.js`
- **Flag**: `USE_MOCKS=true` para activar/desactivar mocks

### ✅ 7. Vista de Resultados Mejorada
- **Ruta**: `/resultados`
- **Archivo**: `resources/views/dashboard/resultados.blade.php`
- **Características**:
  - Tabs para Presidente/Vice y Diputados
  - Integración de filtros geográficos y nivel de agregación
  - Carga dinámica de resultados de diputados
  - Gráficos interactivos

## Estructura de Archivos Creados/Modificados

### Nuevos Archivos
```
public/js/
├── config.js
├── services/
│   └── api.js
└── mocks/
    ├── geo.json
    └── diputados.json

resources/views/
├── votos/
│   └── diputados.blade.php
├── dashboard/
│   └── resultados.blade.php
└── components/
    ├── filtros-geograficos.blade.php
    ├── nivel-agregacion.blade.php
    ├── require-role.blade.php
    └── ganador-provisional.blade.php
```

### Archivos Modificados
```
routes/web.php
resources/views/layouts/app.blade.php
resources/views/actas/create.blade.php
resources/views/actas/search.blade.php
```

## Configuración

### Activar/Desactivar Mocks
En `public/js/config.js`:
```javascript
window.APP_CONFIG = {
    USE_MOCKS: true, // Cambiar a false para usar endpoints reales
    API_BASE_URL: '/api',
    MOCKS_BASE_URL: '/js/mocks'
};
```

### Roles de Usuario
Los roles se manejan en el modelo User:
- `admin`: Acceso completo
- `presidente_tse`: Acceso a búsqueda de actas
- `user`: Acceso básico

## Uso de Componentes

### Filtros Geográficos
```php
@include('components.filtros-geograficos')
```

### Nivel de Agregación
```php
@include('components.nivel-agregacion')
```

### Control por Roles
```php
@include('components.require-role', ['allowedRoles' => ['admin', 'presidente_tse']])
```

### Ganador Provisional
```php
@include('components.ganador-provisional')
```

## Eventos JavaScript

### Filtros Aplicados
```javascript
window.addEventListener('filtrosAplicados', function(event) {
    const filtros = event.detail;
    // Procesar filtros
});
```

### Nivel de Agregación Cambiado
```javascript
window.addEventListener('nivelAgregacionCambiado', function(event) {
    const nivel = event.detail.nivel;
    // Actualizar vista según nivel
});
```

### Mostrar Ganador Provisional
```javascript
window.mostrarGanadorProvisional('presidente', 'Candidato X', 1500, 'Mensaje adicional');
window.mostrarDatosInsuficientes('diputados');
```

## Características Técnicas

- **Sin cambios en backend**: Todas las funcionalidades son frontend-only
- **Mocks configurables**: Sistema de fallback para datos faltantes
- **Responsive**: Mantiene el diseño actual con Bootstrap
- **Eventos personalizados**: Comunicación entre componentes
- **Validaciones**: Cliente y servidor
- **Accesibilidad**: Roles y permisos claros

## Próximos Pasos

1. **Integración con API real**: Cambiar `USE_MOCKS=false` cuando estén disponibles los endpoints
2. **Testing**: Agregar tests para los nuevos componentes
3. **Optimización**: Lazy loading para datos geográficos grandes
4. **Internacionalización**: Soporte para múltiples idiomas
