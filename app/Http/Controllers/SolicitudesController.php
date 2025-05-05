<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Solicitud\SolicitudFiltroRequest;
use App\Http\Requests\Solicitud\SolicitudStoreRequest;
use App\Http\Resources\Solicitudes\SolicitudResource;
use App\Models\EstadoGeneral;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SolicitudesController extends Controller
{
    public function filtroSoli(SolicitudFiltroRequest $request)
    {
        $solicitudes = Solicitud::with(['cliente', 'producto', 'servicio', 'proveedor', 'estadoGeneral'])
            ->filtrar($request->validated())
            ->get();
    
        return SolicitudResource::collection($solicitudes);
    }
    public function storeSolicitud(SolicitudStoreRequest $request)
    {
        $validatedData = $request->validated();
        $estadoActivo = EstadoGeneral::where('value', 'pend')->first();
        $data = $validatedData;
        $data['fecha_solicitud'] = now()->format('Y-m-d');
        $data['estado_id'] = $estadoActivo->id;
        $solicitud = Solicitud::create($data);


        if (!empty($validatedData['producto_id'])) {
            $producto = Producto::find($validatedData['producto_id']);
            if ($producto && $producto->stock > 0) {
                $producto->stock -= 1;
                $producto->save();
            }
        }

        if (!empty($validatedData['servicio_id'])) {
            $servicio = Servicio::find($validatedData['servicio_id']);
            if ($servicio && $servicio->stock > 0) {
                $servicio->stock -= 1;
                $servicio->save();
            }
        }

        return response()->json([
            'message' => 'Solicitud creada exitosamente',
            'solicitud' => new SolicitudResource($solicitud),
        ]);
    }
    public function horariosReservados(Request $request, $id)
    {
        $fecha = $request->query('fecha');
        $horasOcupadas = Solicitud::where('servicio_id', $id)
            ->where('fecha_reserva', $fecha)
            ->pluck('hora_reserva');

        return response()->json($horasOcupadas);
    }
    public function aprobarSoli($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->estado_general_id = 5;
        $solicitud->save();

        return response()->json(['message' => 'Solicitud aprobada.']);
    }
    public function rechazarSoli($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->estado_general_id = 6;
        $solicitud->save();

        if ($solicitud->producto_id) {
            $producto = Producto::find($solicitud->producto_id);
            if ($producto) {
                $producto->stock += 1;
                $producto->save();
            }
        }

        if ($solicitud->servicio_id) {
            $servicio = Servicio::find($solicitud->servicio_id);
            if ($servicio) {
                $servicio->stock += 1;
                $servicio->save();
            }
        }

        return response()->json(['message' => 'Solicitud rechazada.']);
    }
    public function getSolicitud($id)
{
    $solicitud = Solicitud::findOrFail($id);
    return new SolicitudResource($solicitud);
}
}
