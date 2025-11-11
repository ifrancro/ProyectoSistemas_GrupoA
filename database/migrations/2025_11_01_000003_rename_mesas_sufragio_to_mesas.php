<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Renombra mesas_sufragio a mesas para unificación
     */
    public function up(): void
    {
        // Renombrar la tabla
        Schema::rename('mesas_sufragio', 'mesas');
        
        // Renombrar columnas para consistencia
        Schema::table('mesas', function ($table) {
            // Si numero_mesa no existe, renombrar de numero a numero_mesa
            if (Schema::hasColumn('mesas', 'numero') && !Schema::hasColumn('mesas', 'numero_mesa')) {
                DB::statement('ALTER TABLE mesas CHANGE numero numero_mesa INT NOT NULL');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mesas', function ($table) {
            if (Schema::hasColumn('mesas', 'numero_mesa')) {
                DB::statement('ALTER TABLE mesas CHANGE numero_mesa numero INT NOT NULL');
            }
        });
        
        Schema::rename('mesas', 'mesas_sufragio');
    }
};
