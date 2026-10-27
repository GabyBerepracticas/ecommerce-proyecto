@extends('layouts.app')

@section('titulo', 'Categorías')

@section('contenido')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Categorías</h1>
        @can('create', \App\Models\Categoria::class)
            <a href="{{ route('categorias.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Nueva categoría</a>
        @endcan
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Descripción</th>
                    <th class="px-4 py-3">Productos</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($categorias as $categoria)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $categoria->nombre }}</td>
                        <td class="px-4 py-3">{{ $categoria->descripcion }}</td>
                        <td class="px-4 py-3">{{ $categoria->productos_count }}</td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('categorias.show', $categoria) }}" class="text-indigo-600 hover:underline">Ver</a>
                            @can('update', $categoria)
                                <a href="{{ route('categorias.edit', $categoria) }}" class="text-indigo-600 hover:underline">Editar</a>
                            @endcan
                            @can('delete', $categoria)
                                <form method="POST" action="{{ route('categorias.destroy', $categoria) }}" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">No hay categorías registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $categorias->links() }}</div>
@endsection