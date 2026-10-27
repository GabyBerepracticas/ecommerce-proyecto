<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la ProductoPolicy se aplica en el controlador
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:3', 'max:255', 'unique:productos,nombre'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'precio' => ['required', 'numeric', 'min:0.01', 'max:99999999'],
            'existencia' => ['required', 'integer', 'min:0', 'max:1000000'],
            'categorias' => ['required', 'array', 'min:1'],
            'categorias.*' => ['integer', 'exists:categorias,id'],
        ];
    }
}