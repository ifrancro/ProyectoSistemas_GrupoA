<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * ⚠️⚠️⚠️ SEEDER OBSOLETO - NO USAR ⚠️⚠️⚠️
 * 
 * Este seeder usa nombres de columnas antiguos (id_departamento, id_provincia, etc.)
 * y tabla 'usuarios' que ya no existe.
 * 
 * USA EN SU LUGAR:
 * - GeografiaSeeder.php (para geografía)
 * - ProyectoElectoralSeeder.php (para personas, partidos, instituciones)
 * 
 * Este archivo se mantiene solo como referencia.
 * NO ejecutarlo con php artisan db:seed
 */
class EleccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @deprecated Usar GeografiaSeeder y ProyectoElectoralSeeder en su lugar
     */
    public function run(): void
    {
        throw new \Exception(
            '❌ EleccionesSeeder está OBSOLETO.\n' .
            'Usa GeografiaSeeder y ProyectoElectoralSeeder en su lugar.\n' .
            'Ver README_SEEDERS.md para más información.'
        );
    }
}
