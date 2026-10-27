<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Categoria::class);

        return view('categorias.index', [
            'categorias' => Categoria::withCount('productos')->orderBy('nombre')->paginate(10),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Categoria::class);

        return view('categorias.create');
    }

    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        $this->authorize('create', Categoria::class);

        Categoria::create($request->validated());

        return redirect()->route('categorias.index')->with('exito', 'Categoría creada correctamente.');
    }

    public function show(Categoria $categoria): View
    {
        $this->authorize('view', $categoria);

        return view('categorias.show', [
            'categoria' => $categoria->load('productos.usuario'),
        ]);
    }

    public function edit(Categoria $categoria): View
    {
        $this->authorize('update', $categoria);

        return view('categorias.edit', compact('categoria'));
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $this->authorize('update', $categoria);

        $categoria->update($request->validated());

        return redirect()->route('categorias.index')->with('exito', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        $this->authorize('delete', $categoria);

        // La tabla pivote tiene cascadeOnDelete: solo se borran los vínculos, no los productos.
        $categoria->delete();

        return redirect()->route('categorias.index')->with('exito', 'Categoría eliminada correctamente.');
    }
}