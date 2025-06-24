<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medic Storage - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-blue-800 text-white shadow-lg">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold flex items-center">
                        <i class="fas fa-prescription-bottle-alt mr-2"></i>
                        MEDIC STORAGE
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="hidden md:inline text-sm">{{ auth()->user()->name }}</span>
                    <div class="relative">
                        <button id="user-menu" class="flex items-center focus:outline-none">
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="">
                        </button>
                        <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside class="hidden md:block w-64 bg-white shadow-md">
                <div class="p-4">
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-100 @if(request()->routeIs('dashboard')) bg-blue-100 text-blue-800 font-medium @endif">
                                <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('medicamentos.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-100 @if(request()->routeIs('medicamentos.*')) bg-blue-100 text-blue-800 font-medium @endif">
                                <i class="fas fa-pills mr-3"></i> Medicamentos
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('alertas.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-100 @if(request()->routeIs('alertas.*')) bg-blue-100 text-blue-800 font-medium @endif">
                                <i class="fas fa-bell mr-3"></i> Alertas
                                @if($alertasCount = \App\Models\Alerta::where('resuelta', false)->count())
                                    <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $alertasCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('ventas.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-100 @if(request()->routeIs('ventas.*')) bg-blue-100 text-blue-800 font-medium @endif">
                                <i class="fas fa-cash-register mr-3"></i> Punto de Venta
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('corte-caja.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-100 @if(request()->routeIs('corte-caja.*')) bg-blue-100 text-blue-800 font-medium @endif">
                                <i class="fas fa-calculator mr-3"></i> Corte de Caja
                            </a>
                        </li>
                        @if(auth()->user()->isAdmin())
                        <li class="pt-4 mt-4 border-t">
                            <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-blue-100">
                                <i class="fas fa-users-cog mr-3"></i> Administración
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </aside>

            <!-- Mobile sidebar button -->
            <button id="mobile-menu-button" class="md:hidden fixed bottom-4 right-4 bg-blue-600 text-white p-3 rounded-full shadow-lg z-40">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Mobile sidebar -->
            <div id="mobile-sidebar" class="hidden fixed inset-0 bg-black bg-opacity-50 z-30">
                <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg">
                    <div class="p-4">
                        <button id="close-mobile-menu" class="absolute top-4 right-4 text-gray-500">
                            <i class="fas fa-times"></i>
                        </button>
                        <ul class="space-y-2 mt-8">
                            <li>
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-100 @if(request()->routeIs('dashboard')) bg-blue-100 text-blue-800 font-medium @endif">
                                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('medicamentos.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-100 @if(request()->routeIs('medicamentos.*')) bg-blue-100 text-blue-800 font-medium @endif">
                                    <i class="fas fa-pills mr-3"></i> Medicamentos
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('alertas.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-100 @if(request()->routeIs('alertas.*')) bg-blue-100 text-blue-800 font-medium @endif">
                                    <i class="fas fa-bell mr-3"></i> Alertas
                                    @if($alertasCount = \App\Models\Alerta::where('resuelta', false)->count())
                                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $alertasCount }}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ventas.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-100 @if(request()->routeIs('ventas.*')) bg-blue-100 text-blue-800 font-medium @endif">
                                    <i class="fas fa-cash-register mr-3"></i> Punto de Venta
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('corte-caja.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-blue-100 @if(request()->routeIs('corte-caja.*')) bg-blue-100 text-blue-800 font-medium @endif">
                                    <i class="fas fa-calculator mr-3"></i> Corte de Caja
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin())
                            <li class="pt-4 mt-4 border-t">
                                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-blue-100">
                                    <i class="fas fa-users-cog mr-3"></i> Administración
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1 p-4 md:p-6">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        // Toggle user dropdown
        document.getElementById('user-menu').addEventListener('click', function() {
            document.getElementById('user-dropdown').classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('user-menu');
            const dropdown = document.getElementById('user-dropdown');
            
            if (!userMenu.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-sidebar').classList.remove('hidden');
        });

        document.getElementById('close-mobile-menu').addEventListener('click', function() {
            document.getElementById('mobile-sidebar').classList.add('hidden');
        });
    </script>
</body>
</html>