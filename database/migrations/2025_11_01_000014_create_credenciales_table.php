<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Credenciales generadas (PDFs con QR) - Proyecto Electoral
     */
    public function up(): void
    {
        Schema::create('credenciales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->string('rol', 50)->comment('JURADO, VEEDOR, DELEGADO');
            $table->string('tipo', 50)->default('CREDENCIAL');
            $table->string('nombre_archivo', 255);
            $table->string('ruta_archivo', 500);
            $table->string('estado', 50)->default('GENERADO')->comment('GENERADO, DESCARGADO, EXPIRADO');
            $table->text('contenido_qr')->nullable();
            $table->timestamp('generado_en')->useCurrent();
            $table->timestamp('descargado_en')->nullable();
            $table->timestamp('expira_en')->nullable();
            
            $table->index(['persona_id', 'rol']);
            $table->index('estado');
            $table->index('generado_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credenciales');
    }
};
