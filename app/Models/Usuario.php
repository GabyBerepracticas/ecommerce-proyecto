<?php

namespace App\Models;

use Database\Factories\UsuarioFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['nombre', 'apellidos', 'correo', 'clave', 'rol'])]
#[Hidden(['clave', 'remember_token'])]
class Usuario extends Authenticatable
{
    /** @use HasFactory<UsuarioFactory> */
    use HasFactory;

    protected $table = 'usuarios';

    public const ROL_ADMINISTRADOR = 'administrador';
    public const ROL_GERENTE = 'gerente';
    public const ROL_CLIENTE = 'cliente';

    public const ROLES = [self::ROL_ADMINISTRADOR, self::ROL_GERENTE, self::ROL_CLIENTE];

    protected function casts(): array
    {
        return [
            'clave' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Autenticación: la contraseña vive en la columna "clave"
    |--------------------------------------------------------------------------
    | Auth::attempt() compara la contraseña recibida contra lo que devuelva
    | getAuthPassword(), por eso se redefine para apuntar a "clave".
    */
    public function getAuthPassword(): string
    {
        return $this->clave;
    }

    public function getAuthPasswordName(): string
    {
        return 'clave';
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    protected function nombreCompleto(): Attribute
    {
        return Attribute::get(fn () => $this->nombre.' '.$this->apellidos);
    }

    public function esAdministrador(): bool
    {
        return $this->rol === self::ROL_ADMINISTRADOR;
    }

    public function esGerente(): bool
    {
        return $this->rol === self::ROL_GERENTE;
    }

    public function esCliente(): bool
    {
        return $this->rol === self::ROL_CLIENTE;
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    /** Un usuario (vendedor) puede vender muchos productos. */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'usuario_id');
    }

    /** Ventas en las que el usuario participó como cliente. */
    public function ventasComoCliente(): HasMany
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }

    /** Ventas en las que el usuario participó como vendedor. */
    public function ventasComoVendedor(): HasMany
    {
        return $this->hasMany(Venta::class, 'vendedor_id');
    }

    /**
     * hasManyThrough: Usuario -> Productos -> filas de categoria_producto.
     *
     * Producto y Categoria son muchos a muchos, así que el "puente" real hacia
     * las categorías es la tabla pivote (modelo CategoriaProducto).
     */
    public function categoriasProducto(): HasManyThrough
    {
        return $this->hasManyThrough(
            CategoriaProducto::class, // modelo final
            Producto::class,          // modelo intermedio
            'usuario_id',             // FK en productos -> usuarios
            'producto_id'             // FK en categoria_producto -> productos
        );
    }

    /**
     * Categorías (sin repetir) en las que el usuario vende, a través de sus productos.
     */
    public function categorias(): Collection
    {
        $ids = $this->categoriasProducto()->get()->pluck('categoria_id')->unique();

        return Categoria::whereIn('id', $ids)->orderBy('nombre')->get();
    }
}