<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PuntoEmisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('puntos_emision')->insert([
            [
                'establecimiento_id' => 1,
                'nombre' => '011',
                'created_at' =>  Carbon::now()->toDateTimeString(),
                'updated_at' =>  Carbon::now()->toDateTimeString(),
            ],
            [
                'establecimiento_id' => 1,
                'nombre' => '012',
                'created_at' =>  Carbon::now()->toDateTimeString(),
                'updated_at' =>  Carbon::now()->toDateTimeString(),
            ],
            [
                'establecimiento_id' => 1,
                'nombre' => '013',
                'created_at' =>  Carbon::now()->toDateTimeString(),
                'updated_at' =>  Carbon::now()->toDateTimeString(),
            ],
            [
                'establecimiento_id' => 1,
                'nombre' => '014',
                'created_at' =>  Carbon::now()->toDateTimeString(),
                'updated_at' =>  Carbon::now()->toDateTimeString(),
            ],
            [
                'establecimiento_id' => 2,
                'nombre' => '024',
                'created_at' =>  Carbon::now()->toDateTimeString(),
                'updated_at' =>  Carbon::now()->toDateTimeString(),
            ],
            [
                'establecimiento_id' => 2,
                'nombre' => '025',
                'created_at' =>  Carbon::now()->toDateTimeString(),
                'updated_at' =>  Carbon::now()->toDateTimeString(),
            ],
            [
                'establecimiento_id' => 2,
                'nombre' => '026',
                'created_at' =>  Carbon::now()->toDateTimeString(),
                'updated_at' =>  Carbon::now()->toDateTimeString(),
            ],
            [
                'establecimiento_id' => 2,
                'nombre' => '027',
                'created_at' =>  Carbon::now()->toDateTimeString(),
                'updated_at' =>  Carbon::now()->toDateTimeString(),
            ],
        ]);
    }
}