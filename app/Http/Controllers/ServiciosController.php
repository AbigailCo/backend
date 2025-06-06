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
        $servicios = Servicio::with('categoria', 'proveedor', 'estadoGeneral')->get()->map(function ($servicio) {
            return [
                'servicio' => $servicio ? [
                    'id' => $servicio->id,
                    'nombre' => $servicio->nombre,
                    'codigo' => $servicio->codigo,
                    'stock' => $servicio->stock,
                    'stock_minimo' => $servicio->stock_minimo,
                    'precio' => $servicio->precio,
                    'descripcion' => $servicio->descripcion,
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

    public function getServicio($id)
    {
        $servicio = Servicio::with('categoria', 'proveedor', 'estadoGeneral')->findOrFail($id);   
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

    public function getServiciosHabi()
    {
        $servicios = Servicio::with('categoria', 'proveedor', 'estadoGeneral')->where('estado_general_id', 1)->get()->map(function ($servicio) {
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
    public function filtroServi(Request $request)
    {
        $query = Servicio::query();
        $filtros = $request->all();


        foreach ($filtros as $campo => $valor) {
            switch ($campo) {
                case 'nombre':
                    $query->where('nombre', 'like', "%$valor%");
                    break;
                
                case 'codigo':
                    $query->where('codigo', 'like', "%$valor%");
                    break;
                
                case 'stock_minimo':
                    $query->where('stock_minimo', $valor);
                    break;
                case 'estado_general':
                    $query->where('estado_general_id', 'like', "%$valor%");
                    break;

                case 'fecha_vencimiento':
                    $query->whereDate('fecha_vencimiento', $valor);
                    break;

                case 'servicio_id':
                    $query->where('id', $valor);
                    break;

            }
        }

        $resultados = $query->with(['proveedor', 'estadoGeneral', 'categoria'])->get();

        $datosFiltrados = $resultados->map(function ($servicio) {
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

        return response()->json($datosFiltrados);
    }
}
