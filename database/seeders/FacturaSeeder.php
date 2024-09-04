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

        for ($x = 1; $x <= 1000; $x++) {
            DB::table('facturas')->insert([
                [
                    'id_factura' => $idFacturaIncremental,
                    'Archivos' => "[]",
                    'Prefijo' => Str::random(5),
                    'FechaEmision' => $this->generarFechaAleatoria('2001-01-01', '2024-07-29'),
                    'establecimiento_id' => rand(1, 2),
                    'punto_emision_id' => rand(1, 4),
                    'RetencionIva' => 0,
                    'RetencionFuente' => 0,
                    'Secuencial' => Str::random(9),
                    'RazonSocial' => Str::random(10),
                    'Total' => rand(1, 1000),
                    'Estado' =>   rand(1, 4),
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ]);

            $idFacturaIncremental++;
        }
    }

    function generarFechaAleatoria($inicio, $fin)
    {
        $inicioTimestamp = strtotime($inicio);
        $finTimestamp = strtotime($fin);

        $fechaAleatoriaTimestamp = rand($inicioTimestamp, $finTimestamp);

        return date('Y-m-d', $fechaAleatoriaTimestamp);
    }
}
