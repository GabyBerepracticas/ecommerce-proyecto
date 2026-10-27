<x-campo name="nombre" label="Nombre" :value="$usuario->nombre ?? null" required />
<x-campo name="apellidos" label="Apellidos" :value="$usuario->apellidos ?? null" required />
<x-campo name="correo" label="Correo" type="email" :value="$usuario->correo ?? null" required />
<x-campo name="clave" :label="isset($usuario) ? 'Contraseña (déjala vacía para no cambiarla)' : 'Contraseña'" type="password" :required="! isset($usuario)" />

{{-- El rol solo lo puede asignar quien lo permita la policy --}}
@if (! isset($usuario) || auth()->user()->can('cambiarRol', $usuario))
    <div class="mb-4">
        <label for="rol" class="block text-sm font-medium text-gray-700">Rol</label>
        <select id="rol" name="rol" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @foreach (\App\Models\Usuario::ROLES as $rol)
                <option value="{{ $rol }}" @selected(old('rol', $usuario->rol ?? 'cliente') === $rol)>{{ ucfirst($rol) }}</option>
            @endforeach
        </select>
        @error('rol')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
@endif