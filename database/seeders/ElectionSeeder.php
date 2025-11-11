<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Election;
use App\Models\Candidate;

class ElectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear elección para Presidente
        $electionPresidente = Election::create([
            'name' => 'Elección Presidencial 2024',
            'description' => 'Elecciones para presidente y vicepresidente',
            'election_date' => '2024-12-15',
            'is_active' => true
        ]);

        // Crear elección para Diputados
        $electionDiputados = Election::create([
            'name' => 'Elección de Diputados 2024',
            'description' => 'Elecciones para diputados uninominales y plurinominales',
            'election_date' => '2024-12-15',
            'is_active' => true
        ]);

        // Candidatos para Presidente
        $candidatesPresidente = [
            ['name' => 'Rodrigo Paz', 'party' => 'Partido A', 'color_hex' => '#3BA3BC', 'position' => 1],
            ['name' => 'Tuto Quiroga', 'party' => 'Partido B', 'color_hex' => '#FF0000', 'position' => 2],
            ['name' => 'Samuel Doria Medina', 'party' => 'Partido C', 'color_hex' => '#FFD200', 'position' => 3],
            ['name' => 'Andronico Rodriguez', 'party' => 'Partido D', 'color_hex' => '#008F39', 'position' => 4],
            ['name' => 'Manfred Reyes', 'party' => 'Partido E', 'color_hex' => '#6600A1', 'position' => 5],
            ['name' => 'Jhonny Fernandez', 'party' => 'Partido F', 'color_hex' => '#51D1F6', 'position' => 6],
            ['name' => 'Eduardo del Castillo', 'party' => 'Partido G', 'color_hex' => '#0000FF', 'position' => 7],
            ['name' => 'Pavel Aracena Vargas', 'party' => 'Partido H', 'color_hex' => '#8B0000', 'position' => 8],
        ];

        // Candidatos para Diputados (diferentes personas)
        $candidatesDiputados = [
            ['name' => 'María González', 'party' => 'Partido A', 'color_hex' => '#3BA3BC', 'position' => 1],
            ['name' => 'Carlos Mendoza', 'party' => 'Partido B', 'color_hex' => '#FF0000', 'position' => 2],
            ['name' => 'Ana Vargas', 'party' => 'Partido C', 'color_hex' => '#FFD200', 'position' => 3],
            ['name' => 'Luis Morales', 'party' => 'Partido D', 'color_hex' => '#008F39', 'position' => 4],
            ['name' => 'Carmen Silva', 'party' => 'Partido E', 'color_hex' => '#6600A1', 'position' => 5],
            ['name' => 'Roberto Jiménez', 'party' => 'Partido F', 'color_hex' => '#51D1F6', 'position' => 6],
            ['name' => 'Patricia López', 'party' => 'Partido G', 'color_hex' => '#0000FF', 'position' => 7],
            ['name' => 'Miguel Torres', 'party' => 'Partido H', 'color_hex' => '#8B0000', 'position' => 8],
        ];

        // Crear candidatos para Presidente
        foreach ($candidatesPresidente as $candidateData) {
            Candidate::create(array_merge($candidateData, [
                'election_id' => $electionPresidente->id,
                'is_active' => true
            ]));
        }

        // Crear candidatos para Diputados
        foreach ($candidatesDiputados as $candidateData) {
            Candidate::create(array_merge($candidateData, [
                'election_id' => $electionDiputados->id,
                'is_active' => true
            ]));
        }
    }
}
