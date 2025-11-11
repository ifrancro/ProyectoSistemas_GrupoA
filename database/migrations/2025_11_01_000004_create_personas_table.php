<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabla personas - Proyecto Electoral
     */
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('ci', 20)->unique();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('correo', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->enum('estado', ['VIVO', 'FALLECIDO'])->default('VIVO');
            $table->string('foto_carnet', 255)->nullable();
            $table->timestamp('creado_en')->useCurrent();
            
            $table->index('ci');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
