{{-- Componente para mostrar ganador provisional --}}
<div class="alert alert-success alert-dismissible fade show" role="alert" id="ganadorProvisional" style="display: none;">
    <div class="d-flex align-items-center">
        <i class="fas fa-trophy me-3" style="font-size: 1.5rem;"></i>
        <div>
            <h5 class="alert-heading mb-1">
                <span id="ganadorTitulo">Ganador Provisional</span>
            </h5>
            <p class="mb-0" id="ganadorMensaje">
                <!-- Se llenará dinámicamente -->
            </p>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<script>
// Función global para mostrar ganador provisional
window.mostrarGanadorProvisional = function(tipo, ganador, votos, mensaje) {
    const alert = document.getElementById('ganadorProvisional');
    const titulo = document.getElementById('ganadorTitulo');
    const mensaje = document.getElementById('ganadorMensaje');
    
    if (tipo === 'presidente') {
        titulo.textContent = 'Ganador Provisional - Presidente/Vice';
        mensaje.innerHTML = `
            <strong>${ganador}</strong> con <strong>${votos.toLocaleString()}</strong> votos
            <br><small class="text-muted">${mensaje || 'Cómputo nacional completo'}</small>
        `;
        alert.className = 'alert alert-success alert-dismissible fade show';
    } else if (tipo === 'diputados') {
        titulo.textContent = 'Ganador Provisional - Diputados';
        mensaje.innerHTML = `
            <strong>${ganador}</strong> con <strong>${votos.toLocaleString()}</strong> votos finales
            <br><small class="text-muted">${mensaje || 'Considerando ajuste por votación uninominal'}</small>
        `;
        alert.className = 'alert alert-info alert-dismissible fade show';
    }
    
    alert.style.display = 'block';
    
    // Auto-hide después de 10 segundos
    setTimeout(() => {
        if (alert.style.display !== 'none') {
            alert.style.display = 'none';
        }
    }, 10000);
};

// Función para mostrar mensaje de datos insuficientes
window.mostrarDatosInsuficientes = function(tipo) {
    const alert = document.getElementById('ganadorProvisional');
    const titulo = document.getElementById('ganadorTitulo');
    const mensaje = document.getElementById('ganadorMensaje');
    
    titulo.textContent = `Cómputo Parcial - ${tipo === 'presidente' ? 'Presidente/Vice' : 'Diputados'}`;
    mensaje.innerHTML = `
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Datos insuficientes</strong> para determinar un ganador definitivo
        <br><small class="text-muted">Se requiere más información para un cómputo completo</small>
    `;
    alert.className = 'alert alert-warning alert-dismissible fade show';
    alert.style.display = 'block';
    
    // Auto-hide después de 8 segundos
    setTimeout(() => {
        if (alert.style.display !== 'none') {
            alert.style.display = 'none';
        }
    }, 8000);
};
</script>
