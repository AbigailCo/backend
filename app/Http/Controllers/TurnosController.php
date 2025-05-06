<?php

namespace App\Http\Controllers;

use App\Http\Resources\Servicio\ServicioResource;
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
        ->get();
        return ServicioResource::collection($servicios);
    }
   
}
