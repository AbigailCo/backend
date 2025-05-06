<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Solicitudes\SolicitudResource;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function mySolicitudesCliente($id)
    {
        
        $solicitudes = Solicitud::with(['cliente', 'proveedor', 'producto', 'servicio'])
        ->where('cliente_id', $id)
        ->get();
        return SolicitudResource::collection($solicitudes);
    }
}
