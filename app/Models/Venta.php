<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['producto_id', 'vendedor_id', 'cliente_id', 'fecha', 'total'])]
class Venta extends Model
{
    protected $table = 'ventas';

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'total' => 'decimal:2',
        ];
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'cliente_id');
    }

    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'vendedor_id');
    }

    /**
     * Limita el listado: el administrador ve todo, el gerente sus ventas
     * como vendedor y el cliente sus compras.
     */
    public function scopeVisiblesPara(Builder $query, Usuario $usuario): Builder
    {
        return match (true) {
            $usuario->esAdministrador() => $query,
            $usuario->esGerente() => $query->where('vendedor_id', $usuario->id),
            default => $query->where('cliente_id', $usuario->id),
        };
    }
}