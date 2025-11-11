<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeografiaSeeder extends Seeder
{
    /**
     * Seeder de datos geográficos de Bolivia
     * EJECUTAR SOLO UNA VEZ - Compartido por ambos proyectos
     */
    public function run(): void
    {
        // Departamentos de Bolivia
        $departamentos = [
            ['id' => 1, 'nombre' => 'La Paz', 'codigo' => 'LP', 'activo' => true],
            ['id' => 2, 'nombre' => 'Cochabamba', 'codigo' => 'CB', 'activo' => true],
            ['id' => 3, 'nombre' => 'Santa Cruz', 'codigo' => 'SC', 'activo' => true],
            ['id' => 4, 'nombre' => 'Oruro', 'codigo' => 'OR', 'activo' => true],
            ['id' => 5, 'nombre' => 'Potosí', 'codigo' => 'PT', 'activo' => true],
            ['id' => 6, 'nombre' => 'Tarija', 'codigo' => 'TJ', 'activo' => true],
            ['id' => 7, 'nombre' => 'Chuquisaca', 'codigo' => 'CH', 'activo' => true],
            ['id' => 8, 'nombre' => 'Beni', 'codigo' => 'BN', 'activo' => true],
            ['id' => 9, 'nombre' => 'Pando', 'codigo' => 'PD', 'activo' => true],
        ];

        DB::table('departamentos')->insert($departamentos);

        // Provincias principales
        $provincias = [
            // La Paz
            ['nombre' => 'Murillo', 'departamento_id' => 1, 'codigo' => 'MUR', 'activo' => true],
            ['nombre' => 'Omasuyos', 'departamento_id' => 1, 'codigo' => 'OMA', 'activo' => true],
            
            // Cochabamba
            ['nombre' => 'Cercado', 'departamento_id' => 2, 'codigo' => 'CER', 'activo' => true],
            ['nombre' => 'Quillacollo', 'departamento_id' => 2, 'codigo' => 'QUI', 'activo' => true],
            
            // Santa Cruz
            ['nombre' => 'Andrés Ibáñez', 'departamento_id' => 3, 'codigo' => 'AIB', 'activo' => true],
            ['nombre' => 'Warnes', 'departamento_id' => 3, 'codigo' => 'WAR', 'activo' => true],
        ];

        DB::table('provincias')->insert($provincias);

        // Municipios principales
        $municipios = [
            // La Paz
            ['nombre' => 'La Paz', 'provincia_id' => 1, 'codigo' => 'LPZ', 'activo' => true],
            ['nombre' => 'El Alto', 'provincia_id' => 1, 'codigo' => 'EAL', 'activo' => true],
            ['nombre' => 'Achacachi', 'provincia_id' => 2, 'codigo' => 'ACH', 'activo' => true],
            
            // Cochabamba
            ['nombre' => 'Cochabamba', 'provincia_id' => 3, 'codigo' => 'CBB', 'activo' => true],
            ['nombre' => 'Quillacollo', 'provincia_id' => 4, 'codigo' => 'QLL', 'activo' => true],
            
            // Santa Cruz
            ['nombre' => 'Santa Cruz de la Sierra', 'provincia_id' => 5, 'codigo' => 'SCZ', 'activo' => true],
            ['nombre' => 'Warnes', 'provincia_id' => 6, 'codigo' => 'WRN', 'activo' => true],
        ];

        DB::table('municipios')->insert($municipios);

        // Circunscripciones (Para Proyecto Votaciones)
        // NOTA: La tabla se llama 'circunscripcions' (sin 'e' final)
        $circunscripciones = [
            ['nombre' => 'Circunscripción 1 - La Paz Centro', 'municipio_id' => 1, 'codigo' => 'C01', 'numero_electores' => 15000, 'activo' => true],
            ['nombre' => 'Circunscripción 2 - La Paz Norte', 'municipio_id' => 1, 'codigo' => 'C02', 'numero_electores' => 12000, 'activo' => true],
            ['nombre' => 'Circunscripción 1 - Santa Cruz Centro', 'municipio_id' => 6, 'codigo' => 'C03', 'numero_electores' => 20000, 'activo' => true],
        ];

        DB::table('circunscripcions')->insert($circunscripciones);

        // Asientos (Para Proyecto Electoral)
        $asientos = [
            ['nombre' => 'Centro', 'municipio_id' => 1],
            ['nombre' => 'Norte', 'municipio_id' => 1],
            ['nombre' => 'Sur', 'municipio_id' => 1],
            ['nombre' => 'Centro', 'municipio_id' => 6],
        ];

        DB::table('asientos')->insert($asientos);

        // Recintos (con soporte dual: circunscripcion_id o asiento_id)
        $recintos = [
            // Recintos del Proyecto Votaciones (usa circunscripcion_id)
            [
                'nombre' => 'Unidad Educativa San Calixto',
                'direccion' => 'Calle Indaburo #850',
                'codigo' => 'R001',
                'circunscripcion_id' => 1,
                'asiento_id' => null,
                'activo' => true
            ],
            [
                'nombre' => 'Colegio Don Bosco',
                'direccion' => 'Av. Ecuador #233',
                'codigo' => 'R002',
                'circunscripcion_id' => 1,
                'asiento_id' => null,
                'activo' => true
            ],
            
            // Recintos del Proyecto Electoral (usa asiento_id)
            [
                'nombre' => 'Colegio Nacional Florida',
                'direccion' => 'Av. Cañoto',
                'codigo' => 'R003',
                'circunscripcion_id' => null,
                'asiento_id' => 1,
                'activo' => true
            ],
            [
                'nombre' => 'Escuela San Martín',
                'direccion' => 'Av. Roca y Coronado',
                'codigo' => 'R004',
                'circunscripcion_id' => null,
                'asiento_id' => 1,
                'activo' => true
            ],
        ];

        DB::table('recintos')->insert($recintos);

        // Mesas (unificadas)
        $mesas = [
            ['recinto_id' => 1, 'numero_mesa' => 1, 'cantidad_electores' => 240, 'activa' => true],
            ['recinto_id' => 1, 'numero_mesa' => 2, 'cantidad_electores' => 240, 'activa' => true],
            ['recinto_id' => 1, 'numero_mesa' => 3, 'cantidad_electores' => 230, 'activa' => true],
            ['recinto_id' => 2, 'numero_mesa' => 1, 'cantidad_electores' => 240, 'activa' => true],
            ['recinto_id' => 2, 'numero_mesa' => 2, 'cantidad_electores' => 235, 'activa' => true],
            ['recinto_id' => 3, 'numero_mesa' => 1, 'cantidad_electores' => 240, 'activa' => true],
            ['recinto_id' => 3, 'numero_mesa' => 2, 'cantidad_electores' => 240, 'activa' => true],
            ['recinto_id' => 4, 'numero_mesa' => 1, 'cantidad_electores' => 240, 'activa' => true],
        ];

        DB::table('mesas')->insert($mesas);
    }
}
