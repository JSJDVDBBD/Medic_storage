<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\CorteCaja;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\DetalleVenta;
use Illuminate\Support\Facades\Auth;

class CorteCajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cortes = CorteCaja::with('user')->latest()->get();
        return view('corte-caja.index', compact('cortes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ventasHoy = Venta::whereDate('fecha_venta', today())->get();

        $totalEfectivo = $ventasHoy->filter(function ($venta) {
            return strtolower($venta->metodo_pago) === 'efectivo';
        })->sum('total');
        $totalTransferencia = $ventasHoy->filter(function ($venta) {
            return strtolower($venta->metodo_pago) === 'transferencia';
        })->sum('total');
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
            'efectivo_inicial' => 'required|numeric|min:0',
            'efectivo_final' => 'required|numeric|min:0',
            'ventas_efectivo' => 'required|numeric|min:0',
            'ventas_transferencia' => 'required|numeric|min:0',
            'ventas_tarjeta' => 'required|numeric|min:0',
            'total_ventas' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);

        // Cálculo del total esperado
        $totalEsperado = $request->efectivo_inicial
            + $request->ventas_efectivo
            + $request->ventas_tarjeta
            + $request->ventas_transferencia;

        // Cálculo de diferencia
        $diferencia = $request->efectivo_final - $totalEsperado;

        CorteCaja::create([
            'user_id' => Auth::user()->id,
            'fecha' => today(),
            'efectivo_inicial' => $request->efectivo_inicial,
            'efectivo_final' => $request->efectivo_final,
            'ventas_efectivo' => $request->ventas_efectivo,
            'ventas_tarjeta' => $request->ventas_tarjeta,
            'ventas_transferencia' => $request->ventas_transferencia,
            'total_ventas' => $request->total_ventas,
            'total_esperado' => $totalEsperado,
            'diferencia' => $diferencia,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('corte-caja.index')
            ->with('success', 'Corte de caja registrado correctamente.');
    }
}
