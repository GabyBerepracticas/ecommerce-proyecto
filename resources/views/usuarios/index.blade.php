@extends('layouts.app')

@section('titulo', 'Usuarios')

@section('contenido')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Usuarios</h1>
        @can('create', \App\Models\Usuario::class)
            <a href="{{ route('usuarios.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Nuevo usuario</a>
        @endcan
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Correo</th>
                    <th class="px-4 py-3">Rol</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td class="px-4 py-3">{{ $usuario->id }}</td>
                        <td class="px-4 py-3">{{ $usuario->nombre_completo }}</td>
                        <td class="px-4 py-3">{{ $usuario->correo }}</td>
                        <td class="px-4 py-3">{{ ucfirst($usuario->rol) }}</td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('usuarios.show', $usuario) }}" class="text-indigo-600 hover:underline">Ver</a>
                            @can('update', $usuario)
                                <a href="{{ route('usuarios.edit', $usuario) }}" class="text-indigo-600 hover:underline">Editar</a>
                            @endcan
                            @can('delete', $usuario)
                                <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" onsubmit="return confirm('¿Eliminar este usuario?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $usuarios->links() }}</div>
@endsection