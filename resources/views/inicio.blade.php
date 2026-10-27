@extends('layouts.app')

@section('titulo', 'Inicio')

@section('contenido')
    <section class="bg-indigo-600 text-white rounded-lg px-6 py-10 mb-8">
        <h1 class="text-3xl font-bold">Bienvenido a {{ config('app.name') }}</h1>
        <p class="mt-2 text-indigo-100">Explora nuestro catálogo libremente. Para comprar necesitas una cuenta de cliente.</p>
        @guest
            <div class="mt-5 flex gap-3 text-sm">
                <a href="{{ route('registro') }}" class="px-4 py-2 bg-white text-indigo-700 font-medium rounded-md hover:bg-indigo-50">Crear cuenta</a>
                <a href="{{ route('login') }}" class="px-4 py-2 border border-white rounded-md hover:bg-indigo-500">Iniciar sesión</a>
            </div>
        @endguest
    </section>

    <div class="flex flex-wrap gap-2 mb-6 text-sm">
        <a href="{{ route('inicio') }}"
           class="px-3 py-1 rounded-full {{ $categoriaActual ? 'bg-white text-gray-700 hover:bg-gray-200' : 'bg-indigo-600 text-white' }}">Todas</a>
        @foreach ($categorias as $categoria)
            <a href="{{ route('inicio', ['categoria' => $categoria->id]) }}"
               class="px-3 py-1 rounded-full {{ $categoriaActual?->id === $categoria->id ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200' }}">{{ $categoria->nombre }}</a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @forelse ($productos as $producto)
            <div class="bg-white rounded-lg shadow p-5 flex flex-col">
                <h2 class="font-semibold">{{ $producto->nombre }}</h2>
                <p class="mt-1 text-sm text-gray-600 flex-1">{{ \Illuminate\Support\Str::limit($producto->descripcion ?: 'Sin descripción.', 80) }}</p>
                <div class="mt-2">
                    @foreach ($producto->categorias as $categoria)
                        <span class="inline-block mr-1 mb-1 px-2 py-0.5 rounded-full bg-gray-100 text-xs">{{ $categoria->nombre }}</span>
                    @endforeach
                </div>
                <p class="mt-2 text-xl font-bold text-indigo-600">${{ number_format($producto->precio, 2) }}</p>
                <p class="text-xs {{ $producto->existencia > 0 ? 'text-gray-500' : 'text-red-600' }}">
                    {{ $producto->existencia > 0 ? 'Disponibles: '.$producto->existencia : 'Agotado' }}
                </p>
                <div class="mt-4 flex items-center gap-3 text-sm">
                    <a href="{{ route('productos.show', $producto) }}" class="text-indigo-600 hover:underline">Ver detalle</a>
                    @if ($producto->existencia > 0)
                        @guest
                            <a href="{{ route('ventas.create', ['producto' => $producto->id]) }}" class="text-green-700 hover:underline">Comprar</a>
                        @endguest
                        @can('comprar-productos')
                            <a href="{{ route('ventas.create', ['producto' => $producto->id]) }}" class="text-green-700 hover:underline">Comprar</a>
                        @endcan
                    @endif
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 py-10">No hay productos disponibles.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $productos->links() }}</div>
@endsection