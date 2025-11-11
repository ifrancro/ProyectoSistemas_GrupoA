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
            $table->integer('numero_mesa')->unique();
            $table->integer('cantidad_electores')->default(0);
            $table->string('presidente_nombre', 100)->nullable();
            $table->string('secretario_nombre', 100)->nullable();
            $table->boolean('activa')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mesas_sufragio');
    }
};