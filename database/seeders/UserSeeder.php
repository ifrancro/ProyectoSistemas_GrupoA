<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin - Usuario del Proyecto Votaciones
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name'   => 'Administrador Sistema Votaciones',
                'email'  => 'admin@votaciones.bo',
                'password' => Hash::make('admin123'),
                'mesa_id' => null,
                'circunscripcion_id' => null,
                'role'   => 'admin',        // Para Proyecto Votaciones
                'rol_electoral' => 'ADMIN',  // Para Proyecto Electoral
                'cargo'  => 'Administrador General',
                'is_active' => true,
                'activo' => true,
            ]
        );

        // Usuarios de mesas 1..16
        $users = [
            ['name' => 'Franco Avaro',        'username' => 'mesa001'],
            ['name' => 'Ian Romero',          'username' => 'mesa002'],
            ['name' => 'Kathleen Barrientos', 'username' => 'mesa003'],
            ['name' => 'Luis Mercado',        'username' => 'mesa004'],
            ['name' => 'Santiago Tardio',     'username' => 'mesa005'],
            ['name' => 'Rodrigo Eguez',       'username' => 'mesa006'],
            ['name' => 'Roberto Rodriguez',   'username' => 'mesa007'],
            ['name' => 'Didier Flores',       'username' => 'mesa008'],
            ['name' => 'Bruno Marco',         'username' => 'mesa009'],
            ['name' => 'Andres Flores',       'username' => 'mesa010'],
            ['name' => 'Said Bacotich',       'username' => 'mesa011'],
            ['name' => 'Danna Gomez',         'username' => 'mesa012'],
            ['name' => 'Santiago Camacho',    'username' => 'mesa013'],
            ['name' => 'Andre Romero',        'username' => 'mesa014'],
            ['name' => 'Santiago Rivero',     'username' => 'mesa015'],
            ['name' => 'Sergio Iporre',       'username' => 'mesa016'],
        ];

        foreach ($users as $i => $u) {
            $mesaNumber = $i + 1; // Asignar número de mesa del 1 al 16
            
            // Buscar la mesa por número (tabla unificada 'mesas')
            $mesaId = \DB::table('mesas')
                ->where('numero_mesa', $mesaNumber)
                ->value('id');

            User::updateOrCreate(
                ['username' => $u['username']],
                [
                    'name'   => $u['name'],
                    'email'  => strtolower($u['username']) . '@votaciones.bo',
                    'password' => Hash::make('123456'),
                    'mesa_id' => $mesaId,
                    'mesa_number' => $mesaNumber,
                    'circunscripcion_id' => null,
                    'role'   => 'user',          // Para Proyecto Votaciones
                    'rol_electoral' => 'VOLUNTARIO', // Para Proyecto Electoral
                    'cargo'  => 'Digitador de Mesa',
                    'is_active' => true,
                    'activo' => true,
                ]
            );
        }
    }
}