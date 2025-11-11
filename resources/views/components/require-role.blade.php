{{-- Componente RequireRole - Protege contenido basado en roles --}}
@php
    $userRole = auth()->user()->rol ?? 'user';
    $allowedRoles = $allowedRoles ?? [];
    $hasAccess = in_array($userRole, $allowedRoles);
@endphp

@if($hasAccess)
    {{ $slot }}
@else
    <div class="alert alert-warning">
        <i class="fas fa-lock"></i>
        <strong>Acceso Restringido</strong><br>
        No tiene permisos para acceder a esta sección. Contacte al administrador si cree que esto es un error.
    </div>
@endif
