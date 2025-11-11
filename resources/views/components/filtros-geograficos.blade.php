{{-- Componente de Filtros Geográficos --}}
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title"><i class="fas fa-map-marker-alt"></i> Filtros Geográficos</h5>
        
        <div class="row">
            <div class="col-md-2 mb-3">
                <label for="departamento" class="form-label">Departamento</label>
                <select class="form-select" id="departamento" name="departamento_id">
                    <option value="">Seleccionar...</option>
                </select>
            </div>
            
            <div class="col-md-2 mb-3">
                <label for="provincia" class="form-label">Provincia</label>
                <select class="form-select" id="provincia" name="provincia_id" disabled>
                    <option value="">Seleccionar...</option>
                </select>
            </div>
            
            <div class="col-md-2 mb-3">
                <label for="municipio" class="form-label">Municipio</label>
                <select class="form-select" id="municipio" name="municipio_id" disabled>
                    <option value="">Seleccionar...</option>
                </select>
            </div>
            
            <div class="col-md-2 mb-3">
                <label for="circunscripcion" class="form-label">Circunscripción</label>
                <select class="form-select" id="circunscripcion" name="circunscripcion_id" disabled>
                    <option value="">Seleccionar...</option>
                </select>
            </div>
            
            <div class="col-md-2 mb-3">
                <label for="recinto" class="form-label">Recinto</label>
                <select class="form-select" id="recinto" name="recinto_id" disabled>
                    <option value="">Seleccionar...</option>
                </select>
            </div>
            
            <div class="col-md-2 mb-3">
                <label for="mesa" class="form-label">Mesa</label>
                <select class="form-select" id="mesa" name="mesa_id" disabled>
                    <option value="">Seleccionar...</option>
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-primary" id="aplicarFiltros">
                    <i class="fas fa-filter"></i> Aplicar Filtros
                </button>
                <button type="button" class="btn btn-secondary" id="limpiarFiltros">
                    <i class="fas fa-times"></i> Limpiar
                </button>
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

.form-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
}

