<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstadoGeneral;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    public function getServicios()
    {
        $servicios = Servicio::with('categoria')->get()->map(function ($servicio) {
            return [
                'id' => $servicio->id,
                'nombre' => $servicio->nombre,
                'descripcion' => $servicio->descripcion,
                'codigo' => $servicio->codigo,
                'precio' => $servicio->precio,
                'stock' => $servicio->stock,
                'stock_minimo' => $servicio->stock_minimo,
                'fecha_vencimiento' => $servicio->fecha_vencimiento,
                'categoria_id' => $servicio->categoria_id,
                'estado_general_id' => $servicio->estado_general_id,
                'categoria' => $servicio->categoria ? [
                    'id' => $servicio->categoria->id,
                    'nombre' => $servicio->categoria->nombre,
                    'label' => $servicio->categoria->label,
                    'value' => $servicio->categoria->value,
                    'descripcion' => $servicio->categoria->descripcion,
                ] : null,
            ];
        }); 
        return response()->json($servicios);
    }

    public function getServicio($id)
    {
        $servicio = Servicio::findOrFail($id);   
         return [
                'id' => $servicio->id,
                'nombre' => $servicio->nombre,
                'descripcion' => $servicio->descripcion,
                'codigo' => $servicio->codigo,
                'precio' => $servicio->precio,
                'stock' => $servicio->stock,
                'stock_minimo' => $servicio->stock_minimo,
                'fecha_vencimiento' => $servicio->fecha_vencimiento,
                'estado_general_id' => $servicio->estado_general_id,
                'categoria_id' => $servicio->categoria_id,
                // 'categoria' => $servicio->categoria ? [
                //     'id' => $servicio->categoria->id,
                //     'nombre' => $servicio->categoria->nombre,
                //     'label' => $servicio->categoria->label,
                //     'value' => $servicio->categoria->value,
                //     'descripcion' => $servicio->categoria->descripcion,
                // ] : null,
            ];
    }

    public function editServicio(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id);

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'codigo' => 'required|string|max:255|unique:productos,codigo,' . $servicio->id,
            'precio' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'fecha_vencimiento' => 'nullable|date',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $servicio->update($validatedData);

        return response()->json([
            'message' => 'Servicio actualizado exitosamente',
            'servicio' => $servicio,
        ]);
    }
    public function storeServicio(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'codigo' => 'required|string|max:255|unique:servicios,codigo',
            'precio' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'fecha_vencimiento' => 'nullable|date',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);
        $estadoActivo = EstadoGeneral::where('value', 'act')->first();
        $servicio = Servicio::create($validatedData);

        return response()->json([
            'message' => 'Servicio creado exitosamente',
            'servicios' => $servicio,
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
}
