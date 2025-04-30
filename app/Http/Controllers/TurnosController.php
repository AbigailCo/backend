<?php

namespace App\Http\Controllers;

use App\Models\EstadoGeneral;
use App\Models\Servicio;
use Illuminate\Http\Request;

class TurnosController extends Controller
{
    public function getTurnos()
    {
        $servicios = Servicio::with('categoria', 'proveedor', 'estadoGeneral', 'diasDisponibles')
        ->where('estado_general_id', 1)
        ->where('fecha_vencimiento', '>=', now())
        ->where('categoria_id', 6)
        ->get()->map(function ($servicio) {
            return [
                'servicio' => $servicio ? [
                    'id' => $servicio->id,
                    'nombre' => $servicio->nombre,
                    'codigo' => $servicio->codigo,
                    'stock' => $servicio->stock,
                    'stock_minimo' => $servicio->stock_minimo,
                    'precio' => $servicio->precio,
                    'descripcion' => $servicio->descripcion,
                    'proveedor_id' => $servicio->proveedor_id,
                    'fecha_vencimiento' => $servicio->fecha_vencimiento,
                    'horarios' => $servicio->horarios,
                    'dias_disponibles' => $servicio->diasDisponibles ? $servicio->diasDisponibles->map(function ($dia) {
                        return [
                            'nombre' => $dia->nombre,
                            'value' => $dia->value,
                            'id' => $dia->id,
                        ];
                    }) : [],
                    'categoria' => $servicio->categoria ? [
                        'nombre' => $servicio->categoria->nombre,
                        'descripcion' => $servicio->categoria->descripcion,
                    ] : null,
                ] : null,

                'proveedor' => $servicio->proveedor ? [
                    'nombre' => $servicio->proveedor->name,
                    'contacto' => $servicio->proveedor->email,
                    'proveedor_id' => $servicio->proveedor->id,
                ] : null,
                'categoria' => $servicio->categoria ? [
                    'nombre' => $servicio->categoria->nombre,
                    'descripcion' => $servicio->categoria->descripcion,
                ] : null,



                'estado' => $servicio->estadoGeneral ? [
                    'id' => $servicio->estadoGeneral->id,
                    'nombre' => $servicio->estadoGeneral->nombre,
                ] : null,
            ];
        });
        return response()->json($servicios);
    }
   
}
