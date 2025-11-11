<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Sistema de Academia Electoral - Proyecto Electoral
     */
    public function up(): void
    {
        // Tabla principal de capacitaciones
        Schema::create('capacitaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->text('descripcion')->nullable();
            $table->string('rol_destino', 50)->comment('JURADO, VEEDOR, DELEGADO');
            $table->string('estado', 20)->default('ACTIVO')->comment('ACTIVO, INACTIVO');
            $table->integer('total_niveles')->default(3);
            $table->integer('puntaje_minimo')->default(90)->comment('Porcentaje mínimo para aprobar');
            $table->timestamps();
            
            $table->index('rol_destino');
            $table->index('estado');
        });

        // Niveles de cada capacitación
        Schema::create('capacitacion_niveles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capacitacion_id')->constrained('capacitaciones')->onDelete('cascade');
            $table->integer('numero_nivel');
            $table->string('titulo', 255);
            $table->text('contenido');
            $table->string('tipo_contenido', 50)->default('TEXTO')->comment('TEXTO, VIDEO, PDF, IMAGEN');
            $table->string('archivo_url', 500)->nullable();
            $table->integer('duracion_minutos')->nullable();
            $table->boolean('requiere_completar')->default(true);
            $table->timestamps();
            
            $table->index(['capacitacion_id', 'numero_nivel']);
        });

        // Progreso de capacitación por persona
        Schema::create('progreso_capacitaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->foreignId('capacitacion_id')->constrained('capacitaciones')->onDelete('cascade');
            $table->integer('nivel_actual')->default(1);
            $table->boolean('completado')->default(false);
            $table->integer('puntaje_quiz')->nullable();
            $table->boolean('aprobado')->default(false);
            $table->timestamp('fecha_inicio')->useCurrent();
            $table->timestamp('fecha_completado')->nullable();
            $table->timestamps();
            
            $table->unique(['persona_id', 'capacitacion_id']);
            $table->index(['persona_id', 'capacitacion_id']);
            $table->index('completado');
            $table->index('aprobado');
        });

        // Preguntas de quiz
        Schema::create('quiz_preguntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capacitacion_id')->constrained('capacitaciones')->onDelete('cascade');
            $table->text('pregunta');
            $table->string('tipo', 20)->default('MULTIPLE')->comment('MULTIPLE, VERDADERO_FALSO');
            $table->integer('puntos')->default(1);
            $table->boolean('activa')->default(true);
            $table->timestamps();
            
            $table->index(['capacitacion_id', 'activa']);
        });

        // Respuestas de quiz
        Schema::create('quiz_respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregunta_id')->constrained('quiz_preguntas')->onDelete('cascade');
            $table->text('opcion');
            $table->boolean('es_correcta')->default(false);
            $table->integer('orden')->default(1);
            $table->timestamps();
            
            $table->index(['pregunta_id', 'orden']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_respuestas');
        Schema::dropIfExists('quiz_preguntas');
        Schema::dropIfExists('progreso_capacitaciones');
        Schema::dropIfExists('capacitacion_niveles');
        Schema::dropIfExists('capacitaciones');
    }
};
