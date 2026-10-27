<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['nombre', 'descripcion'])]
class Categoria extends Model
{
    protected $table = 'categorias';

    /** Una categoría puede tener muchos productos. */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'categoria_producto', 'categoria_id', 'producto_id');
    }
}