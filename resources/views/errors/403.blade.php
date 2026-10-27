@extends(auth()->check() ? 'layouts.app' : 'layouts.guest')

@section('titulo', 'Acceso denegado')

@section('contenido')
    <div class="text-center py-10">
        <p class="text-6xl font-bold text-red-500">403</p>
        <h1 class="mt-4 text-2xl font-semibold">Acceso denegado</h1>
        <p class="mt-2 text-gray-600">No tienes permiso para realizar esta acción.</p>
        <a href="{{ url('/') }}" class="mt-6 inline-block px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">Volver al inicio</a>
    </div>
@endsection