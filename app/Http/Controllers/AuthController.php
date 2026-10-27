<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Login manual (sin Breeze/Jetstream/UI).
 */
class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        // La llave "password" es la que espera Auth::attempt; su valor viene del campo "clave".
        $credenciales = [
            'correo' => $request->input('correo'),
            'password' => $request->input('clave'),
        ];

        if (Auth::attempt($credenciales, $request->boolean('recordar'))) {
            $request->session()->regenerate();

            $usuario = Auth::user();

            Log::channel('autenticacion')->info('Login exitoso', [
                'usuario_id' => $usuario->id,
                'correo' => $usuario->correo,
                'rol' => $usuario->rol,
                'ip' => $request->ip(),
            ]);

            return redirect()->intended(route('dashboard'));
        }

        Log::channel('autenticacion')->warning('Login incorrecto', [
            'correo' => $request->input('correo'),
            'ip' => $request->ip(),
        ]);

        return back()
            ->withErrors(['correo' => 'Las credenciales no coinciden con nuestros registros.'])
            ->onlyInput('correo');
    }

    public function showRegistro(): View
    {
        return view('auth.registro');
    }

    /** Registro público: siempre crea un usuario con rol cliente. */
    public function registro(RegistroRequest $request): RedirectResponse
    {
        $usuario = Usuario::create([
            ...$request->safe()->only(['nombre', 'apellidos', 'correo', 'clave']),
            'rol' => Usuario::ROL_CLIENTE,
        ]);

        Auth::login($usuario);
        $request->session()->regenerate();

        Log::channel('autenticacion')->info('Registro de cliente', [
            'usuario_id' => $usuario->id,
            'correo' => $usuario->correo,
            'ip' => $request->ip(),
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $usuario = Auth::user();

        Log::channel('autenticacion')->info('Logout', [
            'usuario_id' => $usuario?->id,
            'correo' => $usuario?->correo,
            'ip' => $request->ip(),
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}