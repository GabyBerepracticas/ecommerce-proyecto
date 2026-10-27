@extends('layouts.app')

@section('titulo', 'Venta #'.$venta->id)

@section('contenido')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Venta #{{ $venta->id }}</h1>
        <a href="{{ route('ventas.index') }}" class="text-sm text-indigo-600 hover:underline">← Volver</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6 text-sm space-y-2 max-w-xl">
        <p><strong>Fecha:</strong> {{ $venta->fecha->format('d/m/Y') }}</p>
        <p><strong>Producto:</strong> {{ $venta->producto->nombre }}</p>
        <p><strong>Cliente:</strong> {{ $venta->cliente->nombre_completo }} ({{ $venta->cliente->correo }})</p>
        <p><strong>Vendedor:</strong> {{ $venta->vendedor->nombre_completo }} ({{ $venta->vendedor->correo }})</p>
        <p><strong>Total:</strong> ${{ number_format($venta->total, 2) }}</p>

        @can('update', $venta)
            <div class="pt-3">
                <a href="{{ route('ventas.edit', $venta) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Editar</a>
            </div>
        @endcan
    </div>
@endsection