<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Control de asistencia de jurados - Proyecto Electoral
     */
    public function up(): void
    {
        Schema::create('asistencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurado_id')->constrained('jurados')->onDelete('cascade');
            $table->foreignId('mesa_id')->constrained('mesas')->onDelete('cascade');
            $table->enum('estado', ['PRESENTE', 'AUSENTE'])->default('AUSENTE');
            $table->timestamp('registrado_en')->useCurrent();
            
            $table->index('jurado_id');
            $table->index('mesa_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia');
    }
};
