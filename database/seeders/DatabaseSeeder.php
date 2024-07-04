<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RolesPermisosSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ConfiguracionesGeneralesSeeder::class);
        $this->call([
            FacturaSeeder::class,
            PagosSeeder::class,
        ]);
        $this->call(SolicitudAfiliadoSeeder::class);
        $this->call(NotasCreditoSeeder::class);
        $this->call(RetencionesSeeder::class);

        Storage::disk('public')->deleteDirectory('uploads');
    }
}