@extends('layouts.guest')

@section('titulo', 'Registro')

@section('contenido')
    <h1 class="text-xl font-semibold mb-4">Crear cuenta de cliente</h1>

    <form method="POST" action="{{ route('registro.guardar') }}">
        @csrf

        <x-campo name="nombre" label="Nombre" required autofocus />
        <x-campo name="apellidos" label="Apellidos" required />
        <x-campo name="correo" label="Correo" type="email" required />
        <x-campo name="clave" label="Contraseña" type="password" required />
        <x-campo name="clave_confirmation" label="Confirmar contraseña" type="password" required />

        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Registrarme</button>
    </form>

    <p class="mt-4 text-sm text-center text-gray-600">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Inicia sesión</a>
    </p>
@endsection