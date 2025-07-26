<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\CorteCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CorteCajaController extends Controller
{
    public function index()
    {
        $cortes = CorteCaja::with('user')
            ->latest()
            ->paginate(10);
            
        return view('corte-caja.index', compact('cortes'));
    }

    public function create()
    {
        $ventasHoy = Venta::whereDate('fecha_venta', today())->get();

        return view('corte-caja.create', [
            'totalEfectivo' => $ventasHoy->filter(fn ($v) => strtolower($v->metodo_pago) === 'efectivo')->sum('total'),
            'totalTransferencia' => $ventasHoy->filter(fn ($v) => strtolower($v->metodo_pago) === 'transferencia')->sum('total'),
            'totalTarjeta' => $ventasHoy->filter(fn ($v) => strtolower($v->metodo_pago) === 'tarjeta')->sum('total'),
            'totalVentas' => $ventasHoy->sum('total')
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'efectivo_inicial' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);

        $efectivo_final = $request->efectivo_inicial + $request->ventas_efectivo;

        CorteCaja::create([
            'user_id' => Auth::id(),
            'fecha' => today(),
            'efectivo_inicial' => $request->efectivo_inicial,
            'efectivo_final' => $efectivo_final,
            'ventas_efectivo' => $request->ventas_efectivo,
            'ventas_tarjeta' => $request->ventas_tarjeta,
            'ventas_transferencia' => $request->ventas_transferencia,
            'total_ventas' => $request->total_ventas,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('corte-caja.index')
            ->with('success', 'Corte de caja registrado correctamente.');
    }
}