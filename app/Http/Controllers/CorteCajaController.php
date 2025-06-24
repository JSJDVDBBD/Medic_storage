<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\CorteCaja;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\DetalleVenta;

class CorteCajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $cortes = CorteCaja::with('usuario')->latest()->get();
        return view('corte-caja.index', compact('cortes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $ventasHoy = Venta::whereDate('fecha_venta', today())->get();
        
        $totalEfectivo = $ventasHoy->where('metodo_pago', 'efectivo')->sum('total');
        $totalTransferencia = $ventasHoy->where('metodo_pago', 'transferencia')->sum('total');
        $totalVentas = $ventasHoy->sum('total');
        
        return view('corte-caja.create', compact(
            'totalEfectivo',
            'totalTransferencia',
            'totalVentas'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
            'ventas_efectivo' => 'required|numeric|min:0',
            'ventas_transferencia' => 'required|numeric|min:0',
            'total_ventas' => 'required|numeric|min:0',
            'diferencia' => 'required|numeric',
            'observaciones' => 'nullable|string'
        ]);

        CorteCaja::create([
            'fecha' => today(),
            'ventas_efectivo' => $request->ventas_efectivo,
            'ventas_transferencia' => $request->ventas_transferencia,
            'total_ventas' => $request->total_ventas,
            'diferencia' => $request->diferencia,
            'observaciones' => $request->observaciones,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('corte-caja.index')
            ->with('success', 'Corte de caja registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
