<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Medicamento;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear usuario admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@medicstorage.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // 2. Crear medicamentos sin factory
        $this->crearMedicamentos();

        // 3. Crear ventas sin factory
        $this->crearVentas();
    }

    protected function crearMedicamentos()
    {
        for ($i = 0; $i < 50; $i++) {
            Medicamento::create([
                'nombre' => 'Medicamento ' . ($i + 1),
                'descripcion' => 'Descripción del medicamento ' . ($i + 1),
                'presentacion' => ['Tabletas', 'Cápsulas', 'Jarabe'][rand(0, 2)],
                'laboratorio' => 'Lab ' . chr(rand(65, 90)) . chr(rand(65, 90)),
                'stock' => rand(0, 100),
                'stock_minimo' => 10,
                'precio_compra' => rand(100, 5000) / 100,
                'precio_venta' => rand(150, 6000) / 100,
                'fecha_caducidad' => Carbon::now()->addDays(rand(30, 365)),
                'lote' => 'LOTE-' . rand(10000, 99999),
                'requiere_receta' => rand(0, 1),
            ]);
        }
    }

    protected function crearVentas()
    {
        for ($i = 0; $i < 30; $i++) {
            $venta = Venta::create([
                'codigo' => 'V-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'user_id' => 1,
                'subtotal' => 0,
                'impuesto' => 0,
                'total' => 0,
                'metodo_pago' => ['efectivo', 'tarjeta', 'transferencia'][rand(0, 2)],
                'estado' => 'completada',
            ]);

            $medicamentos = Medicamento::inRandomOrder()
                ->limit(rand(1, 5))
                ->get();

            $subtotal = 0;

            foreach ($medicamentos as $medicamento) {
                $cantidad = rand(1, 5);
                $subtotal += $cantidad * $medicamento->precio_venta;

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'medicamento_id' => $medicamento->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $medicamento->precio_venta,
                    'subtotal' => $cantidad * $medicamento->precio_venta,
                ]);

                $medicamento->decrement('stock', $cantidad);
            }

            $venta->update([
                'subtotal' => $subtotal,
                'impuesto' => $subtotal * 0.16,
                'total' => $subtotal * 1.16
            ]);
        }
    }
}