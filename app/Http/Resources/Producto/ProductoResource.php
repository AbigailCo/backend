<?php

namespace App\Http\Resources\Producto;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
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
            'producto' => $this ? [
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
                'estado_general_id' => $this->estado_general_id,
                'created_at' => $this->created_at,
            ] : null,
            'categoria' => $this->categoria ? [
                'nombre' => $this->categoria->nombre,
                'id' => $this->categoria->id,
                'descripcion' => $this->categoria->descripcion,
            ] : null,
            'estado' => $this->estado ? [
                'id' => $this->estado->id,
                'nombre' => $this->estado->nombre,
            ] : null,
        ];
    }
}
