<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\Usuario;

class CategoriaPolicy
{
    public function viewAny(Usuario $actor): bool
    {
        return true;
    }

    public function view(Usuario $actor, Categoria $categoria): bool
    {
        return true;
    }

    public function create(Usuario $actor): bool
    {
        return $actor->esAdministrador() || $actor->esGerente();
    }

    public function update(Usuario $actor, Categoria $categoria): bool
    {
        return $actor->esAdministrador() || $actor->esGerente();
    }

    public function delete(Usuario $actor, Categoria $categoria): bool
    {
        return $actor->esAdministrador();
    }
}