.form-select:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 8px 16px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const departamentoSelect = document.getElementById('departamento');
    const provinciaSelect = document.getElementById('provincia');
    const municipioSelect = document.getElementById('municipio');
    const circunscripcionSelect = document.getElementById('circunscripcion');
    const recintoSelect = document.getElementById('recinto');
    const mesaSelect = document.getElementById('mesa');
    
    const aplicarFiltrosBtn = document.getElementById('aplicarFiltros');
    const limpiarFiltrosBtn = document.getElementById('limpiarFiltros');

    // Cargar departamentos al inicio
    loadDepartamentos();

    async function loadDepartamentos() {
        try {
            const response = await fetch('/js/mocks/geo.json');
            const data = await response.json();
            
            departamentoSelect.innerHTML = '<option value="">Seleccionar...</option>';
            data.departamentos.forEach(depto => {
                const option = document.createElement('option');
                option.value = depto.id;
                option.textContent = depto.nombre;
                departamentoSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error cargando departamentos:', error);
        }
    }

    async function loadProvincias(departamentoId) {
        try {
            const response = await fetch('/js/mocks/geo.json');
            const data = await response.json();
            
            provinciaSelect.innerHTML = '<option value="">Seleccionar...</option>';
            const provincias = data.provincias.filter(p => p.departamento_id == departamentoId);
            
            provincias.forEach(provincia => {
                const option = document.createElement('option');
                option.value = provincia.id;
                option.textContent = provincia.nombre;
                provinciaSelect.appendChild(option);
            });
            
            provinciaSelect.disabled = false;
        } catch (error) {
            console.error('Error cargando provincias:', error);
        }
    }

    async function loadMunicipios(provinciaId) {
        try {
            const response = await fetch('/js/mocks/geo.json');
            const data = await response.json();
            
            municipioSelect.innerHTML = '<option value="">Seleccionar...</option>';
            const municipios = data.municipios.filter(m => m.provincia_id == provinciaId);
            
            municipios.forEach(municipio => {
                const option = document.createElement('option');
                option.value = municipio.id;
                option.textContent = municipio.nombre;
                municipioSelect.appendChild(option);
            });
            
            municipioSelect.disabled = false;
        } catch (error) {
            console.error('Error cargando municipios:', error);
        }
    }

    async function loadCircunscripciones(municipioId) {
        try {
            const response = await fetch('/js/mocks/geo.json');
            const data = await response.json();
            
            circunscripcionSelect.innerHTML = '<option value="">Seleccionar...</option>';
            const circunscripciones = data.circunscripciones.filter(c => c.municipio_id == municipioId);
            
            circunscripciones.forEach(circunscripcion => {
                const option = document.createElement('option');
                option.value = circunscripcion.id;
                option.textContent = circunscripcion.nombre;
                circunscripcionSelect.appendChild(option);
            });
            
            circunscripcionSelect.disabled = false;
        } catch (error) {
            console.error('Error cargando circunscripciones:', error);
        }
    }

    async function loadRecintos(circunscripcionId) {
        try {
            const response = await fetch('/js/mocks/geo.json');
            const data = await response.json();
            
            recintoSelect.innerHTML = '<option value="">Seleccionar...</option>';
            const recintos = data.recintos.filter(r => r.circunscripcion_id == circunscripcionId);
            
            recintos.forEach(recinto => {
                const option = document.createElement('option');
                option.value = recinto.id;
                option.textContent = recinto.nombre;
                recintoSelect.appendChild(option);
            });
            
            recintoSelect.disabled = false;
        } catch (error) {
            console.error('Error cargando recintos:', error);
        }
    }

    async function loadMesas(recintoId) {
        try {
            const response = await fetch('/js/mocks/geo.json');
            const data = await response.json();
            
            mesaSelect.innerHTML = '<option value="">Seleccionar...</option>';
            const mesas = data.mesas.filter(m => m.recinto_id == recintoId);
            
            mesas.forEach(mesa => {
                const option = document.createElement('option');
                option.value = mesa.id;
                option.textContent = mesa.nombre;
                mesaSelect.appendChild(option);
            });
            
            mesaSelect.disabled = false;
        } catch (error) {
            console.error('Error cargando mesas:', error);
        }
    }

    // Event listeners para cascada
    departamentoSelect.addEventListener('change', function() {
        const departamentoId = this.value;
        if (departamentoId) {
            loadProvincias(departamentoId);
        } else {
            resetSelects([provinciaSelect, municipioSelect, circunscripcionSelect, recintoSelect, mesaSelect]);
        }
    });

    provinciaSelect.addEventListener('change', function() {
        const provinciaId = this.value;
        if (provinciaId) {
            loadMunicipios(provinciaId);
        } else {
            resetSelects([municipioSelect, circunscripcionSelect, recintoSelect, mesaSelect]);
        }
    });

    municipioSelect.addEventListener('change', function() {
        const municipioId = this.value;
        if (municipioId) {
            loadCircunscripciones(municipioId);
        } else {
            resetSelects([circunscripcionSelect, recintoSelect, mesaSelect]);
        }
    });

    circunscripcionSelect.addEventListener('change', function() {
        const circunscripcionId = this.value;
        if (circunscripcionId) {
            loadRecintos(circunscripcionId);
        } else {
            resetSelects([recintoSelect, mesaSelect]);
        }
    });

    recintoSelect.addEventListener('change', function() {
        const recintoId = this.value;
        if (recintoId) {
            loadMesas(recintoId);
        } else {
            resetSelects([mesaSelect]);
        }
    });

    function resetSelects(selects) {
        selects.forEach(select => {
            select.innerHTML = '<option value="">Seleccionar...</option>';
            select.disabled = true;
        });
    }

    // Event listeners para botones
    aplicarFiltrosBtn.addEventListener('click', function() {
        const filtros = {
            departamento: departamentoSelect.value,
            provincia: provinciaSelect.value,
            municipio: municipioSelect.value,
            circunscripcion: circunscripcionSelect.value,
            recinto: recintoSelect.value,
            mesa: mesaSelect.value
        };
        
        // Disparar evento personalizado para que otros componentes puedan escuchar
        window.dispatchEvent(new CustomEvent('filtrosAplicados', { detail: filtros }));
    });

    limpiarFiltrosBtn.addEventListener('click', function() {
        departamentoSelect.value = '';
        resetSelects([provinciaSelect, municipioSelect, circunscripcionSelect, recintoSelect, mesaSelect]);
        
        // Disparar evento para limpiar filtros
        window.dispatchEvent(new CustomEvent('filtrosLimpiados'));
    });
});
</script>
