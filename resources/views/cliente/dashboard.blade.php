<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Cuenta - Tienda en Línea') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">¡Bienvenido(a), {{ Auth::user()->name }}!</h3>
                        <p class="text-sm text-gray-500">Cliente registrado</p>
                    </div>
                    <span class="bg-teal-100 text-teal-800 text-xs font-semibold px-3 py-1 rounded-full">Cliente</span>
                </div>

                <p class="text-gray-600 mb-6">
                    Explora nuestro catálogo de productos, gestiona tus compras e historial de pedidos.
                </p>

                <!-- Secciones de Cliente -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="border rounded-lg p-5 hover:shadow-md transition">
                        <h4 class="font-bold text-lg text-gray-800 mb-2">🛒 Catálogo de Productos</h4>
                        <p class="text-gray-600 text-sm mb-4">Encuentra los mejores productos disponibles en nuestra tienda.</p>
                        <a href="#" class="inline-block bg-teal-600 text-white font-semibold text-sm px-4 py-2 rounded hover:bg-teal-700">
                            Ir a Comprar
                        </a>
                    </div>

                    <div class="border rounded-lg p-5 hover:shadow-md transition">
                        <h4 class="font-bold text-lg text-gray-800 mb-2">📋 Mis Pedidos</h4>
                        <p class="text-gray-600 text-sm mb-4">Consulta el estado del envío y el historial de tus compras pasadas.</p>
                        <a href="#" class="inline-block bg-gray-800 text-white font-semibold text-sm px-4 py-2 rounded hover:bg-gray-900">
                            Ver Historial
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>