<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PuntoVenta;
use App\Models\User;

class PuntoVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $puntosVentas = PuntoVenta::paginate(10);
        return view('puntos_ventas.index', compact('puntosVentas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('puntos_ventas.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>['required', 'string'],
            'direccion'=>['required', 'string'],
            'telefono'=>['required', 'string'],
            'user_id'=>['required', 'exists:users,id'],
        ]);

        PuntoVenta::create($request->all());

        return redirect()->route('punto-venta.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PuntoVenta $puntoVenta)
    {
        $users = User::all();
        return view('puntos_ventas.edit', compact('puntoVenta', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PuntoVenta $puntoVenta) {
        $request->validate([
            'nombre'=>['required', 'string'],
            'direccion'=>['required', 'string'],
            'telefono'=>['required', 'string'],
            'user_id'=>['required', 'exists:users,id'],
        ]);

        $puntoVenta->update($request->all());

        return redirect()->route('punto-venta.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PuntoVenta $puntoVenta)
    {
        $puntoVenta->delete();
        return view('puntos_ventas.index');
    }
}
