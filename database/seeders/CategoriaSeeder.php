<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Electrónica' => 'Dispositivos y accesorios electrónicos.',
            'Computación' => 'Equipos de cómputo y periféricos.',
            'Hogar' => 'Artículos para el hogar y la cocina.',
            'Deportes' => 'Equipo y ropa deportiva.',
            'Oficina' => 'Papelería y mobiliario de oficina.',
            'Ofertas' => 'Productos con precio especial.',
        ];

        foreach ($categorias as $nombre => $descripcion) {
            Categoria::updateOrCreate(['nombre' => $nombre], ['descripcion' => $descripcion]);
        }
    }
}