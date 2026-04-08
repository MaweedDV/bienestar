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
            'name' => 'Manuel Gallardo',
            'rut' => '18935579-3',
             'id_cargo' => null,
             'id_area' => null,
             'id_departamento' => null,
             'telefono' => null,
             'id_calidadJuridica' => null,
            'email' => 'manuel.gallardo@puertomontt.cl',
            'role' => 'admin',
            'password' => bcrypt('obtcrew69'),
        ]);
    }
}
