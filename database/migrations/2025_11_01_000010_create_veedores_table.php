<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabla veedores (observadores electorales) - Proyecto Electoral
     */
    public function up(): void
    {
        Schema::create('veedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('cascade');
            $table->string('carta_respaldo', 255)->nullable();
            $table->enum('estado', ['PENDIENTE', 'APROBADO', 'RECHAZADO'])->default('PENDIENTE');
            $table->string('motivo_rechazo', 255)->nullable();
            
            $table->index('persona_id');
            $table->index('institucion_id');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veedores');
    }
};
