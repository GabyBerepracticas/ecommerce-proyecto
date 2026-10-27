<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:2', 'max:100'],
            'apellidos' => ['required', 'string', 'min:2', 'max:100'],
            'correo' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('usuarios', 'correo')->ignore($this->route('usuario')),
            ],
            // Si viene vacía, no se cambia la contraseña
            'clave' => ['nullable', 'string', 'min:3', 'max:100'],
            'rol' => ['sometimes', Rule::in(Usuario::ROLES)],
        ];
    }
}