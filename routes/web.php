<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

// ---- Inicio público: catálogo navegable sin iniciar sesión ----
Route::get('/', InicioController::class)->name('inicio');

// ---- Login manual (solo invitados) ----
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.intentar');

    Route::get('/registro', [AuthController::class, 'showRegistro'])->name('registro');
    Route::post('/registro', [AuthController::class, 'registro'])->name('registro.guardar');
});

// ---- Rutas protegidas (la autorización fina la hacen las Policies) ----
// Importante: se registran ANTES que las públicas para que /productos/create
// no sea interpretado como /productos/{producto}.
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('usuarios', UsuarioController::class)->parameters(['usuarios' => 'usuario']);
    Route::resource('productos', ProductoController::class)->parameters(['productos' => 'producto'])->except(['index', 'show']);
    Route::resource('categorias', CategoriaController::class)->parameters(['categorias' => 'categoria'])->except(['index', 'show']);
    Route::resource('ventas', VentaController::class)->parameters(['ventas' => 'venta']);
});

// ---- Consulta pública de productos y categorías (sin iniciar sesión) ----
Route::resource('productos', ProductoController::class)->parameters(['productos' => 'producto'])->only(['index', 'show']);
Route::resource('categorias', CategoriaController::class)->parameters(['categorias' => 'categoria'])->only(['index', 'show']);