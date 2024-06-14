<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotasCreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($x = 0; $x <= 20; $x++) {

            DB::table('notas_credito')->insert([
                [
                    'Archivo' => Str::random(10),
                    'FechaEmision' => date('Y-m-d'),
                    'Establecimiento' => Str::random(10),
                    'PuntoEmision' => Str::random(10),
                    'Secuencial' => Str::random(10),
                    'RazonSocial' => Str::random(10),
                    'Total' => 50,
                    'created_at' =>  Carbon::now()->toDateTimeString(),
                    'updated_at' =>  Carbon::now()->toDateTimeString(),

                ]
            ]);
        }
    }
}
