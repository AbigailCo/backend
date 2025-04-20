<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstadoGeneral;
use App\Models\Producto;
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

        return response()->json(['message' => 'Solicitud rechazada.']);
    }
    public function getSolicitud($id)
    {
        $solcitud = Solicitud::findOrFail($id);
        return [
            'id' => $solcitud->id,
            'cliente' => $solcitud->cliente ? [
                'nombre' =>  $solcitud->cliente->name,
                'contacto' => $solcitud->cliente->email
            ] : null,

            'proveedor' => $solcitud->proveedor ? [
                'nombre' =>  $solcitud->proveedor->name,
                'contacto' => $solcitud->proveedor->email
            ] : null,

            'producto' => $solcitud->producto ? [
                'nombre' =>  $solcitud->producto->nombre,
                'codigo' => $solcitud->producto->codigo,
                'stock' => $solcitud->producto->stock,
                'precio' => $solcitud->Producto->precio,
            ] : null,
           'estado' =>  $solcitud->estadoGeneral->nombre,

        ];
    }
}
