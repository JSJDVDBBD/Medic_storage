<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'codigo' => ['required', 'unique:ventas'],
            'subtotal' => ['required', 'numeric'],
            'impuesto' => ['required', 'numeric'],
            'descuento' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
            'metodo_pago' => ['required', 'string'],
            'estado' => ['nullable', 'string'],
            'observaciones' => ['nullable', 'string'],
            'productos' => ['required', 'array'],
            'productos.*.medicamento_id' => ['required', 'exists:medicamentos,id'],
            'productos.*.cantidad' => ['required', 'integer', 'min:1'],
            'productos.*.precio_unitario' => ['required', 'numeric', 'min:0'],
            'productos.*.subtotal' => ['required', 'numeric', 'min:0'],
            'productos.*.descuento' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
