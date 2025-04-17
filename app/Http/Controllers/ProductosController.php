<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstadoGeneral;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function getProductos()
    {
        $productos = Producto::with('categoria')->get()->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'codigo' => $producto->codigo,
                'precio' => $producto->precio,
                'stock' => $producto->stock,
                'stock_minimo' => $producto->stock_minimo,
                'fecha_vencimiento' => $producto->fecha_vencimiento,
                'estado_general_id' => $producto->estado_general_id,
                'categoria_id' => $producto->categoria_id,
                'categoria' => $producto->categoria ? [
                    'id' => $producto->categoria->id,
                    'nombre' => $producto->categoria->nombre,
                    'label' => $producto->categoria->label,
                    'value' => $producto->categoria->value,
                    'descripcion' => $producto->categoria->descripcion,
                ] : null,
            ];
        });
        return response()->json($productos);
    }

    public function getProductosHabi()
    {
        $productos = Producto::with('categoria')->where('estado_general_id', 1)->get()->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->descripcion,
                'codigo' => $producto->codigo,
                'precio' => $producto->precio,
                'stock' => $producto->stock,
                'stock_minimo' => $producto->stock_minimo,
                'fecha_vencimiento' => $producto->fecha_vencimiento,
                'estado_general_id' => $producto->estado_general_id,
                'categoria_id' => $producto->categoria_id,
                'categoria' => $producto->categoria ? [
                    'id' => $producto->categoria->id,
                    'nombre' => $producto->categoria->nombre,
                    'label' => $producto->categoria->label,
                    'value' => $producto->categoria->value,
                    'descripcion' => $producto->categoria->descripcion,
                ] : null,
            ];
        });
        return response()->json($productos);
    }

    public function getProducto($id)
    {
        $producto = Producto::findOrFail($id);
        return [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'codigo' => $producto->codigo,
            'precio' => $producto->precio,
            'stock' => $producto->stock,
            'stock_minimo' => $producto->stock_minimo,
            'fecha_vencimiento' => $producto->fecha_vencimiento,
            'estado_general_id' => $producto->estado_general_id,
            'categoria_id' => $producto->categoria_id,
            // 'categoria' => $producto->categoria ? [
            //     'id' => $producto->categoria->id,
            //     'nombre' => $producto->categoria->nombre,
            //     'label' => $producto->categoria->label,
            //     'value' => $producto->categoria->value,
            //     'descripcion' => $producto->categoria->descripcion,
            // ] : null,
        ];
    }

    public function storeProducto(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'codigo' => 'required|string|max:255|unique:productos,codigo',
            'precio' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'fecha_vencimiento' => 'nullable|date',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);
        $estadoActivo = EstadoGeneral::where('value', 'act')->first();
        $producto = Producto::create($validatedData);

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'producto' => $producto,
        ]);
    }

    public function disableProd($id)
    {
        $user = Producto::findOrFail($id);
        $user->estado_general_id = 2; 
        $user->save();
    
        return response()->json(['message' => 'Producto deshabilitado correctamente.']);
        
    }
    public function enableProd($id)
    {
        $user = Producto::findOrFail($id);
        $user->estado_general_id = 1; 
        $user->save();
    
        return response()->json(['message' => 'Producto habilitado correctamente.']);
        
    }

    public function editProducto(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'codigo' => 'required|string|max:255|unique:productos,codigo,' . $producto->id,
            'precio' => 'nullable|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'fecha_vencimiento' => 'nullable|date',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);

        $producto->update($validatedData);

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'producto' => $producto,
        ]);
    }
}
