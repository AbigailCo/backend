<?php

namespace App\Http\Resources\Solicitudes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitudResource extends JsonResource
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
            'fecha_reserva' => $this->fecha_reserva,
            'hora_reserva' => $this->hora_reserva,

            'cliente' => $this->cliente ? [
                'nombre' =>  $this->cliente->name,
                'contacto' => $this->cliente->email
            ] : null,

            'proveedor' => $this->proveedor ? [
                'nombre' =>  $this->proveedor->name,
                'contacto' => $this->proveedor->email
            ] : null,

            'producto' => $this->producto ? [
                'nombre' =>  $this->producto->nombre,
                'codigo' => $this->producto->codigo,
                'stock' => $this->producto->stock,
                'precio' => $this->producto->precio,
            ] : null,

            'servicio' => $this->servicio ? [
                'nombre' =>  $this->servicio->nombre,
                'codigo' => $this->servicio->codigo,
                'stock' => $this->servicio->stock,
                'precio' => $this->servicio->precio,
            ] : null,

            'estado' => $this->estadoGeneral ? [
                'id' => $this->estadoGeneral->id,
                'nombre' => $this->estadoGeneral->nombre,
            ] : null,
    
        ];
    }
}
