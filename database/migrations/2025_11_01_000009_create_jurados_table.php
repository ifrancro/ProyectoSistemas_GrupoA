<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabla jurados de mesa - Proyecto Electoral
     */
    public function up(): void
    {
        Schema::create('jurados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->foreignId('mesa_id')->constrained('mesas')->onDelete('cascade');
            $table->enum('cargo', ['PRESIDENTE', 'SECRETARIO', 'VOCAL', 'SUPLENTE']);
            $table->boolean('verificado')->default(false);
            
            $table->index('persona_id');
            $table->index('mesa_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurados');
    }
};
