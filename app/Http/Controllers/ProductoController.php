<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Producto::class);

        return view('productos.index', [
            'productos' => Producto::with(['usuario', 'categorias'])->orderBy('id')->paginate(10),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Producto::class);

        return view('productos.create', [
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    public function store(StoreProductoRequest $request): RedirectResponse
    {
        $this->authorize('create', Producto::class);

        $producto = Producto::create([
            ...$request->safe()->except('categorias'),
            'usuario_id' => $request->user()->id, // el vendedor es quien lo crea
        ]);

        $producto->categorias()->sync($request->validated('categorias'));

        Log::channel('productos')->info('Producto creado', [
            'usuario_id' => $request->user()->id,
            'producto_id' => $producto->id,
            'nombre' => $producto->nombre,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('productos.index')->with('exito', 'Producto creado correctamente.');
    }

    public function show(Producto $producto): View
    {
        $this->authorize('view', $producto);

        return view('productos.show', [
            'producto' => $producto->load(['usuario', 'categorias']),
        ]);
    }

    public function edit(Producto $producto): View
    {
        $this->authorize('update', $producto);

        return view('productos.edit', [
            'producto' => $producto->load('categorias'),
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        $this->authorize('update', $producto);

        $producto->update($request->safe()->except('categorias'));
        $producto->categorias()->sync($request->validated('categorias'));

        Log::channel('productos')->info('Producto editado', [
            'usuario_id' => $request->user()->id,
            'producto_id' => $producto->id,
            'nombre' => $producto->nombre,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('productos.index')->with('exito', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        $this->authorize('delete', $producto);

        $datos = [
            'usuario_id' => request()->user()->id,
            'producto_id' => $producto->id,
            'nombre' => $producto->nombre,
            'ip' => request()->ip(),
        ];

        try {
            $producto->delete();
        } catch (QueryException) {
            return back()->with('error', 'No se puede eliminar: el producto ya tiene ventas registradas.');
        }

        Log::channel('productos')->info('Producto eliminado', $datos);

        return redirect()->route('productos.index')->with('exito', 'Producto eliminado correctamente.');
    }
}