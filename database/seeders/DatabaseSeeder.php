<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => 'password', 'role' => 'cliente']
        );

        User::updateOrCreate(
            ['email' => 'gerente@example.com'],
            ['name' => 'Gerente Demo', 'password' => 'password', 'role' => 'gerente']
        );

        User::updateOrCreate(
            ['email' => 'empleado@example.com'],
            ['name' => 'Empleado Demo', 'password' => 'password', 'role' => 'empleado']
        );
    }
}
