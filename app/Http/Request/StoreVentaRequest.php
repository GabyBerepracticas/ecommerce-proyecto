<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la VentaPolicy se aplica en el controlador
    }

    public function rules(): array
    {
        return [
            // El producto debe existir y tener existencia disponible
            'producto_id' => [
                'required', 'integer',
                Rule::exists('productos', 'id')->where('existencia', '>', 0),
            ],
            'fecha' => ['required', 'date', 'before_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'producto_id.exists' => 'El producto seleccionado no existe o ya no tiene existencia.',
        ];
    }
}