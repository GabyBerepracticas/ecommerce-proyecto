@extends('layouts.guest')

@section('titulo', 'Iniciar sesión')

@section('contenido')
    <h1 class="text-xl font-semibold mb-4">Iniciar sesión</h1>

    <form method="POST" action="{{ route('login.intentar') }}">
        @csrf

        <x-campo name="correo" label="Correo" type="email" required autofocus />
        <x-campo name="clave" label="Contraseña" type="password" required />

        <label class="flex items-center text-sm text-gray-600 mb-4">
            <input type="checkbox" name="recordar" class="rounded border-gray-300 text-indigo-600">
            <span class="ml-2">Recordarme</span>
        </label>

        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Entrar</button>
    </form>

    <p class="mt-4 text-sm text-center text-gray-600">
        ¿No tienes cuenta? <a href="{{ route('registro') }}" class="text-indigo-600 hover:underline">Regístrate como cliente</a>
    </p>
@endsection