<?php

return [
    'array' => 'El campo :attribute debe ser una lista.',
    'before_or_equal' => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'confirmed' => 'La confirmación del campo :attribute no coincide.',
    'date' => 'El campo :attribute no es una fecha válida.',
    'email' => 'El campo :attribute debe ser un correo válido.',
    'exists' => 'El valor seleccionado en :attribute no es válido.',
    'in' => 'El valor seleccionado en :attribute no es válido.',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'max' => [
        'array' => 'El campo :attribute no debe tener más de :max elementos.',
        'numeric' => 'El campo :attribute no debe ser mayor a :max.',
        'string' => 'El campo :attribute no debe tener más de :max caracteres.',
    ],
    'min' => [
        'array' => 'El campo :attribute debe tener al menos :min elementos.',
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'numeric' => 'El campo :attribute debe ser un número.',
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser texto.',
    'unique' => 'El valor de :attribute ya está registrado.',

    'attributes' => [
        'nombre' => 'nombre',
        'apellidos' => 'apellidos',
        'correo' => 'correo',
        'clave' => 'contraseña',
        'clave_confirmation' => 'confirmación de contraseña',
        'rol' => 'rol',
        'descripcion' => 'descripción',
        'precio' => 'precio',
        'existencia' => 'existencia',
        'categorias' => 'categorías',
        'categorias.*' => 'categoría',
        'producto_id' => 'producto',
        'fecha' => 'fecha',
        'total' => 'total',
    ],
];