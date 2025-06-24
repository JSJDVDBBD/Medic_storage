@extends('layouts.app')

@section('title', 'Medicamentos')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <h1 class="text-2xl font-bold flex items-center">
            <i class="fas fa-pills mr-2"></i> Medicamentos
        </h1>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto mt-4 md:mt-0">
            <a href="{{ route('medicamentos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> Nuevo Medicamento
            </a>
            
            <form action="{{ route('medicamentos.index') }}" method="GET" class="flex">
                <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}"
                    class="px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                <button type="submit" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-r-lg">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gray-50">
            <div class="flex space-x-2 mb-2 sm:mb-0">
                <a href="{{ route('medicamentos.index', ['stock' => 'bajo']) }}" 
                    class="px-3 py-1 rounded-full text-sm font-medium {{ request('stock') == 'bajo' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                    Stock Bajo
                </a>
                <a href="{{ route('medicamentos.index', ['caducidad' => 'proxima']) }}" 
                    class="px-3 py-1 rounded-full text-sm font-medium {{ request('caducidad') == 'proxima' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800' }}">
                    Próximos a Caducar
                </a>
                <a href="{{ route('medicamentos.index') }}" 
                    class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                    Todos
                </a>
            </div>
            
            <div class="text-sm text-gray-600">
                Mostrando {{ $medicamentos->firstItem() }} - {{ $medicamentos->lastItem() }} de {{ $medicamentos->total() }} registros
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Presentación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Venta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Caducidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($medicamentos as $medicamento)
                    @php
                        $fechaCaducidad = \Carbon\Carbon::parse($medicamento->fecha_caducidad);
                        $diasParaCaducar = $fechaCaducidad->diffInDays(now(), false) * -1;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ $medicamento->imagen_url }}" alt="{{ $medicamento->nombre }}" class="h-10 w-10 rounded-full object-cover">
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $medicamento->nombre }}</div>
                            <div class="text-sm text-gray-500">{{ $medicamento->laboratorio }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $medicamento->presentacion }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium {{ $medicamento->stock <= $medicamento->stock_minimo ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $medicamento->stock }}
                                </span>
                                <span class="text-xs text-gray-500 ml-1">/ {{ $medicamento->stock_minimo }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium">${{ number_format($medicamento->precio_venta, 2) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $diasParaCaducar <= 0 ? 'bg-red-100 text-red-800' : 
                                  ($diasParaCaducar <= 30 ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                                {{ $fechaCaducidad->format('d/m/Y') }}
                                ({{ $diasParaCaducar <= 0 ? 'Caducado' : $fechaCaducidad->diffForHumans() }})
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('medicamentos.show', $medicamento->id) }}" 
                                    class="text-blue-600 hover:text-blue-900" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('medicamentos.edit', $medicamento->id) }}" 
                                    class="text-yellow-600 hover:text-yellow-900" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('medicamentos.destroy', $medicamento->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" 
                                        onclick="return confirm('¿Estás seguro de eliminar este medicamento?')" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No se encontraron medicamentos
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="bg-gray-50 px-4 py-3 border-t">
            {{ $medicamentos->links() }}
        </div>
    </div>
</div>
@endsection