<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Producto\ProductoResource;
use App\Http\Resources\Servicio\ServicioResource;
use App\Http\Resources\Solicitudes\SolicitudResource;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedoresController extends Controller
{
    public function myProductos($id)
    {
        
        $productos = Producto::with('categoria')->where('proveedor_id', $id)->get();
        return ProductoResource::collection($productos);
    }
    public function myServicios($id)
    {
        $servicios = Servicio::with('categoria')->where('proveedor_id', $id)->get();
        return ServicioResource::collection($servicios);
    }

    public function mySolicitudes($id)
    {
        
        $solicitudes = Solicitud::with(['cliente', 'proveedor', 'producto', 'servicio'])
        ->where('proveedor_id', $id)
        ->get();
        return SolicitudResource::collection($solicitudes);
    }
}
