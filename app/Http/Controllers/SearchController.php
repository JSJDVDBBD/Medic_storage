<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function medicamentos(Request $request)
    {
        $query = $request->input('q');

        $medicamentos = Medicamento::where('nombre', 'LIKE', '%' . $query . '%')
            ->limit(10)
            ->get();

        return response()->json($medicamentos);
    }
}
