@extends('layouts.app')

@section('titulo', 'Productos')

@section('contenido')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Productos</h1>
        @can('create', \App\Models\Producto::class)
            <a href="{{ route('productos.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Nuevo producto</a>
        @endcan
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">Producto</th>
                    <th class="px-4 py-3">Precio</th>
                    <th class="px-4 py-3">Existencia</th>
                    <th class="px-4 py-3">Vendedor</th>
                    <th class="px-4 py-3">Categorías</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($productos as $producto)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $producto->nombre }}</td>
                        <td class="px-4 py-3">${{ number_format($producto->precio, 2) }}</td>
                        <td class="px-4 py-3">{{ $producto->existencia }}</td>
                        <td class="px-4 py-3">{{ $producto->usuario->nombre_completo }}</td>
                        <td class="px-4 py-3">
                            @foreach ($producto->categorias as $categoria)
                                <span class="inline-block mr-1 mb-1 px-2 py-0.5 rounded-full bg-gray-100 text-xs">{{ $categoria->nombre }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-3">
                                <a href="{{ route('productos.show', $producto) }}" class="text-indigo-600 hover:underline">Ver</a>
                                @can('update', $producto)
                                    <a href="{{ route('productos.edit', $producto) }}" class="text-indigo-600 hover:underline">Editar</a>
                                @endcan
                                @can('delete', $producto)
                                    <form method="POST" action="{{ route('productos.destroy', $producto) }}" onsubmit="return confirm('¿Eliminar este producto?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                @endcan
                                @can('comprar-productos')
                                    @if ($producto->existencia > 0)
                                        <a href="{{ route('ventas.create', ['producto' => $producto->id]) }}" class="text-green-700 hover:underline">Comprar</a>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay productos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $productos->links() }}</div>
@endsection