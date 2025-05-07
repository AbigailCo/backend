<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reserva\ReservaStoreRequest;
use App\Http\Resources\Reserva\ReservaResource;
use App\Http\Resources\Servicio\ServicioResource;
use App\Models\EstadoGeneral;
use App\Models\Reserva;
use App\Models\Servicio;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class ReservasController extends Controller
{
    public function storeReserva(ReservaStoreRequest $request)
    {
        $validated = $request->validated();
        $estadoActivo = EstadoGeneral::where('value', 'pend')->first();

        $yaReservado = Reserva::where('proveedor_id', $request->proveedor_id)
            ->where('fecha_inicio', '<', $request->fecha_fin)
            ->where('fecha_fin', '>', $request->fecha_inicio)
            ->exists();

        if ($yaReservado) {
            return response()->json(['error' => 'El horario ya está reservado.'], 409);
        }
        $reserva = Reserva::create([
            ...$validated,
            'estado_general_id' => $estadoActivo->id,
        ]);
        return response()->json([
            'message' => 'Reserva creada exitosamente',
            'solicitud' => new ReservaResource($reserva),
        ]);
    }
    public function getReservas()
    {
        $servicios = Servicio::with('categoria', 'proveedor', 'estadoGeneral', 'diasDisponibles')
        ->where('estado_general_id', 1)
        ->where('categoria_id', 5)
        ->get();
        return ServicioResource::collection($servicios);
    }
}
