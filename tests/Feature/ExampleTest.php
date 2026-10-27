<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_la_raiz_es_publica_y_muestra_botones_de_acceso(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Iniciar sesión')
            ->assertSee('Registrarse');
    }
}