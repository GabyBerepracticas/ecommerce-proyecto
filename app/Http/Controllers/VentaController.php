<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class VentaController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Venta::class);

        return view('ventas.index', [
            'ventas' => Venta::visiblesPara($request->user())
                ->with(['producto', 'cliente', 'vendedor'])
                ->orderByDesc('fecha')
                ->orderByDesc('id')
                ->paginate(10),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Venta::class);

        return view('ventas.create', [
            'productos' => Producto::with('usuario')->where('existencia', '>', 0)->orderBy('nombre')->get(),
            'seleccionado' => $request->integer('producto'),
        ]);
    }

    public function store(StoreVentaRequest $request): RedirectResponse
    {
        $this->authorize('create', Venta::class);

        $venta = DB::transaction(function () use ($request) {
            $producto = Producto::lockForUpdate()->findOrFail($request->validated('producto_id'));

            if ($producto->existencia < 1) {
                throw ValidationException::withMessages([
                    'producto_id' => 'El producto ya no tiene existencia.',
                ]);
            }

            $producto->decrement('existencia');

            return Venta::create([
                'producto_id' => $producto->id,
                'vendedor_id' => $producto->usuario_id,   // el vendedor es el dueño del producto
                'cliente_id' => $request->user()->id,     // el cliente es quien compra
                'fecha' => $request->validated('fecha'),
                'total' => $producto->precio,
            ]);
        });

        Log::channel('ventas')->info('Venta creada', [
            'venta_id' => $venta->id,
            'producto_id' => $venta->producto_id,
            'cliente_id' => $venta->cliente_id,
            'vendedor_id' => $venta->vendedor_id,
            'total' => $venta->total,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('ventas.show', $venta)->with('exito', 'Venta registrada correctamente.');
    }

    public function show(Venta $venta): View
    {
        $this->authorize('view', $venta);

        return view('ventas.show', [
            'venta' => $venta->load(['producto', 'cliente', 'vendedor']),
        ]);
    }

    public function edit(Venta $venta): View
    {
        $this->authorize('update', $venta);

        return view('ventas.edit', [
            'venta' => $venta->load(['producto', 'cliente', 'vendedor']),
        ]);
    }

    public function update(UpdateVentaRequest $request, Venta $venta): RedirectResponse
    {
        $this->authorize('update', $venta);

        $venta->update($request->validated());

        Log::channel('ventas')->info('Venta actualizada', [
            'venta_id' => $venta->id,
            'usuario_id' => $request->user()->id,
            'total' => $venta->total,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('ventas.show', $venta)->with('exito', 'Venta actualizada correctamente.');
    }

    public function destroy(Request $request, Venta $venta): RedirectResponse
    {
        $this->authorize('delete', $venta);

        DB::transaction(function () use ($venta) {
            // Al anular la venta, el producto recupera su existencia
            $venta->producto()->increment('existencia');
            $venta->delete();
        });

        Log::channel('ventas')->info('Venta eliminada', [
            'venta_id' => $venta->id,
            'usuario_id' => $request->user()->id,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('ventas.index')->with('exito', 'Venta eliminada correctamente.');
    }
}