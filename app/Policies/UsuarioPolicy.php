<?php

namespace App\Policies;

use App\Models\Usuario;

class UsuarioPolicy
{
    /** Listar usuarios: administrador y gerente. */
    public function viewAny(Usuario $actor): bool
    {
        return $actor->esAdministrador() || $actor->esGerente();
    }

    public function view(Usuario $actor, Usuario $modelo): bool
    {
        return $this->viewAny($actor) || $actor->id === $modelo->id;
    }

    /** Solo el administrador crea usuarios. */
    public function create(Usuario $actor): bool
    {
        return $actor->esAdministrador();
    }

    /**
     * Administrador: edita a cualquiera.
     * Gerente: solo edita clientes (no gerentes ni administradores).
     */
    public function update(Usuario $actor, Usuario $modelo): bool
    {
        if ($actor->esAdministrador()) {
            return true;
        }

        if ($actor->esGerente()) {
            return $modelo->esCliente();
        }

        return false;
    }

    /** Solo el administrador elimina, y nunca a sí mismo. */
    public function delete(Usuario $actor, Usuario $modelo): bool
    {
        return $actor->esAdministrador() && $actor->id !== $modelo->id;
    }

    /** Solo el administrador puede cambiar el rol de un usuario. */
    public function cambiarRol(Usuario $actor, Usuario $modelo): bool
    {
        return $actor->esAdministrador();
    }
}