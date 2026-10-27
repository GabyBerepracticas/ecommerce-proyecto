@extends('layouts.app')

@section('titulo', 'Editar venta')

@section('contenido')
    <h1 class="text-2xl font-semibold mb-4">Editar venta #{{ $venta->id }}</h1>

    <form method="POST" action="{{ route('ventas.update', $venta) }}" class="bg-white shadow rounded-lg p-6 max-w-xl">
        @csrf @method('PUT')

        <div class="text-sm text-gray-600 mb-4 space-y-1">
            <p><strong>Producto:</strong> {{ $venta->producto->nombre }}</p>
            <p><strong>Cliente:</strong> {{ $venta->cliente->nombre_completo }}</p>
            <p><strong>Vendedor:</strong> {{ $venta->vendedor->nombre_completo }}</p>
        </div>

        <x-campo name="fecha" label="Fecha" type="date" :value="$venta->fecha->format('Y-m-d')" required />
        <x-campo name="total" label="Total" type="number" step="0.01" min="0" :value="$venta->total" required />

        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Actualizar</button>
            <a href="{{ route('ventas.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
@endsection