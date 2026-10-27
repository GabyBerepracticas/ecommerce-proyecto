<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $usuario = Auth::user();

        return view('dashboard', [
            'totalProductos' => Producto::count(),
            'totalCategorias' => Categoria::count(),
            'totalVentas' => Venta::visiblesPara($usuario)->count(),
            // Gate: solo quien puede gestionar usuarios ve este contador
            'totalUsuarios' => Gate::allows('gestionar-usuarios') ? Usuario::count() : null,
        ]);
    }
}