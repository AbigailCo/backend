<?php

namespace App\Http\Controllers;

use App\Models\EstadoGeneral;
use App\Models\Reserva;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class ReservasController extends Controller
{
    public function storeReserva(Request $request)
    {
        $validatedData = $request->validate([
            'proveedor_id' => 'nullable|exists:users,id',
            'cliente_id' => 'nullable|exists:users,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);
        $estadoActivo = EstadoGeneral::where('value', 'pend')->first();

        $yaReservado = Reserva::where('proveedor_id', $request->proveedor_id)
            ->where('fecha_inicio', '<', $request->fecha_fin)
            ->where('fecha_fin', '>', $request->fecha_inicio)
            ->exists();

        if ($yaReservado) {
            return response()->json(['error' => 'El horario ya está reservado.'], 409);
        }

       $reserva = Reserva::create($validatedData);

        return response()->json([
            'message' => 'Reserva creada exitosamente',
            'solicitud' => $reserva,
        ]);
    }
}
