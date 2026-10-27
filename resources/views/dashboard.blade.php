@extends('layouts.app')

@section('titulo', 'Inicio')

@section('contenido')
    <h1 class="text-2xl font-semibold">Hola, {{ auth()->user()->nombre }}</h1>
    <p class="text-gray-600 mt-1">Rol: <strong>{{ ucfirst(auth()->user()->rol) }}</strong></p>

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('productos.index') }}" class="bg-white rounded-lg shadow p-5 hover:shadow-md">
            <p class="text-sm text-gray-500">Productos</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalProductos }}</p>
        </a>
        <a href="{{ route('categorias.index') }}" class="bg-white rounded-lg shadow p-5 hover:shadow-md">
            <p class="text-sm text-gray-500">Categorías</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalCategorias }}</p>
        </a>
        <a href="{{ route('ventas.index') }}" class="bg-white rounded-lg shadow p-5 hover:shadow-md">
            <p class="text-sm text-gray-500">{{ auth()->user()->esCliente() ? 'Mis compras' : (auth()->user()->esGerente() ? 'Mis ventas' : 'Ventas') }}</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalVentas }}</p>
        </a>
        @if (! is_null($totalUsuarios))
            <a href="{{ route('usuarios.index') }}" class="bg-white rounded-lg shadow p-5 hover:shadow-md">
                <p class="text-sm text-gray-500">Usuarios</p>
                <p class="text-3xl font-bold text-indigo-600">{{ $totalUsuarios }}</p>
            </a>
        @endif
    </div>
@endsection