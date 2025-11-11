<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Unifica tabla users para ambos proyectos
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agregar email si no existe (para Proyecto Votaciones)
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->nullable()->unique()->after('name');
                $table->timestamp('email_verified_at')->nullable()->after('email');
            } else {
                // Si ya existe, hacerlo NULLABLE
                $table->string('email')->nullable()->change();
            }
            
            // Agregar campos del Proyecto Electoral (si no existen)
            if (!Schema::hasColumn('users', 'rol_electoral')) {
                $table->string('rol_electoral', 50)->nullable()
                    ->after('role')
                    ->comment('ADMIN, VOLUNTARIO - Para Proyecto Electoral');
            }
            
            if (!Schema::hasColumn('users', 'cargo')) {
                $table->string('cargo', 100)->nullable()->after('rol_electoral');
            }
            
            if (!Schema::hasColumn('users', 'activo')) {
                $table->boolean('activo')->default(true)->after('cargo');
            }
            
            // Relación con personas (Proyecto Electoral)
            if (!Schema::hasColumn('users', 'persona_id')) {
                $table->foreignId('persona_id')->nullable()
                    ->after('circunscripcion_id')
                    ->constrained('personas')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'persona_id')) {
                $table->dropForeign(['persona_id']);
                $table->dropColumn('persona_id');
            }
            
            $table->dropColumn(['rol_electoral', 'cargo', 'activo']);
            
            // Si email fue agregado por esta migración, eliminarlo
            // Si ya existía, dejarlo como estaba
            if (Schema::hasColumn('users', 'email')) {
                // No hacemos nada, dejamos el email
            }
        });
    }
};
