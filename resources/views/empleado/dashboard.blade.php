<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Operativo - Empleado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Hola, {{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-500">Rol: Personal Operativo / Empleado</p>
                    </div>
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">Empleado</span>
                </div>

                <p class="text-gray-600 mb-6">
                    Módulo de atención a clientes, procesamiento de pedidos en inventario y actualización de estados de envío.
                </p>

                <!-- Resumen de tareas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-5">
                        <h4 class="font-semibold text-blue-800 mb-2">Pedidos por Procesar</h4>
                        <p class="text-gray-600 text-sm mb-4">Tienes 3 pedidos asignados listos para empaquetado.</p>
                        <a href="#" class="inline-block bg-blue-600 text-white text-xs font-bold px-3 py-2 rounded hover:bg-blue-700">
                            Atender Pedidos
                        </a>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                        <h4 class="font-semibold text-gray-800 mb-2">Stock de Productos</h4>
                        <p class="text-gray-600 text-sm mb-4">Revisa la disponibilidad de productos en el inventario.</p>
                        <a href="#" class="inline-block bg-gray-800 text-white text-xs font-bold px-3 py-2 rounded hover:bg-gray-900">
                            Consultar Inventario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>