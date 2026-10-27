<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Venta;

class VentaPolicy
{
    /** El listado se filtra por rol con Venta::visiblesPara(). */
    public function viewAny(Usuario $actor): bool
    {
        return true;
    }

    /** Ve la venta el administrador, su cliente o su vendedor. */
    public function view(Usuario $actor, Venta $venta): bool
    {
        return $actor->esAdministrador()
            || $venta->cliente_id === $actor->id
            || $venta->vendedor_id === $actor->id;
    }

    /** Comprar es acción del cliente. */
    public function create(Usuario $actor): bool
    {
        return $actor->esCliente();
    }

    public function update(Usuario $actor, Venta $venta): bool
    {
        return $actor->esAdministrador();
    }

    public function delete(Usuario $actor, Venta $venta): bool
    {
        return $actor->esAdministrador();
    }
}