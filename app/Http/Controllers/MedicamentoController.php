<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DetalleVenta;
use Carbon\Carbon;

class MedicamentoController extends Controller
{ 

    // En el método index
public function index(Request $request)
{
    $query = Medicamento::query()
        ->when($request->search, function($q) use ($request) {
            $q->where('nombre', 'like', "%{$request->search}%")
              ->orWhere('lote', 'like', "%{$request->search}%")
              ->orWhere('presentacion', 'like', "%{$request->search}%");
        })
        ->when($request->stock == 'bajo', function($q) {
            $q->whereColumn('stock', '<=', 'stock_minimo');
        })
        ->when($request->caducidad == 'proxima', function($q) {
            $q->where('fecha_caducidad', '<=', now()->addDays(30));
        })
        ->orderBy('nombre');

    $medicamentos = $query->paginate(15);

    return view('medicamentos.index', compact('medicamentos'));
}


    public function create()
    {
        return view('medicamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'presentacion' => 'required|string|max:100',
            'laboratorio' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'fecha_caducidad' => 'required|date',
            'lote' => 'required|string|max:50',
            'requiere_receta' => 'boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['fecha_caducidad'] = Carbon::parse($request->fecha_caducidad);

        $data = $request->except('imagen');
        
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('medicamentos', 'public');
        }

        $medicamento = Medicamento::create($data);
        $medicamento->generarAlertas();

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento creado correctamente.');
    }

    public function show(Medicamento $medicamento)
    {
        $ventas = $medicamento->detallesVenta()
            ->with('venta')
            ->orderByDesc('created_at')
            ->paginate(10);
            
        $alertas = $medicamento->alertas()
            ->orderByDesc('fecha_alerta')
            ->paginate(5);
            
        return view('medicamentos.show', compact('medicamento', 'ventas', 'alertas'));
    }

    public function edit(Medicamento $medicamento)
    {
        return view('medicamentos.edit', compact('medicamento'));
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'presentacion' => 'required|string|max:100',
            'laboratorio' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'fecha_caducidad' => 'required|date',
            'lote' => 'required|string|max:50',
            'requiere_receta' => 'boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('imagen');
        $data['fecha_caducidad'] = Carbon::parse($request->fecha_caducidad);
        
        if ($request->hasFile('imagen')) {
            if ($medicamento->imagen) {
                Storage::disk('public')->delete($medicamento->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('medicamentos', 'public');
        }

        $medicamento->update($data);
        $medicamento->generarAlertas();

        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento actualizado correctamente.');
    }

    public function destroy(Medicamento $medicamento)
    {
        if ($medicamento->detallesVenta()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el medicamento porque tiene ventas asociadas.');
        }
        
        if ($medicamento->imagen) {
            Storage::disk('public')->delete($medicamento->imagen);
        }
        
        $medicamento->delete();
        
        return redirect()->route('medicamentos.index')
            ->with('success', 'Medicamento eliminado correctamente.');
    }
}