<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Página de inicio pública (accesible para anónimos y todos los usuarios)
Route::get('/', function () {
    return view('welcome');
});

// Redirección inteligente del Dashboard principal según el Rol del usuario
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'gerente') {
        return redirect()->route('gerente.dashboard');
    }

    if ($role === 'empleado') {
        return redirect()->route('empleado.dashboard');
    }

    return redirect()->route('cliente.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --------------------------------------------------------------------------
// RUTAS PROTEGIDAS POR ROL (CAMBIO PRINCIPAL)
// --------------------------------------------------------------------------

// Dashboard exclusivo para Clientes
Route::middleware(['auth', 'role:cliente'])->get('/cliente/dashboard', function () {
    return view('dashboard'); // Puedes crear luego 'cliente.dashboard' o usar esta vista temporalmente
})->name('cliente.dashboard');

// Dashboard exclusivo para Empleados
Route::middleware(['auth', 'role:empleado'])->get('/empleado/dashboard', function () {
    return view('dashboard'); // Puedes crear luego 'empleado.dashboard' o usar esta vista temporalmente
})->name('empleado.dashboard');

// Dashboard exclusivo para Gerentes (Administración)
Route::middleware(['auth', 'role:gerente'])->get('/gerente/dashboard', function () {
    return view('dashboard'); // Puedes crear luego 'gerente.dashboard' o usar esta vista temporalmente
})->name('gerente.dashboard');

// --------------------------------------------------------------------------

// Rutas de perfil (Perfil de usuario común para cualquier usuario autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';