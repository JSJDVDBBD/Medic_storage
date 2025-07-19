@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6 flex items-center">
                <i class="fas fa-users-cog mr-3"></i> Ediatar Usuario
            </h2>

            <form action="{{ route('users.update',$user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="gap-6">
                    <div>
                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre *</label>
                            <input type="text" name="name" id="nombre" value="{{ old('name',$user->name) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700 font-medium mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email',$user->email) }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-medium mb-2">Contraseña *</label>
                            <input type="password" name="password" value="{{ old('password') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-medium mb-2">Confirmar Contraseña *</label>
                            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('password_confirmation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="mb-4">
                            <p class="text-sm font-medium ">Roles</p>
                            <ul>
                                @foreach ($roles as $rol)
                                    <li>
                                        <label>
                                            <input 
                                                type="checkbox" 
                                                name="roles[]"  
                                                value="{{$rol->id}}"
                                                @checked(in_array($rol->id, old('roles',$user->roles->pluck('id')->toArray())))
                                            >
                                            <span class="ml-2">
                                                {{$rol->name}}
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
                        <i class="fas fa-save mr-2"></i> Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection