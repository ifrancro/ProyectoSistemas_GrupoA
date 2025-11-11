<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name'   => 'Administrador',
                'password' => 'admin123',   // se hashea con el mutator setPasswordAttribute
                'mesa_id' => null,          // el admin no pertenece a mesa
                'circunscripcion_id' => null,
                'rol'    => 'admin',
                'cargo'  => 'Administrador General',
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
            // si ya tienes tabla mesas, coloca aquí el ID real; de lo contrario deja null
            $mesaId = null; // ej: MesaSufragio::where('numero', $i+1)->value('id') ?? null;
            $mesaNumber = $i + 1; // Asignar número de mesa del 1 al 16

            User::updateOrCreate(
                ['username' => $u['username']],
                [
                    'name'   => $u['name'],
                    'password' => '123456', // mutator lo hashea
                    'mesa_id' => $mesaId,
                    'mesa_number' => $mesaNumber,
                    'circunscripcion_id' => null,
                    'rol'    => 'mesa',     // o 'user' si así lo manejas
                    'cargo'  => 'Miembro de Mesa',
                    'activo' => true,
                ]
            );
        }
    }
}