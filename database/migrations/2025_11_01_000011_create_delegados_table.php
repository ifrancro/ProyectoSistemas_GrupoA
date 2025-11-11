<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabla delegados de partidos políticos - Proyecto Electoral
     */
    public function up(): void
    {
        Schema::create('delegados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->foreignId('partido_id')->constrained('partidos')->onDelete('cascade');
            $table->foreignId('mesa_id')->nullable()->constrained('mesas')->onDelete('cascade');
            $table->boolean('habilitado')->default(true);
            
            // Un delegado único por persona/partido/mesa
            $table->unique(['persona_id', 'partido_id', 'mesa_id']);
            
            $table->index('persona_id');
            $table->index('partido_id');
            $table->index('mesa_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegados');
    }
};
