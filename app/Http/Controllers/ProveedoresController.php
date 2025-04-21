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
                'id' => $servicio->id,
                'nombre' => $servicio->nombre,
                'descripcion' => $servicio->descripcion,
                'codigo' => $servicio->codigo,
                'precio' => $servicio->precio,
                'stock' => $servicio->stock,
                'stock_minimo' => $servicio->stock_minimo,
                'fecha_vencimiento' => $servicio->fecha_vencimiento,
                'estado_general_id' => $servicio->estado_general_id,
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
                    'nombre' => $solicitud->estadoGeneral->nombre,
                    'id' => $solicitud->estadoGeneral->id
                ] : null,
                'mensaje_opcional' => $solicitud->mensaje_opcional,
                'fecha_solicitud' => $solicitud->fecha_solicitud,
                'fecha_respuesta' => $solicitud->fecha_respuesta,
                'estado_general_id' => $solicitud->estado_general_id,
            ];
        });

        return response()->json($solicitudes);
    }
}
