<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstablecimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('establecimientos')->insert([
            [
                'nombre' => '001',
                'created_at' =>  Carbon::now()->toDateTimeString(),
                'updated_at' =>  Carbon::now()->toDateTimeString(),
            ],
            [
                'nombre' => '002',
                'created_at' =>  Carbon::now()->toDateTimeString(),
                'updated_at' =>  Carbon::now()->toDateTimeString(),
            ]
        ]);
    }
}
