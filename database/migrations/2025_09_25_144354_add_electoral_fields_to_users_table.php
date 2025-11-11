<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // username
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('name');
            }

            // rol / cargo / activo
            if (!Schema::hasColumn('users', 'rol')) {
                $table->string('rol')->default('user')->after('username');
            }
            if (!Schema::hasColumn('users', 'cargo')) {
                $table->string('cargo')->nullable()->after('rol');
            }
            if (!Schema::hasColumn('users', 'activo')) {
                $table->boolean('activo')->default(true)->after('cargo');
            }

            // relaciones (sin FK por ahora)
            if (!Schema::hasColumn('users', 'mesa_id')) {
                $table->unsignedBigInteger('mesa_id')->nullable()->after('activo');
            }
            if (!Schema::hasColumn('users', 'circunscripcion_id')) {
                $table->unsignedBigInteger('circunscripcion_id')->nullable()->after('mesa_id');
            }

            // remember_token
            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'circunscripcion_id')) $table->dropColumn('circunscripcion_id');
            if (Schema::hasColumn('users', 'mesa_id'))            $table->dropColumn('mesa_id');
            if (Schema::hasColumn('users', 'activo'))             $table->dropColumn('activo');
            if (Schema::hasColumn('users', 'cargo'))              $table->dropColumn('cargo');
            if (Schema::hasColumn('users', 'rol'))                $table->dropColumn('rol');
            if (Schema::hasColumn('users', 'remember_token'))     $table->dropColumn('remember_token');
            if (Schema::hasColumn('users', 'username'))           $table->dropColumn('username');
        });
    }
};
