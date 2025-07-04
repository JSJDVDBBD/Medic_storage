@extends('layouts.app')

@section('title', 'Puntos de venta')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6 flex items-center">
                <i class="fas fa-cash-register mr-3"></i> Nuevo Medicamento
            </h2>

            <form action="{{ route('punto-venta.update', $puntoVenta) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="gap-6">
                    <!-- Columna Izquierda -->
                    <div>
                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre *</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $puntoVenta->nombre) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('nombre')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <label for="presentacion" class="block text-gray-700 font-medium mb-2">Direccion *</label>
                            <input type="text" name="direccion" id="presentacion" value="{{ old('direccion', $puntoVenta->direccion) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('direccion')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="laboratorio" class="block text-gray-700 font-medium mb-2">Telefono *</label>
                            <input type="text" name="telefono" id="laboratorio" value="{{ old('telefono', $puntoVenta->telefono) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('telefono')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
                {{-- Usuario --}}
                <div class="mb-4">
                    <label for="usuario_id" class="block text-gray-700 font-medium mb-2">Encargado *</label>
                    <select name="user_id" id="usuario_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Seleccione un usuario</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('user_id', $puntoVenta->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div class="flex justify-end mt-6">
                    <a href="{{ route('medicamentos.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg mr-2">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-save mr-2"></i> Guardar Punto de Venta
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
