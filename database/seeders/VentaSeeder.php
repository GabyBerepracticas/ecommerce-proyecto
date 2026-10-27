<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\Database\Seeder;

class VentaSeeder extends Seeder
{
    public function run(): void
    {
        // Evita duplicar ventas si se vuelve a ejecutar el seeder
        if (Venta::exists()) {
            return;
        }

        $clientes = Usuario::where('rol', 'cliente')->orderBy('id')->get();
        $productos = Producto::where('existencia', '>', 0)->orderBy('id')->get();

        if ($clientes->isEmpty() || $productos->isEmpty()) {
            return;
        }

        foreach (range(0, 4) as $i) {
            $producto = $productos[$i % $productos->count()];
            $cliente = $clientes[$i % $clientes->count()];

            Venta::create([
                'producto_id' => $producto->id,
                'vendedor_id' => $producto->usuario_id,
                'cliente_id' => $cliente->id,
                'fecha' => now()->subDays($i)->toDateString(),
                'total' => $producto->precio,
            ]);

            $producto->decrement('existencia');
        }
    }
}