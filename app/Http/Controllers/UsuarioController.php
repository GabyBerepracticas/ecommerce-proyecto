<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Usuario::class);

        return view('usuarios.index', [
            'usuarios' => Usuario::orderBy('id')->paginate(10),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Usuario::class);

        return view('usuarios.create');
    }

    public function store(StoreUsuarioRequest $request): RedirectResponse
    {
        $this->authorize('create', Usuario::class);

        Usuario::create($request->validated());

        return redirect()->route('usuarios.index')->with('exito', 'Usuario creado correctamente.');
    }

    public function show(Usuario $usuario): View
    {
        $this->authorize('view', $usuario);

        return view('usuarios.show', [
            'usuario' => $usuario->load('productos'),
            'categorias' => $usuario->categorias(), // hasManyThrough
        ]);
    }

    public function edit(Usuario $usuario): View
    {
        $this->authorize('update', $usuario);

        return view('usuarios.edit', compact('usuario'));
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario): RedirectResponse
    {
        $this->authorize('update', $usuario);

        $datos = $request->validated();

        // Solo quien tenga permiso (la policy) puede cambiar el rol
        if ($request->user()->cannot('cambiarRol', $usuario)) {
            unset($datos['rol']);
        }

        // Clave vacía = no se modifica
        if (blank($datos['clave'] ?? null)) {
            unset($datos['clave']);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')->with('exito', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario): RedirectResponse
    {
        $this->authorize('delete', $usuario);

        try {
            $usuario->delete();
        } catch (QueryException) {
            return back()->with('error', 'No se puede eliminar: el usuario tiene productos o ventas asociados.');
        }

        return redirect()->route('usuarios.index')->with('exito', 'Usuario eliminado correctamente.');
    }
}