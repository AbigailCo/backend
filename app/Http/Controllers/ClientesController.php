<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function mySolicitudesCliente($id)
    {
        
        $solicitudes = Solicitud::with(['cliente', 'proveedor', 'producto', 'servicio'])
        ->where('cliente_id', $id)
        ->get()
        ->map(function ($solicitud) {
            return [
                'id' => $solicitud->id,
                'cliente' => $solicitud->cliente ? [
                    'id' => $solicitud->cliente->id,
                    'name' => $solicitud->cliente->name,
                    'email' => $solicitud->cliente->email,
                ] : null,
                'producto' => $solicitud->producto ? [
                    'id' => $solicitud->producto->id,
                    'nombre' => $solicitud->producto->nombre,
                    'precio' => $solicitud->producto->precio,
                    'stock' => $solicitud->producto->stock,
                ] : null,
                'servicio' => $solicitud->servicio ? [
                    'id' => $solicitud->servicio->id,
                    'nombre' => $solicitud->servicio->nombre,
                    'precio' => $solicitud->servicio->precio,
                    'stock' => $solicitud->servicio->stock,
                ] : null,
                'estado' => $solicitud->estadoGeneral ? [
                    'id' => $solicitud->estadoGeneral->id,
                    'nombre' => $solicitud->estadoGeneral->nombre,
                ] : null,
                'mensaje_opcional' => $solicitud->mensaje_opcional,
                'fecha_solicitud' => $solicitud->fecha_solicitud,
                'fecha_respuesta' => $solicitud->fecha_respuesta,
               
            ];
        });

        return response()->json($solicitudes);
    }
}
