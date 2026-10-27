<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // formulario público
    }

    public function rules(): array
    {
        return [
            'correo' => ['required', 'string', 'email'],
            'clave' => ['required', 'string'],
        ];
    }
}