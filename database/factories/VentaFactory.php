<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\Factory;

class VentaFactory extends Factory
{
    protected $model = Venta::class;

    public function definition()
    {
        return [
            'codigo' => 'V-' . $this->faker->unique()->randomNumber(6),
            'user_id' => User::factory(),
            'subtotal' => $this->faker->randomFloat(2, 100, 1000),
            'impuesto' => $this->faker->randomFloat(2, 16, 160),
            'descuento' => $this->faker->randomFloat(2, 0, 50),
            'total' => $this->faker->randomFloat(2, 116, 1160),
            'metodo_pago' => $this->faker->randomElement(['efectivo', 'tarjeta', 'transferencia']),
            'estado' => 'completada',
            'observaciones' => $this->faker->optional()->sentence,
        ];
    }
}