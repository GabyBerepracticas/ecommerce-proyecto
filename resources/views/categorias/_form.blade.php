<x-campo name="nombre" label="Nombre" :value="$categoria->nombre ?? null" required />

<div class="mb-4">
    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
    <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>