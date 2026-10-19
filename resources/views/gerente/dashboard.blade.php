<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Gerencia - Control General') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Bienvenido, {{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-500">Rol: Administrador / Gerente</p>
                    </div>
                    <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">Gerencia</span>
                </div>

                <p class="text-gray-600 mb-6">
                    Desde este panel tienes acceso completo para administrar los usuarios del sistema, monitorear el rendimiento global y revisar reportes de ventas.
                </p>

                <!-- Tarjetas de métricas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-5">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-indigo-700">Usuarios Registrados</h4>
                            <span class="text-indigo-500 font-bold">👥</span>
                        </div>
                        <p class="text-3xl font-extrabold text-indigo-900 mt-2">12</p>
                        <p class="text-xs text-indigo-600 mt-1">Clientes y empleados activos</p>
                    </div>

                    <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-5">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-emerald-700">Ventas del Mes</h4>
                            <span class="text-emerald-500 font-bold">💵</span>
                        </div>
                        <p class="text-3xl font-extrabold text-emerald-900 mt-2">$18,450 MXN</p>
                        <p class="text-xs text-emerald-600 mt-1">+15% respecto al mes anterior</p>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-5">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-amber-700">Pedidos Pendientes</h4>
                            <span class="text-amber-500 font-bold">📦</span>
                        </div>
                        <p class="text-3xl font-extrabold text-amber-900 mt-2">4</p>
                        <p class="text-xs text-amber-600 mt-1">Requieren revisión de almacén</p>
                    </div>
                </div>

                <!-- Accesos directos / Módulos -->
                <div class="border-t pt-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4">Acciones de Administración</h4>
                    <div class="flex flex-wrap gap-4">
                        <a href="#" class="bg-indigo-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                            Gestión de Usuarios (CRUD)
                        </a>
                        <a href="#" class="bg-gray-800 text-white font-semibold px-4 py-2 rounded-md hover:bg-gray-900 transition">
                            Reportes de Ventas
                        </a>
                        <a href="#" class="bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-md hover:bg-gray-300 transition">
                            Configuración del Sistema
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>