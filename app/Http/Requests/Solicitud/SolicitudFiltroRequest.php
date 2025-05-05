<?php

namespace App\Http\Requests\Solicitud;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudFiltroRequest extends FormRequest
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
            'proveedor_id' => 'nullable|exists:users,id',
            'cliente_id' => 'nullable|exists:users,id',
            'nombre' => 'nullable|string',
            'codigo' => 'nullable|string',
            'stock_minimo' => 'nullable|integer',
            'cliente' => 'nullable|string',
            'estado_general' => 'nullable|string',
            'fecha_vencimiento' => 'nullable|date',
            'producto_id' => 'nullable|exists:productos,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'categoria_id' => 'nullable|exists:categorias,id',
        ];
    }
}
