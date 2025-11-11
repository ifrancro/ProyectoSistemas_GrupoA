<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Candidate;
use App\Models\Acta;
use Illuminate\Http\Request;

class ResultadosController extends Controller
{
    public function index()
    {
        // Obtener ambas elecciones
        $electionPresidente = Election::where('name', 'Elección Presidencial 2024')->first();
        $electionDiputados = Election::where('name', 'Elección de Diputados 2024')->first();

        // Datos para Presidente
        $candidatesPresidente = collect();
        $actasPresidente = 0;
        $totalVotesPresidente = 0;
        
        if ($electionPresidente) {
            $candidatesPresidente = $electionPresidente->candidates()
                ->where('is_active', true)
                ->orderBy('position')
                ->get()
                ->map(function($candidate) {
                    $totalVotes = $candidate->actaVotes()->sum('votes');
                    return [
                        'id' => $candidate->id,
                        'nombre' => $candidate->name,
                        'sigla' => $candidate->party,
                        'color_hex' => $candidate->color_hex,
                        'votos' => $totalVotes
                    ];
                });
            
            $actasPresidente = Acta::where('election_id', $electionPresidente->id)->count();
            $totalVotesPresidente = $candidatesPresidente->sum('votos');
        }

        // Datos para Diputados
        $candidatesDiputados = collect();
        $actasDiputados = 0;
        $totalVotesDiputados = 0;
        
        if ($electionDiputados) {
            $candidatesDiputados = $electionDiputados->candidates()
                ->where('is_active', true)
                ->orderBy('position')
                ->get()
                ->map(function($candidate) {
                    $totalVotes = $candidate->actaVotes()->sum('votes');
                    return [
                        'id' => $candidate->id,
                        'nombre' => $candidate->name,
                        'sigla' => $candidate->party,
                        'color_hex' => $candidate->color_hex,
                        'votos' => $totalVotes
                    ];
                });
            
            $actasDiputados = Acta::where('election_id', $electionDiputados->id)->count();
            $totalVotesDiputados = $candidatesDiputados->sum('votos');
        }

        return view('dashboard.resultados', compact(
            'electionPresidente',
            'electionDiputados',
            'candidatesPresidente',
            'candidatesDiputados',
            'actasPresidente',
            'actasDiputados',
            'totalVotesPresidente',
            'totalVotesDiputados'
        ));
    }
}

