@extends('layouts.app')

@section('titulo', $categoria->nombre)

@section('contenido')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">{{ $categoria->nombre }}</h1>
        <a href="{{ route('categorias.index') }}" class="text-sm text-indigo-600 hover:underline">← Volver</a>
    </div>

    <p class="text-gray-600 mb-4">{{ $categoria->descripcion ?: 'Sin descripción.' }}</p>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="font-semibold mb-3">Productos de esta categoría</h2>
        @forelse ($categoria->productos as $producto)
            <p class="text-sm py-1">
                <a href="{{ route('productos.show', $producto) }}" class="text-indigo-600 hover:underline">{{ $producto->nombre }}</a>
                — ${{ number_format($producto->precio, 2) }} — Vendedor: {{ $producto->usuario->nombre_completo }}
            </p>
        @empty
            <p class="text-sm text-gray-500">Esta categoría aún no tiene productos.</p>
        @endforelse
    </div>
@endsection