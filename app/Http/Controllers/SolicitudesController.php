<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstadoGeneral;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class SolicitudesController extends Controller
{
    public function storeSolicitud(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'nullable|exists:users,id',
            'proveedor_id' => 'nullable|exists:users,id',
            'producto_id' => 'nullable|exists:productos,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            // 'fecha_solicitud' => 'nullable|date',
            // 'fecha_respuesta' => 'nullable|date',
        ]);
        $estadoActivo = EstadoGeneral::where('value', 'pend')->first();
        $data['fecha_solicitud'] = now()->format('Y-m-d');
        $solicitud = Solicitud::create($validatedData);

        return response()->json([
            'message' => 'Solicitud creada exitosamente',
            'solicitud' => $solicitud,
        ]);
    }
}
