<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Medicamento;


class MedicamentoSeeder extends Seeder
{
    public function run()
    {
        Medicamento::truncate();
        
        $categorias = Categoria::all();
        $medicamentos = [
            [
                'nombre' => 'Paracetamol',
                'descripcion' => 'Analgésico y antipirético',
                'presentacion' => 'Tabletas 500mg',
                'laboratorio' => 'Genérico',
                'stock' => 100,
                'stock_minimo' => 20,
                'precio_compra' => 5.50,
                'precio_venta' => 8.00,
                'fecha_caducidad' => now()->addYears(2),
                'lote' => 'LOT-2023-001',
                'requiere_receta' => false,
            ],
            // Agrega más medicamentos según sea necesario
        ];

        foreach ($medicamentos as $medicamento) {
            $medicamento['categoria_id'] = $categorias->random()->id;
            $medicamento['codigo'] = 'MED-' . strtoupper(substr(md5(uniqid()), 0, 6));
            Medicamento::create($medicamento);
        }
        
        // Opcional: crear medicamentos aleatorios con factory
        
    }
}