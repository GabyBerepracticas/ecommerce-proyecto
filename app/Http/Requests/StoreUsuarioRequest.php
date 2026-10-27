<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUsuarioRequest extends FormRequest
{
    // La autorización se realiza en el controlador con la UsuarioPolicy.
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:2', 'max:100'],
            'apellidos' => ['required', 'string', 'min:2', 'max:100'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,correo'],
            'clave' => ['required', 'string', 'min:3', 'max:100'],
            'rol' => ['required', Rule::in(Usuario::ROLES)],
        ];
    }
}