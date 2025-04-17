<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedoresController extends Controller
{
    public function myProductos($id)
    {
        
        $productos = Producto::with('categoria')->where('proveedor_id', $id)->get()->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'codigo' => $producto->codigo,
                'precio' => $producto->precio,
                'stock' => $producto->stock,
                'stock_minimo' => $producto->stock_minimo,
                'fecha_vencimiento' => $producto->fecha_vencimiento,
                'estado_general_id' => $producto->estado_general_id,
                'categoria_id' => $producto->categoria_id,
                'categoria' => $producto->categoria ? [
                    'id' => $producto->categoria->id,
                    'nombre' => $producto->categoria->nombre,
                    'label' => $producto->categoria->label,
                    'value' => $producto->categoria->value,
                    'descripcion' => $producto->categoria->descripcion,
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
}
