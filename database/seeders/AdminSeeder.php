<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'Rol' => 1,
            ],
            [
                'Rol' => 2,
            ],
            [
                'Rol' => 3,
            ],
        ]);

        DB::table('permisos')->insert([
            [
                'id_rol' => 1,
                'Permiso_facturas' => '[]',
                'Permiso_pagos' => '[]',
                'Permiso_NotasCredito' => '[]',
                'Permiso_CartasAfiliacion' => '[]',
                'Permiso_Retenciones' => '[]',
            ],
            [
                'id_rol' => 2,
                'Permiso_facturas' => '[]',
                'Permiso_pagos' => '[]',
                'Permiso_NotasCredito' => '[]',
                'Permiso_CartasAfiliacion' => '[]',
                'Permiso_Retenciones' => '[]',
            ],
            [
                'id_rol' => 3,
                'Permiso_facturas' => '[]',
                'Permiso_pagos' => '[]',
                'Permiso_NotasCredito' => '[]',
                'Permiso_CartasAfiliacion' => '[]',
                'Permiso_Retenciones' => '[]',
            ],
        ]);

        DB::table('users')->insert([
            [
                'NombreUsuario' => 'SuperAdmin',
                'email' => 'super@gmail.com',
                'password' => bcrypt('password'),
                'id_rol' => 1,
            ],
        ]);
    }
}
