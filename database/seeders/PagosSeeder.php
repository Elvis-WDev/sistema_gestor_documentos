<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $facturas = DB::table('facturas')->pluck('id_factura')->toArray();

        foreach ($facturas as $idFactura) {
            // Controla la inserción de un solo pago por factura para evitar duplicación
            DB::table('pagos')->insert([
                [
                    'id_factura' => $idFactura,
                    'Archivo' => Str::random(10),
                    'Total' => 50,
                    'TransaccionVenta' => Str::random(10),
                    'Fecha' => Carbon::now()->toDateTimeString(),
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]
            ]);
        }
    }
}
