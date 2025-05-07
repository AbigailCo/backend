<?php

namespace App\Http\Requests\Solicitud;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudStoreRequest extends FormRequest
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
            'cliente_id' => 'nullable|exists:users,id',
            'proveedor_id' => 'nullable|exists:users,id',
            'producto_id' => 'nullable|exists:productos,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'categoria_id' => 'nullable|exists:categoria,id',
            'fecha_reserva' => 'nullable|regex:/^\d{4}-\d{2}-\d{2}$/',
            'hora_reserva'  => 'nullable|regex:/^\d{2}:\d{2}$/',
            'notas'          => 'nullable|string|max:1000',
            'fecha_inicio_reserva' => 'nullable|date',
            'fecha_fin_reserva' => 'nullable|date|after:fecha_inicio_reserva',
        ];
    }
}
