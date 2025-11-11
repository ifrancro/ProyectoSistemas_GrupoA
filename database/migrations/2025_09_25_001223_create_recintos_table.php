<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recintos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('circunscripcion_id')->constrained()->onDelete('cascade');
            $table->string('nombre', 100);
            $table->text('direccion');
            $table->string('codigo', 10)->unique();
            $table->boolean('activo')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recintos');
    }
};