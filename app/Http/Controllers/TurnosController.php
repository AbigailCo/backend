<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class TurnosController extends Controller
{
    public function getTurnos()
    {
        $servicios = Servicio::with('categoria', 'proveedor', 'estadoGeneral', 'diasDisponibles')
        ->where('estado_general_id', 1)
        ->where('categoria_id', 6)
        ->get()->map(function ($servicio) {
            return [
                'servicio' => $servicio ? [
                    'id' => $servicio->id,
                    'nombre' => $servicio->nombre,
                    'codigo' => $servicio->codigo,
                    'stock' => $servicio->stock,
                    'stock_minimo' => $servicio->stock_minimo,
                    'precio' => $servicio->precio,
                    'descripcion' => $servicio->descripcion,
                    'proveedor_id' => $servicio->proveedor_id,
                    'fecha_vencimiento' => $servicio->fecha_vencimiento,
                    'horarios' => $servicio->horarios,
                    'dias_disponibles' => $servicio->diasDisponibles ? $servicio->diasDisponibles->map(function ($dia) {
                        return [
                            'nombre' => $dia->nombre,
                            'value' => $dia->value,
                            'id' => $dia->id,
                        ];
                    }) : [],
                    'categoria' => $servicio->categoria ? [
                        'nombre' => $servicio->categoria->nombre,
                        'descripcion' => $servicio->categoria->descripcion,
                    ] : null,
                ] : null,

                'proveedor' => $servicio->proveedor ? [
                    'nombre' => $servicio->proveedor->name,
                    'contacto' => $servicio->proveedor->email,
                    'proveedor_id' => $servicio->proveedor->id,
                ] : null,
                'categoria' => $servicio->categoria ? [
                    'nombre' => $servicio->categoria->nombre,
                    'descripcion' => $servicio->categoria->descripcion,
                ] : null,



                'estado' => $servicio->estadoGeneral ? [
                    'id' => $servicio->estadoGeneral->id,
                    'nombre' => $servicio->estadoGeneral->nombre,
                ] : null,
            ];
        });
        return response()->json($servicios);
    }
    public function storeServicio(Request $request)
    {
        $validatedData = $request->validate([
            'proveedor_id' => 'nullable|exists:users,id',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'codigo' => 'required|string|max:255|unique:servicios,codigo',
            'precio' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'fecha_vencimiento' => 'nullable|date',
            'categoria_id' => 'nullable|exists:categorias,id',
            'tipo' => 'nullable|string|max:255',
            'duracion' => 'nullable|string|max:100',
            'ubicacion' => 'nullable|string|max:255',
            'horarios' => 'nullable|array',
            'horarios.*' => 'string|regex:/^\d{2}:\d{2}$/',
            'dias_disponibles' => 'nullable|array',
            'dias_disponibles.*' => 'integer|exists:dias_semana,id',
        ]);
        $estadoActivo = EstadoGeneral::where('value', 'act')->first();

        $servicio = Servicio::create([
            ...$validatedData,
            'estado_general_id' => $estadoActivo->id,
            'horarios' => json_encode($validatedData['horarios'] ?? []),
        ]);
        if (!empty($validatedData['dias_disponibles'])) {
            $servicio->diasDisponibles()->sync($validatedData['dias_disponibles']);
        }



        return response()->json([
            'message' => 'Servicio creado exitosamente',
            'servicios' => $servicio,
        ]);
    }
}
