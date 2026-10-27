<x-campo name="nombre" label="Nombre" :value="$producto->nombre ?? null" required />

<div class="mb-4">
    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
    <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <x-campo name="precio" label="Precio" type="number" step="0.01" min="0" :value="$producto->precio ?? null" required />
    <x-campo name="existencia" label="Existencia" type="number" min="0" :value="$producto->existencia ?? null" required />
</div>

@php
    $seleccionadas = old('categorias', isset($producto) ? $producto->categorias->pluck('id')->all() : []);
@endphp

<div class="mb-4">
    <span class="block text-sm font-medium text-gray-700">Categorías (una o varias)</span>
    <div class="mt-2 grid grid-cols-2 gap-2">
        @foreach ($categorias as $categoria)
            <label class="flex items-center text-sm">
                <input type="checkbox" name="categorias[]" value="{{ $categoria->id }}"
                       class="rounded border-gray-300 text-indigo-600"
                       @checked(in_array($categoria->id, $seleccionadas))>
                <span class="ml-2">{{ $categoria->nombre }}</span>
            </label>
        @endforeach
    </div>
    @error('categorias')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
    @error('categorias.*')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>