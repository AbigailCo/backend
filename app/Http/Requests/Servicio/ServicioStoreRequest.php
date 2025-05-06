<?php

namespace App\Http\Requests\Servicio;

use Illuminate\Foundation\Http\FormRequest;

class ServicioStoreRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'codigo' => 'required|string|max:255|unique:servicios,codigo',
            'precio' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'fecha_vencimiento' => 'nullable|date',
            'categoria_id' => 'nullable|exists:categorias,id',
            'tipo' => 'nullable|string|max:255',
            'duracion' => 'nullable|string|max:100',
            'ubicacion' => 'nullable|string|max:255',
            'horarios' => 'nullable|array',
            'horarios.*' => 'string|regex:/^\d{2}:\d{2}$/',
            'dias_disponibles' => 'nullable|array',
            'dias_disponibles.*' => 'integer|exists:dias_semana,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ];
    }
}
