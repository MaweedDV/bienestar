<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nombre' => 'Manuel Jesus',
            'apellido_paterno' => 'Gallardo',
            'apellido_materno' => 'Pavez',
            'rut' => '18935579-3',
            'id_direccion' => 1,
             'id_area' => 1,
             'telefono' => '950664156',
             'id_calidadJuridica' => 1,
            'email' => 'manuel.gallardo@puertomontt.cl',
            'role' => 'admin',
            'password' => bcrypt('obtcrew69'),
            'estado' => 1,
        ]);
    }
}
