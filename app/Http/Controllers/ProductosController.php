<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        $producto = Producto::create($validatedData);

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'producto' => $producto,
        ]);
    }
}
