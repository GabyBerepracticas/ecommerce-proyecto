<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Ruta principal del Dashboard según el rol
Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    if ($role === 'gerente') {
        return view('gerente.dashboard');
    } elseif ($role === 'empleado') {
        return view('empleado.dashboard');
    }
    
    return view('cliente.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas del perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); 

require __DIR__.'/auth.php';