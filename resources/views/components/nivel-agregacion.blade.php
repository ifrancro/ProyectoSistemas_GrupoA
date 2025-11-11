{{-- Componente de Nivel de Agregación --}}
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title"><i class="fas fa-chart-bar"></i> Nivel de Agregación</h5>
        
        <div class="row">
            <div class="col-12">
                <div class="btn-group" role="group" aria-label="Nivel de agregación">
                    <input type="radio" class="btn-check" name="nivelAgregacion" id="nacional" value="nacional" checked>
                    <label class="btn btn-outline-primary" for="nacional">
                        <i class="fas fa-globe"></i> Nacional
                    </label>

                    <input type="radio" class="btn-check" name="nivelAgregacion" id="departamento" value="departamento">
                    <label class="btn btn-outline-primary" for="departamento">
                        <i class="fas fa-map"></i> Departamento
                    </label>

                    <input type="radio" class="btn-check" name="nivelAgregacion" id="circunscripcion" value="circunscripcion">
                    <label class="btn btn-outline-primary" for="circunscripcion">
                        <i class="fas fa-map-marker-alt"></i> Circunscripción
                    </label>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span id="nivelDescripcion">Vista nacional: Muestra resultados agregados de todo el país</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    border: none;
}

.btn-group .btn {
    border-radius: 8px;
    margin-right: 5px;
}

.btn-check:checked + .btn-outline-primary {
    background-color: #3498db;
    border-color: #3498db;
    color: white;
}

.alert {
    border-radius: 10px;
    border: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nivelInputs = document.querySelectorAll('input[name="nivelAgregacion"]');
    const nivelDescripcion = document.getElementById('nivelDescripcion');
    
    const descripciones = {
        'nacional': 'Vista nacional: Muestra resultados agregados de todo el país',
        'departamento': 'Vista departamental: Muestra resultados por departamento',
        'circunscripcion': 'Vista por circunscripción: Muestra resultados por circunscripción electoral'
    };

    nivelInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                const nivel = this.value;
                nivelDescripcion.textContent = descripciones[nivel];
                
                // Disparar evento personalizado para que otros componentes puedan escuchar
                window.dispatchEvent(new CustomEvent('nivelAgregacionCambiado', { 
                    detail: { nivel: nivel } 
                }));
            }
        });
    });
});
</script>
