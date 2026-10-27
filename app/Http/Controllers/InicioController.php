<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Pantalla de inicio pública: catálogo de productos para cualquier visitante. */
class InicioController extends Controller
{
    public function __invoke(Request $request): View
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $categoriaActual = $categorias->firstWhere('id', (int) $request->query('categoria'));

        $productos = Producto::with('categorias')
            ->when($categoriaActual, fn ($q) => $q->whereHas(
                'categorias', fn ($c) => $c->where('categorias.id', $categoriaActual->id)
            ))
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('inicio', compact('categorias', 'categoriaActual', 'productos'));
    }
}