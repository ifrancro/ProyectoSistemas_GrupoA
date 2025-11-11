<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mesas_sufragio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recinto_id')->constrained()->onDelete('cascade');
            $table->integer('numero_mesa');
            $table->integer('cantidad_electores')->default(0);
            $table->string('presidente_nombre', 100)->nullable();
            $table->string('secretario_nombre', 100)->nullable();
            $table->boolean('activa')->default(true);
            
            // UNIQUE por recinto: Cada recinto puede tener su propia mesa #1, #2, etc.
            $table->unique(['recinto_id', 'numero_mesa']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mesas_sufragio');
    }
};