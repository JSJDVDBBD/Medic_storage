@extends('layouts.app')

@section('title', 'Nuevo Medicamento')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-6 flex items-center">
            <i class="fas fa-pills mr-2"></i> Nuevo Medicamento
        </h2>
        
        <form action="{{ route('medicamentos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Columna Izquierda -->
                <div>
                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('nombre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="descripcion" class="block text-gray-700 font-medium mb-2">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="presentacion" class="block text-gray-700 font-medium mb-2">Presentación *</label>
                        <input type="text" name="presentacion" id="presentacion" value="{{ old('presentacion') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('presentacion')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="laboratorio" class="block text-gray-700 font-medium mb-2">Laboratorio *</label>
                        <input type="text" name="laboratorio" id="laboratorio" value="{{ old('laboratorio') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('laboratorio')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Columna Derecha -->
                <div>
                    <div class="mb-4">
                        <label for="imagen" class="block text-gray-700 font-medium mb-2">Imagen del Medicamento</label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col w-full h-32 border-2 border-dashed rounded-lg hover:bg-gray-50 hover:border-blue-300 transition-all">
                                <div class="flex flex-col items-center justify-center pt-7">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-500">Haz clic o arrastra una imagen</p>
                                </div>
                                <input type="file" name="imagen" id="imagen" class="opacity-0" accept="image/*">
                            </label>
                        </div>
                        <div id="imagen-preview" class="mt-2 hidden">
                            <img id="preview" class="h-32 object-contain border rounded">
                        </div>
                        @error('imagen')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="stock" class="block text-gray-700 font-medium mb-2">Stock *</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('stock')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="stock_minimo" class="block text-gray-700 font-medium mb-2">Stock Mínimo *</label>
                            <input type="number" name="stock_minimo" id="stock_minimo" value="{{ old('stock_minimo', 10) }}" min="0"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('stock_minimo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="precio_compra" class="block text-gray-700 font-medium mb-2">Precio Compra *</label>
                            <input type="number" name="precio_compra" id="precio_compra" value="{{ old('precio_compra', 0) }}" min="0" step="0.01"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('precio_compra')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="precio_venta" class="block text-gray-700 font-medium mb-2">Precio Venta *</label>
                            <input type="number" name="precio_venta" id="precio_venta" value="{{ old('precio_venta', 0) }}" min="0" step="0.01"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('precio_venta')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="fecha_caducidad" class="block text-gray-700 font-medium mb-2">Fecha Caducidad *</label>
                            <input type="date" name="fecha_caducidad" id="fecha_caducidad" value="{{ old('fecha_caducidad') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('fecha_caducidad')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="lote" class="block text-gray-700 font-medium mb-2">Lote *</label>
                            <input type="text" name="lote" id="lote" value="{{ old('lote') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('lote')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="requiere_receta" id="requiere_receta" value="1" {{ old('requiere_receta') ? 'checked' : '' }}
                            class="mr-2 h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                        <label for="requiere_receta" class="text-gray-700">Requiere receta médica</label>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end mt-6">
                <a href="{{ route('medicamentos.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg mr-2">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i> Guardar Medicamento
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Preview de imagen seleccionada
    document.getElementById('imagen').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagen-preview');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endpush
@endsection