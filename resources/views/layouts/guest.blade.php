<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'Acceso') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">
        <a href="/" class="mb-6 text-2xl font-bold text-indigo-600">{{ config('app.name') }}</a>
        <div class="w-full max-w-md bg-white shadow-md rounded-lg px-6 py-6">
            @yield('contenido')
        </div>
    </div>
</body>
</html>