<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Medicamento;
use Carbon\Carbon;
use App\Models\DetalleVenta;

class AlertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Alertas por caducidad (medicamentos que caducan en menos de 30 días)
        $alertasCaducidad = Medicamento::where('fecha_caducidad', '<=', 
            Carbon::now()->addDays(30))
            ->orderBy('fecha_caducidad')
            ->get();
        
        // Alertas por stock bajo (medicamentos con menos de 10 unidades)
        $alertasStock = Medicamento::where('stock', '<', 10)
            ->orderBy('stock')
            ->get();
        
        return view('alertas.index', compact('alertasCaducidad', 'alertasStock'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
