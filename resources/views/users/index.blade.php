@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h1 class="text-2xl font-bold flex items-center">
                <i class="fas fa-users-cog mr-3"></i> Roles
            </h1>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto mt-4 md:mt-0">
                <a href="{{ route('users.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i> Nuevo Usuario
                </a>

                <form action="{{ route('punto-venta.index') }}" method="GET" class="flex">
                    <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}"
                        class="px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-r-lg">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-900"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No se encontraron roles
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endsection
