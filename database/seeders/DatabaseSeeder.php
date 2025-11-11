<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeder principal - Base de Datos Unificada
     * Ejecuta los seeders en el orden correcto para ambos proyectos
     */
    public function run(): void
    {
        $this->command->info('🌱 Sembrando Base de Datos Unificada...');
        
        // 1. Datos Geográficos (COMPARTIDOS - Ejecutar primero)
        $this->command->info('📍 Sembrando geografía...');
        $this->call(GeografiaSeeder::class);
        
        // 2. Datos del Proyecto Electoral
        $this->command->info('🗳️  Sembrando datos del Proyecto Electoral...');
        $this->call(ProyectoElectoralSeeder::class);
        
        // 3. Usuarios del Sistema (Proyecto Votaciones)
        $this->command->info('👥 Sembrando usuarios...');
        $this->call(UserSeeder::class);
        
        // 4. Elecciones y Candidatos (Proyecto Votaciones)
        $this->command->info('📊 Sembrando elecciones...');
        $this->call(ElectionSeeder::class);
        
        // 5. Academia Electoral (Proyecto Electoral) - DESACTIVADO TEMPORALMENTE
        // $this->command->info('🎓 Sembrando academia electoral...');
        // $this->call(AcademiaSeeder::class);
        $this->command->warn('⚠️  AcademiaSeeder desactivado (requiere corrección de nombres de columnas)');
        
        $this->command->info('✅ Base de datos sembrada correctamente!');
    }
}
