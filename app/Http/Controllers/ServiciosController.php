<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    public function getServicios()
    {
        $servicios = Servicio::with('categoria')->get()->map(function ($servicio) {
            return [
                'id' => $servicio->id,
                'nombre' => $servicio->nombre,
                'descripcion' => $servicio->descripcion,
                'codigo' => $servicio->codigo,
                'precio' => $servicio->precio,
                'stock' => $servicio->stock,
                'stock_minimo' => $servicio->stock_minimo,
                'fecha_vencimiento' => $servicio->fecha_vencimiento,
                'categoria_id' => $servicio->categoria_id,
                'categoria' => $servicio->categoria ? [
                    'id' => $servicio->categoria->id,
                    'nombre' => $servicio->categoria->nombre,
                    'label' => $servicio->categoria->label,
                    'value' => $servicio->categoria->value,
                    'descripcion' => $servicio->categoria->descripcion,
                ] : null,
            ];
        });
       
        return response()->json($servicios);
    }
}
