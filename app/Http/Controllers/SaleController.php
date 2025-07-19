<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Medicamento;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SaleRequest;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function create()
    {
        $medicamentos = Medicamento::all(); // Solo los disponibles si deseas
        return view('sales.create', compact('medicamentos'));
    }

    public function store(SaleRequest $request)
    {
        return $request->all();
        try {
            // Validar stock antes de la transacción
            foreach ($request->productos as $producto) {
                $medicamento = Medicamento::find($producto['medicamento_id']);
                if ($medicamento->stock < $producto['cantidad']) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors([
                            'stock' => "Stock insuficiente para el medicamento: {$medicamento->nombre} (disponible: {$medicamento->stock})"
                        ]);
                }
            }

            // Ejecutar todo dentro de una transacción segura
            DB::transaction(function () use ($request) {
                $sale = Venta::create([
                    'codigo' => $request->codigo,
                    'user_id' => Auth::user()->id,
                    'subtotal' => $request->subtotal,
                    'impuesto' => $request->impuesto,
                    'descuento' => $request->descuento ?? 0,
                    'total' => $request->total,
                    'metodo_pago' => $request->metodo_pago,
                    'estado' => $request->estado ?? 'completada',
                    'observaciones' => $request->observaciones,
                ]);

                foreach ($request->productos as $producto) {
                    $medicamento = Medicamento::find($producto['medicamento_id']);

                    DetalleVenta::create([
                        'venta_id' => $sale->id,
                        'medicamento_id' => $producto['medicamento_id'],
                        'cantidad' => $producto['cantidad'],
                        'precio_unitario' => $producto['precio_unitario'],
                        'subtotal' => $producto['subtotal'],
                        'descuento' => $producto['descuento'] ?? 0,
                    ]);

                    $medicamento->stock -= $producto['cantidad'];
                    $medicamento->save();
                }
            });

            return redirect()->route('ventas.create')->with('success', 'Venta registrada correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('ventas.create')
                ->with('error', 'Error al registrar la venta.');
        }
    }
}
