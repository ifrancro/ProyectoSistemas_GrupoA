<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProyectoElectoralSeeder extends Seeder
{
    /**
     * Seeder para datos del Proyecto Electoral
     * Personas, Partidos, Instituciones, Jurados, Veedores, Delegados
     */
    public function run(): void
    {
        // ========================================
        // 1. PARTIDOS POLÍTICOS
        // ========================================
        $partidos = [
            ['sigla' => 'MAS-IPSP', 'nombre' => 'Movimiento al Socialismo', 'estado' => 'ACTIVO', 'logo_url' => null],
            ['sigla' => 'CC', 'nombre' => 'Comunidad Ciudadana', 'estado' => 'ACTIVO', 'logo_url' => null],
            ['sigla' => 'CREEMOS', 'nombre' => 'Creemos', 'estado' => 'ACTIVO', 'logo_url' => null],
            ['sigla' => 'FPV', 'nombre' => 'Frente Para la Victoria', 'estado' => 'ACTIVO', 'logo_url' => null],
            ['sigla' => 'MTS', 'nombre' => 'Movimiento Tercer Sistema', 'estado' => 'ACTIVO', 'logo_url' => null],
        ];

        DB::table('partidos')->insert($partidos);

        // ========================================
        // 2. INSTITUCIONES OBSERVADORAS
        // ========================================
        $instituciones = [
            ['nombre' => 'Transparencia Ciudadana', 'sigla' => 'TC'],
            ['nombre' => 'Democracia Viva', 'sigla' => 'DV'],
            ['nombre' => 'Observatorio Electoral', 'sigla' => 'OE'],
            ['nombre' => 'Fundación Milenio', 'sigla' => 'FM'],
        ];

        DB::table('instituciones')->insert($instituciones);

        // ========================================
        // 3. PERSONAS
        // ========================================
        $personas = [
            [
                'ci' => '1234567',
                'nombre' => 'Juan Carlos',
                'apellido' => 'Pérez Mamani',
                'fecha_nacimiento' => '1990-05-15',
                'correo' => 'juan.perez@email.com',
                'telefono' => '70012345',
                'ciudad' => 'La Paz',
                'estado' => 'VIVO',
                'creado_en' => now()
            ],
            [
                'ci' => '7654321',
                'nombre' => 'María Elena',
                'apellido' => 'Gómez Quispe',
                'fecha_nacimiento' => '1985-08-22',
                'correo' => 'maria.gomez@email.com',
                'telefono' => '70054321',
                'ciudad' => 'Santa Cruz',
                'estado' => 'VIVO',
                'creado_en' => now()
            ],
            [
                'ci' => '9876543',
                'nombre' => 'Carlos Alberto',
                'apellido' => 'López Condori',
                'fecha_nacimiento' => '1992-12-10',
                'correo' => 'carlos.lopez@email.com',
                'telefono' => '70098765',
                'ciudad' => 'Cochabamba',
                'estado' => 'VIVO',
                'creado_en' => now()
            ],
            [
                'ci' => '4567890',
                'nombre' => 'Ana María',
                'apellido' => 'Rojas Choque',
                'fecha_nacimiento' => '1988-03-18',
                'correo' => 'ana.rojas@email.com',
                'telefono' => '70045678',
                'ciudad' => 'La Paz',
                'estado' => 'VIVO',
                'creado_en' => now()
            ],
            [
                'ci' => '3216549',
                'nombre' => 'Roberto',
                'apellido' => 'Vargas Flores',
                'fecha_nacimiento' => '1995-07-25',
                'correo' => 'roberto.vargas@email.com',
                'telefono' => '70032165',
                'ciudad' => 'Santa Cruz',
                'estado' => 'VIVO',
                'creado_en' => now()
            ],
        ];

        DB::table('personas')->insert($personas);

        // ========================================
        // 4. JURADOS (Sorteo simulado)
        // ========================================
        $jurados = [
            [
                'persona_id' => 1,
                'mesa_id' => 1,
                'cargo' => 'PRESIDENTE',
                'verificado' => true
            ],
            [
                'persona_id' => 2,
                'mesa_id' => 1,
                'cargo' => 'SECRETARIO',
                'verificado' => true
            ],
            [
                'persona_id' => 4,
                'mesa_id' => 1,
                'cargo' => 'VOCAL',
                'verificado' => false
            ],
            [
                'persona_id' => 3,
                'mesa_id' => 2,
                'cargo' => 'PRESIDENTE',
                'verificado' => true
            ],
        ];

        DB::table('jurados')->insert($jurados);

        // ========================================
        // 5. VEEDORES
        // ========================================
        $veedores = [
            [
                'persona_id' => 5,
                'institucion_id' => 1,
                'carta_respaldo' => 'cartas/carta_veedor_5.pdf',
                'estado' => 'APROBADO',
                'motivo_rechazo' => null
            ],
            [
                'persona_id' => 4,
                'institucion_id' => 2,
                'carta_respaldo' => 'cartas/carta_veedor_4.pdf',
                'estado' => 'PENDIENTE',
                'motivo_rechazo' => null
            ],
        ];

        DB::table('veedores')->insert($veedores);

        // ========================================
        // 6. DELEGADOS
        // ========================================
        $delegados = [
            [
                'persona_id' => 2,
                'partido_id' => 1,
                'mesa_id' => 1,
                'habilitado' => true
            ],
            [
                'persona_id' => 3,
                'partido_id' => 2,
                'mesa_id' => 2,
                'habilitado' => true
            ],
        ];

        DB::table('delegados')->insert($delegados);

        // ========================================
        // 7. ADMIN_USERS (opcional - para Proyecto Electoral)
        // ========================================
        DB::table('admin_users')->insert([
            'username' => 'admin.electoral',
            'password' => Hash::make('admin123'),
            'email' => 'admin@electoral.bo',
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
