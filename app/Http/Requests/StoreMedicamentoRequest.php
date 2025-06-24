<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreMedicamentoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'presentacion' => 'required|string|max:100',
            'laboratorio' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'fecha_caducidad' => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    if (!Carbon::hasFormat($value, 'Y-m-d')) {
                        $fail('El formato de fecha debe ser YYYY-MM-DD.');
                    }
                },
            ],
            'lote' => 'required|string|max:50',
            'requiere_receta' => 'boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'fecha_caducidad.after_or_equal' => 'La fecha de caducidad debe ser igual o posterior a hoy.',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->has('fecha_caducidad')) {
            $this->merge([
                'fecha_caducidad' => Carbon::parse($this->fecha_caducidad)->format('Y-m-d'),
            ]);
        }
    }
}