<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public const NOMBRES = ['Juan', 'Mario', 'Maria', 'Pedro'];

    public const APELLIDOS = ['Lopez', 'Sanchez', 'Hernandez', 'Martinez'];

    public function definition(): array
    {
        $nombre = $this->faker->randomElement(self::NOMBRES);
        $apellido = $this->faker->randomElement(self::APELLIDOS);

        return [
            'nombre' => $nombre,
            'apellidos' => $apellido,
            'correo' => self::correoPara($nombre, $apellido),
            'clave' => Hash::make('123'),
            'rol' => $this->faker->randomElement(['cliente', 'gerente']),
        ];
    }

    /** Correo institucional: inicial del nombre + apellido. Ej: jlopez@tuxtla.tecnm.mx */
    public static function correoPara(string $nombre, string $apellido): string
    {
        return strtolower(substr($nombre, 0, 1).$apellido).'@tuxtla.tecnm.mx';
    }

    /** Fija nombre y apellido y recalcula el correo para que coincida. */
    public function conNombre(string $nombre, string $apellido): static
    {
        return $this->state(fn () => [
            'nombre' => $nombre,
            'apellidos' => $apellido,
            'correo' => self::correoPara($nombre, $apellido),
        ]);
    }

    public function administrador(): static
    {
        return $this->state(['rol' => 'administrador']);
    }

    public function gerente(): static
    {
        return $this->state(['rol' => 'gerente']);
    }

    public function cliente(): static
    {
        return $this->state(['rol' => 'cliente']);
    }
}