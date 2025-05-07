<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Servicio\ServicioEditRequest;
use App\Http\Requests\Servicio\ServicioFiltroRequest;
use App\Http\Requests\Servicio\ServicioStoreRequest;
use App\Http\Resources\Servicio\ServicioResource;
use App\Models\EstadoGeneral;
use App\Models\Reserva;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    public function getServicios()
    {
        $servicios = Servicio::with('categoria', 'proveedor', 'estadoGeneral')->get();
        return ServicioResource::collection($servicios);
    }

    public function getServicio($id)
    {
        $servicio = Servicio::with('categoria', 'proveedor', 'estadoGeneral', 'diasDisponibles')->findOrFail($id);
        return new ServicioResource($servicio);
    }

    public function editServicio(ServicioEditRequest $request, $id)
    {
        $servicio = Servicio::findOrFail($id);

        $validatedData = $request->validated();

        $servicio->update($validatedData);
        $servicio->diasDisponibles()->sync($request->input('dias_disponibles', []));

        return response()->json([
            'message' => 'Servicio actualizado exitosamente',
            'servicio' => new ServicioResource($servicio),
        ]);
    }

    public function getServiciosHabi()
    {
        $servicios = Servicio::with('categoria', 'proveedor', 'estadoGeneral', 'diasDisponibles')
            ->where('estado_general_id', 1)
            ->where(function ($query) {
                $query->where('categoria_id', '!=', 4)
                      ->orWhere(function ($q) {
                          $q->where('categoria_id', 4)
                            ->whereDate('fecha_vencimiento', '>=', now());
                      });
            })
            ->get();
        return response()->json(ServicioResource::collection($servicios));
    }
    public function storeServicio(ServicioStoreRequest $request)
    {
        $validated = $request->validated();
        $estadoActivo = EstadoGeneral::where('value', 'act')->first();
        $data = [
            ...$validated,
            'estado_general_id' => $estadoActivo->id,
            'horarios' => $validated['horarios'] ?? [],
        ];

        if (isset($validated['categoria_id']) && $validated['categoria_id'] == 5) {
            $data['fecha_inicio'] = $validated['fecha_inicio'];
            $data['fecha_fin'] = $validated['fecha_fin'];
        }

        $servicio = Servicio::create($data);

        if (!empty($validated['dias_disponibles'])) {
            $servicio->diasDisponibles()->sync($validated['dias_disponibles']);
        }

        return response()->json([
            'message' => 'Servicio creado exitosamente',
            'servicio' => new ServicioResource($servicio),
        ]);
    }

    public function disableServ($id)
    {
        $user = Servicio::findOrFail($id);
        $user->estado_general_id = 2;
        $user->save();

        return response()->json(['message' => 'Servicio deshabilitado correctamente.']);
    }
    public function enableServ($id)
    {
        $user = Servicio::findOrFail($id);
        $user->estado_general_id = 1;
        $user->save();

        return response()->json(['message' => 'Servicio habilitado correctamente.']);
    }
    public function filtroServi(ServicioFiltroRequest $request)
    {
        $servicios = Servicio::with(['proveedor', 'estadoGeneral', 'categoria', 'diasDisponibles'])
            ->filtrar($request->validated())
            ->get();

        return response()->json(ServicioResource::collection($servicios));
    }
}
