<!-- resources/views/alertas/index.blade.php -->
@extends('layouts.app')

@section('title', 'Alertas')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">Alertas</h1>

    <!-- Alertas por caducidad -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="bg-orange-500 text-white px-6 py-3">
            <h2 class="text-lg font-semibold">Medicamentos próximos a caducar</h2>
        </div>
        <div class="p-6">
            @if($alertasCaducidad->isEmpty())
                <p class="text-gray-500">No hay medicamentos próximos a caducar.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Días para caducar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Caducidad</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($alertasCaducidad as $medicamento)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $medicamento->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 rounded-full 
                                    @if($medicamento->fecha_caducidad->diffInDays(now()) <= 7) bg-red-100 text-red-800
                                    @elseif($medicamento->fecha_caducidad->diffInDays(now()) <= 15) bg-orange-100 text-orange-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $medicamento->fecha_caducidad->diffInDays(now()) }} días
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $medicamento->fecha_caducidad->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Alertas por stock bajo -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-red-500 text-white px-6 py-3">
            <h2 class="text-lg font-semibold">Medicamentos con stock bajo</h2>
        </div>
        <div class="p-6">
            @if($alertasStock->isEmpty())
                <p class="text-gray-500">No hay medicamentos con stock bajo.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock actual</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($alertasStock as $medicamento)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $medicamento->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 rounded-full bg-red-100 text-red-800">
                                    {{ $medicamento->cantidad }} unidades
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('medicamentos.edit', $medicamento->id) }}" class="text-blue-600 hover:text-blue-900">
                                    Reabastecer
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection