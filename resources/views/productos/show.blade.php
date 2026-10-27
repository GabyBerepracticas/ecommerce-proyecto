@extends('layouts.app')

@section('titulo', $producto->nombre)

@section('contenido')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">{{ $producto->nombre }}</h1>
        <a href="{{ route('productos.index') }}" class="text-sm text-indigo-600 hover:underline">← Volver</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6 text-sm space-y-2 max-w-xl">
        <p>{{ $producto->descripcion ?: 'Sin descripción.' }}</p>
        <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
        <p><strong>Existencia:</strong> {{ $producto->existencia }}</p>
        <p><strong>Vendedor:</strong> {{ $producto->usuario->nombre_completo }}</p>
        <p>
            <strong>Categorías:</strong>
            @foreach ($producto->categorias as $categoria)
                <a href="{{ route('categorias.show', $categoria) }}" class="inline-block mr-1 px-2 py-0.5 rounded-full bg-gray-100 text-xs hover:bg-gray-200">{{ $categoria->nombre }}</a>
            @endforeach
        </p>

        <div class="pt-3 flex gap-3">
            @can('update', $producto)
                <a href="{{ route('productos.edit', $producto) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Editar</a>
            @endcan
            @guest
                @if ($producto->existencia > 0)
                    <a href="{{ route('ventas.create', ['producto' => $producto->id]) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Iniciar sesión para comprar</a>
                @endif
            @endguest
            @can('comprar-productos')
                @if ($producto->existencia > 0)
                    <a href="{{ route('ventas.create', ['producto' => $producto->id]) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Comprar</a>
                @endif
            @endcan
        </div>
    </div>
@endsection