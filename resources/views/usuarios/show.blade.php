@extends('layouts.app')

@section('titulo', $usuario->nombre_completo)

@section('contenido')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">{{ $usuario->nombre_completo }}</h1>
        <a href="{{ route('usuarios.index') }}" class="text-sm text-indigo-600 hover:underline">← Volver</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6 text-sm">
        <p><strong>Correo:</strong> {{ $usuario->correo }}</p>
        <p><strong>Rol:</strong> {{ ucfirst($usuario->rol) }}</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="font-semibold mb-3">Productos que vende (hasMany)</h2>
            @forelse ($usuario->productos as $producto)
                <p class="text-sm"><a href="{{ route('productos.show', $producto) }}" class="text-indigo-600 hover:underline">{{ $producto->nombre }}</a></p>
            @empty
                <p class="text-sm text-gray-500">No tiene productos.</p>
            @endforelse
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="font-semibold mb-3">Categorías a través de sus productos (hasManyThrough)</h2>
            @forelse ($categorias as $categoria)
                <span class="inline-block mr-1 mb-1 px-2 py-0.5 rounded-full bg-gray-100 text-xs">{{ $categoria->nombre }}</span>
            @empty
                <p class="text-sm text-gray-500">Sin categorías.</p>
            @endforelse
        </div>
    </div>
@endsection