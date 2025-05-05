<?php

namespace App\Http\Requests\Producto;

use Illuminate\Foundation\Http\FormRequest;

class ProductoFiltroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'nullable|string',
            'codigo' => 'nullable|string',
            'stock_minimo' => 'nullable|integer',
            'estado_general' => 'nullable|string',
            'fecha_vencimiento' => 'nullable|date',
            'producto_id' => 'nullable|integer',
            'categoria_id' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_array($value) && !is_numeric($value)) {
                        $fail('El campo categoría debe ser un ID o una lista de IDs.');
                    }
                },
            ],
            'proveedor_nombre' => 'nullable|string',
        ];
    }
}
