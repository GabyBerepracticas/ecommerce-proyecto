@extends('layouts.app')

@section('titulo', 'Ventas')

@section('contenido')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">
            {{ auth()->user()->esCliente() ? 'Mis compras' : (auth()->user()->esGerente() ? 'Mis ventas' : 'Ventas') }}
        </h1>
        @can('create', \App\Models\Venta::class)
            <a href="{{ route('ventas.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Nueva compra</a>
        @endcan
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3">Producto</th>
                    <th class="px-4 py-3">Cliente</th>
                    <th class="px-4 py-3">Vendedor</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($ventas as $venta)
                    <tr>
                        <td class="px-4 py-3">{{ $venta->id }}</td>
                        <td class="px-4 py-3">{{ $venta->fecha->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">{{ $venta->producto->nombre }}</td>
                        <td class="px-4 py-3">{{ $venta->cliente->nombre_completo }}</td>
                        <td class="px-4 py-3">{{ $venta->vendedor->nombre_completo }}</td>
                        <td class="px-4 py-3">${{ number_format($venta->total, 2) }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-3">
                                <a href="{{ route('ventas.show', $venta) }}" class="text-indigo-600 hover:underline">Ver</a>
                                @can('update', $venta)
                                    <a href="{{ route('ventas.edit', $venta) }}" class="text-indigo-600 hover:underline">Editar</a>
                                @endcan
                                @can('delete', $venta)
                                    <form method="POST" action="{{ route('ventas.destroy', $venta) }}" onsubmit="return confirm('¿Eliminar esta venta?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay ventas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $ventas->links() }}</div>
@endsection