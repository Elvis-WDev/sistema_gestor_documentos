<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(ConfiguracionesGeneralesSeeder::class);
        $this->call([
            FacturaSeeder::class,
            PagosSeeder::class,
        ]);
        $this->call(SolicitudAfiliadoSeeder::class);
        $this->call(NotasCreditoSeeder::class);
        $this->call(RetencionesSeeder::class);
    }
}