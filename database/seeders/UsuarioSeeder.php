<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // [nombre, apellido, rol]. Los correos son únicos: inicial + apellido.
        $usuarios = [
            ['Juan', 'Lopez', 'administrador'],   // jlopez@tuxtla.tecnm.mx
            ['Mario', 'Sanchez', 'gerente'],      // msanchez@tuxtla.tecnm.mx
            ['Maria', 'Hernandez', 'gerente'],    // mhernandez@tuxtla.tecnm.mx
            ['Pedro', 'Martinez', 'cliente'],     // pmartinez@tuxtla.tecnm.mx
            ['Pedro', 'Lopez', 'cliente'],        // plopez@tuxtla.tecnm.mx
            ['Maria', 'Martinez', 'cliente'],     // mmartinez@tuxtla.tecnm.mx
            ['Juan', 'Sanchez', 'cliente'],       // jsanchez@tuxtla.tecnm.mx
        ];

        foreach ($usuarios as [$nombre, $apellido, $rol]) {
            $correo = \Database\Factories\UsuarioFactory::correoPara($nombre, $apellido);

            if (Usuario::where('correo', $correo)->exists()) {
                continue;
            }

            Usuario::factory()
                ->conNombre($nombre, $apellido)
                ->state(['rol' => $rol])
                ->create();
        }
    }
}