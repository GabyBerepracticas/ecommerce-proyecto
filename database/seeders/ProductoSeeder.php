<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // Los vendedores son el administrador y los gerentes
        $vendedores = Usuario::whereIn('rol', ['administrador', 'gerente'])->orderBy('id')->get();

        if ($vendedores->isEmpty()) {
            return;
        }

        // [nombre, descripción, precio, existencia, [categorías]]
        $productos = [
            ['Laptop 14 pulgadas', 'Laptop ligera con 8 GB de RAM y SSD de 256 GB.', 11999.00, 10, ['Computación', 'Electrónica']],
            ['Mouse inalámbrico', 'Mouse ergonómico con receptor USB.', 249.50, 40, ['Computación', 'Oficina']],
            ['Teclado mecánico', 'Teclado mecánico retroiluminado.', 899.00, 15, ['Computación', 'Electrónica']],
            ['Audífonos Bluetooth', 'Audífonos con cancelación de ruido.', 1299.00, 25, ['Electrónica', 'Ofertas']],
            ['Licuadora 600 W', 'Licuadora con jarra de vidrio de 1.5 L.', 799.00, 12, ['Hogar']],
            ['Balón de fútbol', 'Balón oficial número 5.', 349.00, 30, ['Deportes', 'Ofertas']],
            ['Silla de oficina', 'Silla con soporte lumbar y ruedas.', 1899.00, 8, ['Oficina', 'Hogar']],
            ['Cuaderno profesional', 'Cuaderno de 100 hojas, pasta dura.', 59.90, 100, ['Oficina', 'Ofertas']],
        ];

        foreach ($productos as $i => [$nombre, $descripcion, $precio, $existencia, $categorias]) {
            $producto = Producto::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'descripcion' => $descripcion,
                    'precio' => $precio,
                    'existencia' => $existencia,
                    'usuario_id' => $vendedores[$i % $vendedores->count()]->id,
                ]
            );

            $ids = Categoria::whereIn('nombre', $categorias)->pluck('id');
            $producto->categorias()->sync($ids);
        }
    }
}