@extends('layouts.app')

@section('title', 'Resultados Electorales')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1><i class="fas fa-chart-bar"></i> Resultados Electorales</h1>
            <p class="text-muted">Resultados en tiempo real de las elecciones</p>
        </div>
    </div>

    <!-- RESULTADOS PRESIDENTE/VICEPRESIDENTE -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="fas fa-vote-yea me-2"></i>
                        Elección Presidencial 2024
                    </h3>
                    <small>Actas procesadas: {{ $actasPresidente }}/16 mesas</small>
                </div>
                <div class="card-body">
                    @if($candidatesPresidente->count() > 0)
                        <!-- Progreso de conteo -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="progress mb-2" style="height: 20px;">
                                    @php
                                        $porcentajePresidente = ($actasPresidente / 16) * 100;
                                    @endphp
                                    <div class="progress-bar bg-primary" 
                                         role="progressbar" 
                                         style="width: {{ $porcentajePresidente }}%">
                                        {{ number_format($porcentajePresidente, 1) }}% procesado
                                    </div>
                                </div>
                                <p class="text-muted mb-0">
                                    Total de votos presidenciales: <strong>{{ number_format($totalVotesPresidente) }}</strong>
                                </p>
                            </div>
                        </div>

                        <!-- Candidatos Presidenciales -->
                        <div class="row">
                            @foreach($candidatesPresidente as $candidate)
                                <div class="col-md-3 mb-3">
                                    <div class="candidate-card" style="background: linear-gradient(135deg, {{ $candidate['color_hex'] }} 0%, {{ $candidate['color_hex'] }}dd 100%); color: white;">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-user me-2"></i>
                                            <h5 class="mb-0">{{ $candidate['nombre'] }}</h5>
                                        </div>
                                        @if($candidate['sigla'])
                                            <p class="mb-2" style="opacity: 0.9;">{{ $candidate['sigla'] }}</p>
                                        @endif
                                        <div class="text-center">
                                            <h6>Votos</h6>
                                            <h2 class="mb-0">{{ number_format($candidate['votos']) }}</h2>
                                            @if($totalVotesPresidente > 0)
                                                <small style="opacity: 0.9;">
                                                    {{ number_format(($candidate['votos'] / $totalVotesPresidente) * 100, 1) }}%
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Ganador Provisional Presidente -->
                        @if($totalVotesPresidente > 0)
                            @php
                                $ganadorPresidente = $candidatesPresidente->sortByDesc('votos')->first();
                            @endphp
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="alert alert-success">
                                        <i class="fas fa-trophy me-2"></i>
                                        <strong>Ganador Provisional (Presidente):</strong> 
                                        {{ $ganadorPresidente['nombre'] }} con {{ number_format($ganadorPresidente['votos']) }} votos
                                        ({{ number_format(($ganadorPresidente['votos'] / $totalVotesPresidente) * 100, 1) }}%)
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            No hay datos de candidatos presidenciales disponibles.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- RESULTADOS DIPUTADOS -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0">
                        <i class="fas fa-users me-2"></i>
                        Elección de Diputados 2024
                    </h3>
                    <small>Actas procesadas: {{ $actasDiputados }}/16 mesas</small>
                </div>
                <div class="card-body">
                    @if($candidatesDiputados->count() > 0)
                        <!-- Progreso de conteo -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="progress mb-2" style="height: 20px;">
                                    @php
                                        $porcentajeDiputados = ($actasDiputados / 16) * 100;
                                    @endphp
                                    <div class="progress-bar bg-warning" 
                                         role="progressbar" 
                                         style="width: {{ $porcentajeDiputados }}%">
                                        {{ number_format($porcentajeDiputados, 1) }}% procesado
                                    </div>
                                </div>
                                <p class="text-muted mb-0">
                                    Total de votos para diputados: <strong>{{ number_format($totalVotesDiputados) }}</strong>
                                </p>
                            </div>
                        </div>

                        <!-- Candidatos a Diputados -->
                        <div class="row">
                            @foreach($candidatesDiputados as $candidate)
                                <div class="col-md-3 mb-3">
                                    <div class="candidate-card" style="background: linear-gradient(135deg, {{ $candidate['color_hex'] }} 0%, {{ $candidate['color_hex'] }}dd 100%); color: white;">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-user-tie me-2"></i>
                                            <h5 class="mb-0">{{ $candidate['nombre'] }}</h5>
                                        </div>
                                        @if($candidate['sigla'])
                                            <p class="mb-2" style="opacity: 0.9;">{{ $candidate['sigla'] }}</p>
                                        @endif
                                        <div class="text-center">
                                            <h6>Votos</h6>
                                            <h2 class="mb-0">{{ number_format($candidate['votos']) }}</h2>
                                            @if($totalVotesDiputados > 0)
                                                <small style="opacity: 0.9;">
                                                    {{ number_format(($candidate['votos'] / $totalVotesDiputados) * 100, 1) }}%
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Ganador Provisional Diputados -->
                        @if($totalVotesDiputados > 0)
                            @php
                                $ganadorDiputados = $candidatesDiputados->sortByDesc('votos')->first();
                            @endphp
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="alert alert-warning">
                                        <i class="fas fa-trophy me-2"></i>
                                        <strong>Ganador Provisional (Diputados):</strong> 
                                        {{ $ganadorDiputados['nombre'] }} con {{ number_format($ganadorDiputados['votos']) }} votos
                                        ({{ number_format(($ganadorDiputados['votos'] / $totalVotesDiputados) * 100, 1) }}%)
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            No hay datos de candidatos para diputados disponibles.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen General -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5><i class="fas fa-chart-pie me-2"></i>Resumen Presidente</h5>
                    <h3 class="text-primary">{{ number_format($totalVotesPresidente) }}</h3>
                    <p class="text-muted">Total de votos</p>
                    <small>{{ $actasPresidente }}/16 mesas procesadas</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5><i class="fas fa-chart-bar me-2"></i>Resumen Diputados</h5>
                    <h3 class="text-warning">{{ number_format($totalVotesDiputados) }}</h3>
                    <p class="text-muted">Total de votos</p>
                    <small>{{ $actasDiputados }}/16 mesas procesadas</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Última actualización -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <p class="text-muted">
                <i class="fas fa-clock me-1"></i>
                Última actualización: {{ now()->format('d/m/Y H:i:s') }}
            </p>
        </div>
    </div>
</div>

<style>
.candidate-card {
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    height: 180px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.candidate-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.card {
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border: none;
}
</style>
@endsection

