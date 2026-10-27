@extends('layouts.app')

@section('titulo', 'Nueva compra')

@section('contenido')
    <h1 class="text-2xl font-semibold mb-4">Comprar producto</h1>

    <form method="POST" action="{{ route('ventas.store') }}" class="bg-white shadow rounded-lg p-6 max-w-xl">
        @csrf

        <div class="mb-4">
            <label for="producto_id" class="block text-sm font-medium text-gray-700">Producto</label>
            <select id="producto_id" name="producto_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                <option value="">Selecciona un producto…</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}" @selected((int) old('producto_id', $seleccionado) === $producto->id)>
                        {{ $producto->nombre }} — ${{ number_format($producto->precio, 2) }} — Vendedor: {{ $producto->usuario->nombre_completo }} ({{ $producto->existencia }} disp.)
                    </option>
                @endforeach
            </select>
            @error('producto_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <x-campo name="fecha" label="Fecha" type="date" :value="now()->toDateString()" required />

        <p class="text-sm text-gray-500 mb-4">Se compra 1 unidad. El total es el precio del producto.</p>

        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">Confirmar compra</button>
            <a href="{{ route('productos.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
@endsection