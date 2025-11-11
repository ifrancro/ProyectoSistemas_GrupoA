<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Modifica tabla recintos para soportar AMBOS niveles:
     * - circunscripcion_id (Proyecto Votaciones)
     * - asiento_id (Proyecto Electoral)
     */
    public function up(): void
    {
        Schema::table('recintos', function (Blueprint $table) {
            // Hacer circunscripcion_id NULLABLE para permitir asiento_id
            $table->foreignId('circunscripcion_id')->nullable()->change();
            
            // Agregar soporte para asientos
            $table->foreignId('asiento_id')->nullable()->after('circunscripcion_id')
                ->constrained('asientos')->onDelete('cascade');
            
            // Al menos uno debe existir (verificación a nivel de aplicación)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recintos', function (Blueprint $table) {
            $table->dropForeign(['asiento_id']);
            $table->dropColumn('asiento_id');
            
            // Restaurar circunscripcion_id como NOT NULL
            $table->foreignId('circunscripcion_id')->nullable(false)->change();
        });
    }
};
