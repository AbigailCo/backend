<?php

namespace App\Http\Resources\Reserva;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'proveedor_id' => $this->proveedor_id,
            'servicio_id' => $this->servicio_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'estado_general_id' => $this->estado_general_id,
        ];
    }
}
