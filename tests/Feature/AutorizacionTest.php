<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutorizacionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Las vistas usan @vite; en pruebas no hace falta compilar los assets
        $this->withoutVite();
    }

    public function test_invitado_es_redirigido_al_login(): void
    {
        $this->get('/productos')->assertRedirect('/login');
    }

    public function test_login_manual_con_credenciales_correctas(): void
    {
        $usuario = Usuario::factory()->conNombre('Juan', 'Lopez')->cliente()->create();

        $this->post('/login', ['correo' => $usuario->correo, 'clave' => '123'])
            ->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($usuario);
    }

    public function test_login_con_clave_incorrecta_falla(): void
    {
        $usuario = Usuario::factory()->conNombre('Juan', 'Lopez')->cliente()->create();

        $this->post('/login', ['correo' => $usuario->correo, 'clave' => 'mala'])
            ->assertSessionHasErrors('correo');

        $this->assertGuest();
    }

    public function test_cliente_no_puede_editar_productos(): void
    {
        $vendedor = Usuario::factory()->conNombre('Mario', 'Sanchez')->gerente()->create();
        $cliente = Usuario::factory()->conNombre('Pedro', 'Martinez')->cliente()->create();
        $producto = Producto::create([
            'nombre' => 'Mouse', 'precio' => 100, 'existencia' => 5, 'usuario_id' => $vendedor->id,
        ]);

        $this->actingAs($cliente)->get("/productos/{$producto->id}/edit")->assertForbidden();
    }

    public function test_gerente_edita_clientes_pero_no_gerentes(): void
    {
        $gerente = Usuario::factory()->conNombre('Mario', 'Sanchez')->gerente()->create();
        $otroGerente = Usuario::factory()->conNombre('Maria', 'Hernandez')->gerente()->create();
        $cliente = Usuario::factory()->conNombre('Pedro', 'Martinez')->cliente()->create();

        $this->actingAs($gerente)->get("/usuarios/{$cliente->id}/edit")->assertOk();
        $this->actingAs($gerente)->get("/usuarios/{$otroGerente->id}/edit")->assertForbidden();
    }

    public function test_solo_administrador_crea_usuarios(): void
    {
        $gerente = Usuario::factory()->conNombre('Mario', 'Sanchez')->gerente()->create();
        $admin = Usuario::factory()->conNombre('Juan', 'Lopez')->administrador()->create();

        $this->actingAs($gerente)->get('/usuarios/create')->assertForbidden();
        $this->actingAs($admin)->get('/usuarios/create')->assertOk();
    }
}