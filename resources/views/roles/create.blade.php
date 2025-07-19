@extends('layouts.app')

@section('title', 'Crear Rol')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6 flex items-center">
                <i class="fas fa-cash-register mr-3"></i> Nuevo Medicamento
            </h2>

            <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="gap-6">
                    <div>
                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre *</label>
                            <input type="text" name="name" id="nombre" value="{{ old('name') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <p class="text-sm font-medium ">Permisos</p>
                            <ul>
                                @foreach ($permissions as $permission)
                                    <li>
                                        <label>
                                            <input 
                                                type="checkbox" 
                                                name="permissions[]"  
                                                value="{{$permission->id}}"
                                                @checked(in_array($permission->id, old('permissions',[])))
                                            >
                                            <span class="ml-2">
                                                {{$permission->name}}
                                            </span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>


                <div class="flex justify-end mt-6">
                    <a href="{{ route('roles.index') }}"
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