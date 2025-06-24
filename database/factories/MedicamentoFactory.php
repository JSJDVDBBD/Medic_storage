<?php

namespace Database\Factories;

use App\Models\Medicamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicamentoFactory extends Factory
{
    protected $model = Medicamento::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->word,
            'descripcion' => $this->faker->sentence,
            'presentacion' => $this->faker->randomElement(['Tabletas', 'Cápsulas', 'Jarabe', 'Inyectable', 'Crema']),
            'laboratorio' => $this->faker->company,
            'stock' => $this->faker->numberBetween(0, 100),
            'stock_minimo' => 10,
            'precio_compra' => $this->faker->randomFloat(2, 10, 500),
            'precio_venta' => $this->faker->randomFloat(2, 15, 600),
            'fecha_caducidad' => $this->faker->dateTimeBetween('now', '+2 years'),
            'lote' => 'LOTE-' . $this->faker->randomNumber(5),
            'requiere_receta' => $this->faker->boolean(20),
            'imagen' => null,
        ];
    }
}