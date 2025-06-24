<?php

// app/Http/Controllers/VentaController.php
namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Medicamento;
use App\Models\DetalleVenta;
use App\Http\Requests\StoreVentaRequest;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::with('usuario')
            ->orderByDesc('created_at');
            
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%$search%")
                  ->orWhere('total', 'like', "%$search%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
            });
        }
        
        if ($request->has('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }
        
        $ventas = $query->paginate(15);
        
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $medicamentos = Medicamento::where('stock', '>', 0)
            ->orderBy('nombre')
            ->get();
            
        return view('ventas.create', compact('medicamentos'));
    }

    public function store(StoreVentaRequest $request)
    {
        $venta = Venta::create([
            'codigo' => Venta::generarCodigo(),
            'user_id' => auth()->id(),
            'subtotal' => 0,
            'impuesto' => 0,
            'total' => 0,
            'metodo_pago' => $request->metodo_pago,
            'observaciones' => $request->observaciones
        ]);
        
        foreach ($request->medicamentos as $item) {
            $medicamento = Medicamento::find($item['id']);
            
            if ($medicamento && $medicamento->stock >= $item['cantidad']) {
                $venta->agregarDetalle(
                    $medicamento->id,
                    $item['cantidad'],
                    $medicamento->precio_venta,
                    $item['descuento'] ?? 0
                );
                
                // Actualizar stock
                $medicamento->decrement('stock', $item['cantidad']);
                
                // Verificar si el stock está bajo después de la venta
                $medicamento->generarAlertas();
            }
        }
        
        $venta->calcularTotales();
        
        return redirect()->route('ventas.show', $venta->id)
            ->with('success', 'Venta registrada correctamente.');
    }

    public function show(Venta $venta)
    {
        $venta->load(['detalles.medicamento', 'user']);
        return view('ventas.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
