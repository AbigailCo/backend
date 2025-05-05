<?php

namespace App\Http\Requests\Producto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductoEditRequest extends FormRequest
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
       // Obtenemos el ID del servicio desde la ruta
    $productoId = $this->route('id'); // o el nombre de parámetro de ruta

    return [
        'proveedor_id' => 'nullable|exists:users,id',
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:255',
        'codigo' => [
            'required',
            'string',
            'max:255',
            Rule::unique('productos', 'codigo')->ignore($productoId),
        ],
        'precio' => 'nullable|integer|min:0',
        'stock' => 'nullable|integer|min:0',
        'stock_minimo' => 'nullable|integer|min:0',
        'fecha_vencimiento' => 'nullable|date',
        'categoria_id' => 'nullable|exists:categorias,id',
    ];
    }
}
