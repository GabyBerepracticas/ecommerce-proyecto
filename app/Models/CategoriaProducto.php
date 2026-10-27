<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo de la tabla pivote. Se usa como tabla intermedia del
 * hasManyThrough Usuario -> Productos -> categoria_producto.
 */
class CategoriaProducto extends Model
{
    protected $table = 'categoria_producto';

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = 'producto_id';

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}