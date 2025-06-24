<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 flex items-center">
        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard - Medic Storage
    </h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Medicamentos -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-600">Total Medicamentos</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalMedicamentos }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $categoriasCount }} categorías</p>
                </div>
                <i class="fas fa-pills text-blue-500 text-3xl"></i>
            </div>
        </div>
        
        <!-- Próximos a Caducar -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-orange-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-600">Próximos a Caducar</h3>
                    <p class="text-3xl font-bold text-orange-600">{{ $productosProximosCaducar }}</p>
                    <p class="text-sm text-gray-500 mt-1">en los próximos 30 días</p>
                </div>
                <i class="fas fa-calendar-times text-orange-500 text-3xl"></i>
            </div>
        </div>
        
        <!-- Stock Bajo -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-600">Stock Bajo</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $productosStockBajo }}</p>
                    <p class="text-sm text-gray-500 mt-1">necesitan reabastecimiento</p>
                </div>
                <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
            </div>
        </div>
        
        <!-- Ventas Hoy -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-600">Ventas Hoy</h3>
                    <p class="text-3xl font-bold text-green-600">${{ number_format($ventasHoy, 2) }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $ventasCount }} transacciones</p>
                </div>
                <i class="fas fa-dollar-sign text-green-500 text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Ventas últimos 7 días -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <i class="fas fa-chart-line mr-2"></i> Ventas últimos 7 días
            </h3>
            <div class="h-64">
                <canvas id="ventasChart"></canvas>
            </div>
        </div>
        
        <!-- Métodos de Pago -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <i class="fas fa-credit-card mr-2"></i> Métodos de Pago (Últimos 7 días)
            </h3>
            <div class="h-64">
                <canvas id="metodosPagoChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Second Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top productos -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <i class="fas fa-star mr-2"></i> Top 5 productos más vendidos
            </h3>
            <div class="space-y-3">
                @foreach($topProductos as $producto)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            <img src="{{ $producto->medicamento->imagen_url }}" alt="{{ $producto->medicamento->nombre }}" 
                                class="h-10 w-10 rounded-full object-cover mr-3 border">
                            <span class="font-medium text-gray-700">{{ $producto->medicamento->nombre }}</span>
                        </div>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $producto->total_vendido }} unidades
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Productos próximos a caducar -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-semibold mb-4 flex items-center">
                <i class="fas fa-clock mr-2"></i> Productos próximos a caducar
            </h3>
            <div class="space-y-3">
                @foreach($proximosCaducar as $medicamento)
                    <div class="flex items-center justify-between p-3 bg-orange-50 rounded hover:bg-orange-100 transition-colors">
                        <div class="flex items-center">
                            <img src="{{ $medicamento->imagen_url }}" alt="{{ $medicamento->nombre }}" 
                                class="h-10 w-10 rounded-full object-cover mr-3 border">
                            <div>
                                <span class="font-medium text-gray-700">{{ $medicamento->nombre }}</span>
                                <p class="text-xs text-gray-500">{{ $medicamento->presentacion }}</p>
                            </div>
                        </div>
                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                            {{ $medicamento->fecha_caducidad->diffForHumans() }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Alertas recientes -->
    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
        <h3 class="text-lg font-semibold mb-4 flex items-center">
            <i class="fas fa-bell mr-2"></i> Alertas Recientes
            @if($alertasPendientesCount > 0)
                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                    {{ $alertasPendientesCount }} pendientes
                </span>
            @endif
        </h3>
        
        @if($alertasPendientes->isEmpty())
            <div class="text-center py-4 text-gray-500">
                <i class="fas fa-bell-slash text-3xl mb-2"></i>
                <p>No hay alertas pendientes</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicamento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detalle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($alertasPendientes as $alerta)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img src="{{ $alerta->medicamento->imagen_url }}" alt="{{ $alerta->medicamento->nombre }}" 
                                        class="h-10 w-10 rounded-full object-cover mr-3">
                                    <a href="{{ route('medicamentos.show', $alerta->medicamento_id) }}" class="text-blue-600 hover:underline">
                                        {{ $alerta->medicamento->nombre }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($alerta->tipo === 'caducidad')
                                    <span class="px-2 py-1 rounded-full bg-orange-100 text-orange-800 text-xs font-medium">
                                        <i class="fas fa-calendar-times mr-1"></i> Caducidad
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full bg-red-100 text-red-800 text-xs font-medium">
                                        <i class="fas fa-box-open mr-1"></i> Stock
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $alerta->observaciones }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $alerta->fecha_alerta }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <form action="{{ route('alertas.resolve', $alerta->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:text-green-900 flex items-center text-sm">
                                            <i class="fas fa-check-circle mr-1"></i> Resolver
                                        </button>
                                    </form>
                                    <a href="{{ route('medicamentos.edit', $alerta->medicamento_id) }}" class="text-blue-600 hover:text-blue-900 flex items-center text-sm">
                                        <i class="fas fa-edit mr-1"></i> Editar
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 flex justify-between items-center">
                <a href="{{ route('alertas.index') }}" class="text-blue-600 hover:underline flex items-center">
                    <i class="fas fa-list mr-1"></i> Ver todas las alertas
                </a>
                <span class="text-sm text-gray-500">
                    Mostrando {{ $alertasPendientes->count() }} de {{ $alertasPendientesCount }} alertas pendientes
                </span>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Ventas últimos 7 días chart
    const ventasCtx = document.getElementById('ventasChart').getContext('2d');
    const ventasChart = new Chart(ventasCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($ventasUltimos7Dias->pluck('fecha')) !!},
            datasets: [{
                label: 'Ventas (MXN)',
                data: {!! json_encode($ventasUltimos7Dias->pluck('total')) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Métodos de pago chart
    const metodosPagoCtx = document.getElementById('metodosPagoChart').getContext('2d');
    const metodosPagoChart = new Chart(metodosPagoCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($metodosPago->pluck('metodo_pago')) !!},
            datasets: [{
                data: {!! json_encode($metodosPago->pluck('total')) !!},
                backgroundColor: [
                    'rgba(16, 185, 129, 0.7)', // Efectivo - verde
                    'rgba(59, 130, 246, 0.7)',  // Tarjeta - azul
                    'rgba(245, 158, 11, 0.7)',  // Transferencia - amarillo
                ],
                borderColor: [
                    'rgba(16, 185, 129, 1)',
                    'rgba(59, 130, 246, 1)',
                    'rgba(245, 158, 11, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: $${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection