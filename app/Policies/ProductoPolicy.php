<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\Usuario;

class ProductoPolicy
{
    /** Cualquier visitante (incluso sin sesión) puede ver productos. */
    public function viewAny(?Usuario $actor): bool
    {
        return true;
    }

    public function view(?Usuario $actor, Producto $producto): bool
    {
        return true;
    }

    /** Venden productos el administrador y el gerente. El cliente solo compra. */
    public function create(Usuario $actor): bool
    {
        return $actor->esAdministrador() || $actor->esGerente();
    }

    /** Administrador: cualquier producto. Gerente: solo los suyos. */
    public function update(Usuario $actor, Producto $producto): bool
    {
        return $actor->esAdministrador()
            || ($actor->esGerente() && $producto->usuario_id === $actor->id);
    }

    public function delete(Usuario $actor, Producto $producto): bool
    {
        return $this->update($actor, $producto);
    }
}