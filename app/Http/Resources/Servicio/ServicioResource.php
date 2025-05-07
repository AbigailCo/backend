<?php

namespace App\Http\Resources\Servicio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           
            'proveedor' => $this->proveedor ? [
                'nombre' => $this->proveedor->name,
                'contacto' => $this->proveedor->email,
                'proveedor_id' => $this->proveedor->id,
            ] : null,
            'servicio' => $this ? [
                'id' => $this->id,
                'proveedor_id' => $this->proveedor_id,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'codigo' => $this->codigo,
                'precio' => $this->precio,
                'stock' => $this->stock,
                'stock_minimo' => $this->stock_minimo,
                'fecha_vencimiento' => $this->fecha_vencimiento,
                'categoria_id' => $this->categoria_id,
                'tipo' => $this->tipo,
                'duracion' => $this->duracion,
                'ubicacion' => $this->ubicacion,
               'horarios' => $this->horarios,
              'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'estado_general_id' => $this->estado_general_id,
                'created_at' => $this->created_at,
            ] : null,
            'categoria' => $this->categoria ? [
                'nombre' => $this->categoria->nombre,
                'id' => $this->categoria->id,
                'descripcion' => $this->categoria->descripcion,
            ] : null,
            'estado' => $this->estadoGeneral ? [
                'id' => $this->estadoGeneral->id,
                'nombre' => $this->estadoGeneral->nombre,
            ] : null,
            'dias_disponibles' => $this->diasDisponibles ? $this->diasDisponibles->map(function ($dia) {
                return [
                    'id' => $dia->id,
                    'nombre' => $dia->nombre,
                    'value' => $dia->value,
                ];
            }) : [],
        ];
    }
}
