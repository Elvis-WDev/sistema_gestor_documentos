<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SolicitudAfiliadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($x = 0; $x <= 20; $x++) {

            DB::table('solicitud_afiliados')->insert([
                [
                    'Archivo' => Str::random(10),
                    'Prefijo' => Str::random(5, 20),
                    'NombreCliente' => Str::random(10),
                    'created_at' =>  Carbon::now()->toDateTimeString(),
                    'updated_at' =>  Carbon::now()->toDateTimeString(),

                ]
            ]);
        }
    }
}
