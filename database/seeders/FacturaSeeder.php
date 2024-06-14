<?php

namespace Database\Seeders;

use App\Models\Factura;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FacturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $idFacturaIncremental = 1;

        for ($x = 1; $x <= 20; $x++) {
            DB::table('facturas')->insert([
                [
                    'id_factura' => $idFacturaIncremental,
                    'Archivo' => Str::random(10),
                    'FechaEmision' => date('Y-m-d'),
                    'Establecimiento' => Str::random(10),
                    'PuntoEmision' => Str::random(10),
                    'Secuencial' => Str::random(10),
                    'RazonSocial' => Str::random(10),
                    'Total' => 50,
                    'Estado' => 1,
                    'Abono' => 0.0,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ]);

            $idFacturaIncremental++;
        }
    }
}
