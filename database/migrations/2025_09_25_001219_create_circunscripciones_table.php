<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('circunscripcions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipio_id')->constrained()->onDelete('cascade');
            $table->string('nombre', 100);
            $table->string('codigo', 10)->unique();
            $table->integer('numero_electores')->default(0);
            $table->boolean('activo')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('circunscripcions');
    }
};