// Servicio de API con soporte para mocks
class ApiService {
    constructor() {
        this.config = window.APP_CONFIG || { USE_MOCKS: true, MOCKS_BASE_URL: '/js/mocks' };
    }

    async fetchData(endpoint, options = {}) {
        if (this.config.USE_MOCKS) {
            return this.fetchMockData(endpoint, options);
        }
        return this.fetchRealData(endpoint, options);
    }

    async fetchMockData(endpoint, options = {}) {
        const mockUrl = `${this.config.MOCKS_BASE_URL}${endpoint}`;
        try {
            const response = await fetch(mockUrl);
            if (!response.ok) {
                throw new Error(`Mock data not found: ${endpoint}`);
            }
            return await response.json();
        } catch (error) {
            console.warn(`Mock data not available for ${endpoint}:`, error);
            return this.getDefaultMockData(endpoint);
        }
    }

    async fetchRealData(endpoint, options = {}) {
        const url = `${this.config.API_BASE_URL}${endpoint}`;
        const response = await fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...options.headers
            },
            ...options
        });
        
        if (!response.ok) {
            throw new Error(`API Error: ${response.status}`);
        }
        
        return await response.json();
    }

    getDefaultMockData(endpoint) {
        const defaults = {
            '/geo.json': {
                departamentos: [],
                provincias: [],
                municipios: [],
                circunscripciones: [],
                recintos: [],
                asientos: [],
                mesas: []
            },
            '/diputados.json': {
                candidates: [],
                votos: []
            }
        };
        return defaults[endpoint] || {};
    }

    // Métodos específicos para datos geográficos
    async getDepartamentos() {
        const data = await this.fetchData('/geo.json');
        return data.departamentos || [];
    }

    async getProvincias(departamentoId = null) {
        const data = await this.fetchData('/geo.json');
        let provincias = data.provincias || [];
        if (departamentoId) {
            provincias = provincias.filter(p => p.departamento_id === departamentoId);
        }
        return provincias;
    }

    async getMunicipios(provinciaId = null) {
        const data = await this.fetchData('/geo.json');
        let municipios = data.municipios || [];
        if (provinciaId) {
            municipios = municipios.filter(m => m.provincia_id === provinciaId);
        }
        return municipios;
    }

    async getCircunscripciones(municipioId = null) {
        const data = await this.fetchData('/geo.json');
        let circunscripciones = data.circunscripciones || [];
        if (municipioId) {
            circunscripciones = circunscripciones.filter(c => c.municipio_id === municipioId);
        }
        return circunscripciones;
    }

    async getRecintos(circunscripcionId = null) {
        const data = await this.fetchData('/geo.json');
        let recintos = data.recintos || [];
        if (circunscripcionId) {
            recintos = recintos.filter(r => r.circunscripcion_id === circunscripcionId);
        }
        return recintos;
    }

    async getAsientos(recintoId = null) {
        const data = await this.fetchData('/geo.json');
        let asientos = data.asientos || [];
        if (recintoId) {
            asientos = asientos.filter(a => a.recinto_id === recintoId);
        }
        return asientos;
    }

    async getMesas(asientoId = null) {
        const data = await this.fetchData('/geo.json');
        let mesas = data.mesas || [];
        if (asientoId) {
            mesas = mesas.filter(m => m.asiento_id === asientoId);
        }
        return mesas;
    }

    // Métodos para candidatos de diputados
    async getDiputadosCandidates(circunscripcionId = null) {
        const data = await this.fetchData('/diputados.json');
        let candidates = data.candidates || [];
        if (circunscripcionId) {
            candidates = candidates.filter(c => c.circunscripcion_id === circunscripcionId);
        }
        return candidates;
    }

    async getDiputadosVotos(filters = {}) {
        const data = await this.fetchData('/diputados.json');
        return data.votos || [];
    }

    // Método para calcular ganadores
    computeDiputadosWinner(totales, uninominales) {
        if (!totales || !uninominales) {
            return { winner: null, message: "Datos insuficientes para calcular ganador" };
        }

        // Lógica de cálculo de ganadores para diputados
        // Considerando votos uninominales que restan del total
        const candidates = Object.keys(totales);
        let winner = null;
        let maxVotes = 0;

        for (const candidateId of candidates) {
            const totalVotes = totales[candidateId] || 0;
            const uninominalVotes = uninominales[candidateId] || 0;
            const finalVotes = totalVotes - uninominalVotes;

            if (finalVotes > maxVotes) {
                maxVotes = finalVotes;
                winner = candidateId;
            }
        }

        if (winner) {
            return {
                winner: winner,
                votes: maxVotes,
                message: `Ganador provisional: Candidato ${winner} con ${maxVotes} votos (considerando ajuste por votación uninominal)`
            };
        }

        return { winner: null, message: "No se pudo determinar ganador" };
    }
}

// Instancia global del servicio
window.apiService = new ApiService();
