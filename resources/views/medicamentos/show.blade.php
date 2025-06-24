@extends('layouts.app')

@section('title', 'Detalle de Medicamento')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 bg-gray-50 border-b flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold flex items-center">
                    <i class="fas fa-pills mr-2"></i> Detalle de Medicamento
                </h2>
                <p class="text-sm text-gray-600 mt-1">Código: {{ $medicamento->codigo }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('medicamentos.edit', $medicamento->id) }}" 
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
                <a href="{{ route('medicamentos.index') }}" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Columna Izquierda - Imagen e Info Básica -->
            <div class="md:col-span-1">
                <div class="bg-gray-50 p-4 rounded-lg border">
                    <div class="flex justify-center mb-4">
                        <img src="{{asset('storage/'.$medicamento->imagen)}}" alt="{{ $medicamento->nombre }}" 
                            class="h-48 w-48 object-contain rounded-lg border">
                            
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <h3 class="font-medium text-gray-700">Nombre Comercial</h3>
                            <p class="text-lg font-semibold">{{ $medicamento->nombre }}</p>
                        </div>
                        
                        <div>
                            <h3 class="font-medium text-gray-700">Presentación</h3>
                            <p>{{ $medicamento->presentacion }}</p>
                        </div>
                        
                        <div>
                            <h3 class="font-medium text-gray-700">Laboratorio</h3>
                            <p>{{ $medicamento->laboratorio }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Columna Central - Stock y Precios -->
            <div class="md:col-span-1">
                <div class="bg-gray-50 p-4 rounded-lg border h-full">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-boxes mr-2"></i> Inventario
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-medium">Stock Actual</span>
                                <span class="font-bold {{ $medicamento->stock <= $medicamento->stock_minimo ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $medicamento->stock }} unidades
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-{{ $medicamento->stock <= $medicamento->stock_minimo ? 'red' : 'green' }}-600 h-2.5 rounded-full" 
                                    style="width: {{ min(100, ($medicamento->stock / ($medicamento->stock_minimo + 10)) * 100) }}%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">Stock mínimo: {{ $medicamento->stock_minimo }} unidades</div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white p-3 rounded-lg border">
                                <h4 class="text-sm font-medium text-gray-500">Precio Compra</h4>
                                <p class="text-lg font-semibold">${{ number_format($medicamento->precio_compra, 2) }}</p>
                            </div>
                            <div class="bg-white p-3 rounded-lg border">
                                <h4 class="text-sm font-medium text-gray-500">Precio Venta</h4>
                                <p class="text-lg font-semibold">${{ number_format($medicamento->precio_venta, 2) }}</p>
                            </div>
                        </div>
                        
                        <div class="bg-white p-3 rounded-lg border">
                            <h4 class="text-sm font-medium text-gray-500">Margen de Ganancia</h4>
                            <p class="text-lg font-semibold">
                                ${{ number_format($medicamento->precio_venta - $medicamento->precio_compra, 2) }}
                                <span class="text-sm text-green-600">
                                    ({{ number_format((($medicamento->precio_venta - $medicamento->precio_compra) / $medicamento->precio_compra * 100), 2) }}%)
                                </span>
                            </p>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-700">Lote</h4>
                            <p>{{ $medicamento->lote }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Columna Derecha - Caducidad y Ventas -->
            <div class="md:col-span-1">
                <div class="bg-gray-50 p-4 rounded-lg border h-full">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i> Caducidad
                    </h3>
                    
                    @php
                        $diasParaCaducar = now()->diffInDays($medicamento->fecha_caducidad, false);
                    @endphp
                    
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium">Fecha de Caducidad</span>
                            <span class="font-bold {{ $diasParaCaducar <= 0 ? 'text-red-600' : ($diasParaCaducar <= 30 ? 'text-orange-600' : 'text-green-600') }}">
                                {{ $medicamento->fecha_caducidad->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="text-sm {{ $diasParaCaducar <= 0 ? 'text-red-600' : ($diasParaCaducar <= 30 ? 'text-orange-600' : 'text-green-600') }}">
                            @if($diasParaCaducar <= 0)
                                <i class="fas fa-exclamation-triangle mr-1"></i> Caducado hace {{ abs($diasParaCaducar) }} días
                            @else
                                <i class="fas fa-clock mr-1"></i> Caduca en {{ $diasParaCaducar }} días
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-700">Requiere Receta</h4>
                        <p>
                            @if($medicamento->requiere_receta)
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm">
                                    <i class="fas fa-check-circle mr-1"></i> Sí
                                </span>
                            @else
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">
                                    <i class="fas fa-times-circle mr-1"></i> No
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h4 class="font-medium text-gray-700">Descripción</h4>
                        <p class="text-gray-700">{{ $medicamento->descripcion ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-700">Registro</h4>
                        <p class="text-sm text-gray-500">
                            Creado: {{ $medicamento->created_at->format('d/m/Y H:i') }}<br>
                            Actualizado: {{ $medicamento->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pestañas para Historial -->
        <div class="border-t">
            <div class="px-6">
                <nav class="flex space-x-4" aria-label="Tabs">
                    <button x-data="{ tab: 'ventas' }" @click="tab = 'ventas'" 
                        :class="{ 'border-blue-500 text-blue-600': tab === 'ventas', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'ventas' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Historial de Ventas
                    </button>
                    <button x-data="{ tab: 'ventas' }" @click="tab = 'alertas'" 
                        :class="{ 'border-blue-500 text-blue-600': tab === 'alertas', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'alertas' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Alertas Generadas
                    </button>
                </nav>
            </div>
            <div class="px-6 py-4">
                <!-- Contenido de pestañas -->
                <div x-data="{ tab: 'ventas' }">
                    <!-- Pestaña de Ventas -->
                    <div x-show="tab === 'ventas'">
                        @if($ventas->isEmpty())
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-shopping-cart text-3xl mb-2"></i>
                                <p>No hay registros de ventas para este medicamento</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Venta</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($ventas as $venta)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $venta->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('ventas.show', $venta->venta_id) }}" class="text-blue-600 hover:underline">
                                                    {{ $venta->venta->codigo }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $venta->cantidad }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                ${{ number_format($venta->precio_unitario, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                ${{ number_format($venta->subtotal, 2) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $ventas->links() }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Pestaña de Alertas -->
                    <div x-show="tab === 'alertas'" x-cloak>
                        @if($alertas->isEmpty())
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-bell-slash text-3xl mb-2"></i>
                                <p>No hay alertas generadas para este medicamento</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($alertas as $alerta)
                                <div class="bg-white p-4 rounded-lg border {{ $alerta->resuelta ? 'border-gray-200' : ($alerta->tipo === 'caducidad' ? 'border-orange-200 bg-orange-50' : 'border-red-200 bg-red-50') }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium flex items-center">
                                                @if($alerta->tipo === 'caducidad')
                                                    <i class="fas fa-calendar-times text-orange-500 mr-2"></i>
                                                    Alerta de Caducidad
                                                @else
                                                    <i class="fas fa-box-open text-red-500 mr-2"></i>
                                                    Alerta de Stock
                                                @endif
                                            </h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ $alerta->observaciones }}</p>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $alerta->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="mt-2 flex justify-between items-center">
                                        <span class="text-xs px-2 py-1 rounded-full 
                                            {{ $alerta->resuelta ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $alerta->resuelta ? 'Resuelta' : 'Pendiente' }}
                                        </span>
                                        @if(!$alerta->resuelta)
                                        <form action="{{ route('alertas.resolve', $alerta->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded hover:bg-blue-200">
                                                Marcar como resuelta
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                {{ $alertas->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection