<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfiguracionesGeneralesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('config_generales')->insert([
            [
                'nombre' => 'General',
                'archivos_permitidos' => 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
                'cantidad_permitidos' => 4,
                'tamano_maximo_permitido' => 10,

            ]
        ]);
    }
}
