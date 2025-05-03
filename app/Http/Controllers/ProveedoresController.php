<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedoresController extends Controller
{
    public function myProductos($id)
    {
        
        $productos = Producto::with('categoria')->where('proveedor_id', $id)->get()->map(function ($producto) {
            return [
                'producto' => $producto ? [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'codigo' => $producto->codigo,
                    'stock' => $producto->stock,
                    'precio' => $producto->precio,
                    'descripcion' => $producto->descripcion,
                ] : null,
               

                'proveedor' => $producto->proveedor ? [
                    'nombre' => $producto->proveedor->name,
                    'contacto' => $producto->proveedor->email,
                ] : null,
                'categoria' => $producto->categoria ? [
                    'nombre' => $producto->categoria->nombre,
                    'descripcion' => $producto->categoria->descripcion,
                ] : null,
                'estado' => $producto->estado ? [
                    'id' => $producto->estado->id,
                    'nombre' => $producto->estado->nombre,
                ] : null,
            ];
        });
        return response()->json($productos);
    }
    public function myServicios($id)
    {
        
        $servicios = Servicio::with('categoria')->where('proveedor_id', $id)->get()->map(function ($servicio) {
            return [
                'servicio' => $servicio ? [
                    'id' => $servicio->id,
                    'nombre' => $servicio->nombre,
                    'codigo' => $servicio->codigo,
                    'stock' => $servicio->stock,
                    'stock_minimo' => $servicio->stock_minimo,
                    'precio' => $servicio->precio,
                    'descripcion' => $servicio->descripcion,
                ] : null,

                'proveedor' => $servicio->proveedor ? [
                    'nombre' => $servicio->proveedor->name,
                    'contacto' => $servicio->proveedor->email,
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

    public function mySolicitudes($id)
    {
        
        $solicitudes = Solicitud::with(['cliente', 'proveedor', 'producto', 'servicio'])
        ->where('proveedor_id', $id)
        ->get()
        ->map(function ($solicitud) {
            return [
                'id' => $solicitud->id,
                'cliente' => $solicitud->cliente ? [
                    'id' => $solicitud->cliente->id,
                    'nombre' => $solicitud->cliente->name,
                    'contacto' => $solicitud->cliente->email,
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
                    'nombre' => $solicitud->estadoGeneral->nombre,
                    'id' => $solicitud->estadoGeneral->id
                ] : null,
                'mensaje_opcional' => $solicitud->mensaje_opcional,
                'fecha_reserva' => $solicitud->fecha_reserva,
                'hora_reserva' => $solicitud->hora_reserva,
                'fecha_solicitud' => $solicitud->fecha_solicitud,
                'fecha_respuesta' => $solicitud->fecha_respuesta,
                'estado_general_id' => $solicitud->estado_general_id,
            ];
        });

        return response()->json($solicitudes);
    }
}
