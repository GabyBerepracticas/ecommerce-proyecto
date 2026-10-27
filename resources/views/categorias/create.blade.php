@extends('layouts.app')

@section('titulo', 'Nueva categoría')

@section('contenido')
    <h1 class="text-2xl font-semibold mb-4">Nueva categoría</h1>

    <form method="POST" action="{{ route('categorias.store') }}" class="bg-white shadow rounded-lg p-6 max-w-xl">
        @csrf
        @include('categorias._form')
        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Guardar</button>
            <a href="{{ route('categorias.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
@endsection