<!-- resources/views/corte-caja/index.blade.php -->
@extends('layouts.app')

@section('title', 'Corte de Caja')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Corte de Caja</h1>
        <a href="{{ route('corte-caja.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Nuevo Corte
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Efectivo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transferencia</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diferencia</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registrado por</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($cortes as $corte)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $corte->fecha->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($corte->ventas_efectivo, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($corte->ventas_transferencia, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($corte->total_ventas, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="{{ $corte->diferencia < 0 ? 'text-red-600' : 'text-green-600' }}">
                            ${{ number_format($corte->diferencia, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $corte->usuario->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection