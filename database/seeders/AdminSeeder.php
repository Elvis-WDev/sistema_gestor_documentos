<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $superAdmin = User::create([

            'Nombres' => 'Andrea',
            'Apellidos' => 'Live',
            'NombreUsuario' => 'Super',
            'email' => 'super@gmail.com',
            'password' => bcrypt('password'),
            'url_img' => '',

        ]);

        // Asignar el rol SuperAdmin al usuario
        $superAdmin->assignRole('SuperAdmin');
    }
}
