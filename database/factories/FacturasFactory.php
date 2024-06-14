<?php

namespace Database\Factories;

use App\Models\Factura;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FacturasFactory extends Factory
{

    protected $model = Factura::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_factura' => Factura::factory(),
            'Archivo' => fake()->file(),
            'FechaEmision' => fake()->text(),
            'Establecimiento' => fake()->text(),
            'PuntoEmision' => fake()->text(),
            'Secuencial' => fake()->text(),
            'RazonSocial' => fake()->text(),
            'Total' => fake()->randomNumber(),
            'Estado' => 1,
            'Abono' => fake()->randomNumber(),
        ];
    }
}
