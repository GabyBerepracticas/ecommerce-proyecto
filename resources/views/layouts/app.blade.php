<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'Inicio') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 antialiased">
    <nav class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 h-14 flex items-center justify-between">
            <div class="flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="font-bold text-indigo-600">{{ config('app.name') }}</a>
                <a href="{{ route('productos.index') }}" class="hover:text-indigo-600">Productos</a>
                <a href="{{ route('categorias.index') }}" class="hover:text-indigo-600">Categorías</a>
                <a href="{{ route('ventas.index') }}" class="hover:text-indigo-600">Ventas</a>
                @can('viewAny', \App\Models\Usuario::class)
                    <a href="{{ route('usuarios.index') }}" class="hover:text-indigo-600">Usuarios</a>
                @endcan
            </div>
            <div class="flex items-center gap-4 text-sm">
                <span>
                    {{ auth()->user()->nombre_completo }}
                    <span class="ml-1 px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700 text-xs">{{ ucfirst(auth()->user()->rol) }}</span>
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @include('partials.mensajes')
        @yield('contenido')
    </main>
</body>
</html>