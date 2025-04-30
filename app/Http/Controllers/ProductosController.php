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
                'producto' => $producto ? [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'codigo' => $producto->codigo,
                    'stock' => $producto->stock,
                    'stock_minimo' => $producto->stock_minimo,
                    'precio' => $producto->precio,
                    'descripcion' => $producto->descripcion,
                    'proveedor_id' => $producto->proveedor_id,
                    'fecha_vencimiento' => $producto->fecha_vencimiento
                ] : null,

                'proveedor' => $producto->proveedor ? [
                    'nombre' => $producto->proveedor->name,
                    'contacto' => $producto->proveedor->email,
                    'proveedor_id' => $producto->proveedor->id,
                ] : null,
                'categoria' => $producto->categoria ? [
                    'nombre' => $producto->categoria->nombre,
                    'descripcion' => $producto->categoria->descripcion,
                ] : null,


                'estado' => $producto->estado ? [
                    'id' => $producto->estado->id,
                    'nombre' => $producto->estado->nombre,
                ] : null,
            ];
        });
        return response()->json($productos);
    }

    public function getProductosHabi()
    {
        $productos = Producto::with('categoria', 'proveedor', 'estado')
        ->where('estado_general_id', 1)
        ->where('fecha_vencimiento', '>=', now())
        ->get()->map(function ($producto) {
            return [
               'producto' => $producto ? [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'codigo' => $producto->codigo,
                    'stock' => $producto->stock,
                    'stock_minimo' => $producto->stock_minimo,
                    'precio' => $producto->precio,
                    'descripcion' => $producto->descripcion,
                    'proveedor_id' => $producto->proveedor_id,
                    'fecha_vencimiento' => $producto->fecha_vencimiento
                ] : null,

                'proveedor' => $producto->proveedor ? [
                    'nombre' => $producto->proveedor->name,
                    'contacto' => $producto->proveedor->email,
                    'proveedor_id' => $producto->proveedor->id,
                ] : null,
                'categoria' => $producto->categoria ? [
                    'nombre' => $producto->categoria->nombre,
                    'descripcion' => $producto->categoria->descripcion,
                ] : null,


                'estado' => $producto->estado ? [
                    'id' => $producto->estado->id,
                    'nombre' => $producto->estado->nombre,
                ] : null,
            ];
        });
        return response()->json($productos);
    }

    public function getProducto($id)
    {
        $producto = Producto::findOrFail($id);
        return [
            'producto' => $producto ? [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'codigo' => $producto->codigo,
                'stock' => $producto->stock,
                'stock_minimo' => $producto->stock_minimo,
                'precio' => $producto->precio,
                'descripcion' => $producto->descripcion,
                'proveedor_id' => $producto->proveedor_id,
            ] : null,

            'proveedor' => $producto->proveedor ? [
                'nombre' => $producto->proveedor->name,
                'contacto' => $producto->proveedor->email,
                'proveedor_id' => $producto->proveedor->id,
            ] : null,
            'categoria' => $producto->categoria ? [
                'nombre' => $producto->categoria->nombre,
                'descripcion' => $producto->categoria->descripcion,
            ] : null,


            'estado' => $producto->estado ? [
                'id' => $producto->estado->id,
                'nombre' => $producto->estado->nombre,
            ] : null,
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

    public function filtroProdu(Request $request)
    {
        $query = Producto::query();
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

                case 'producto_id':
                    $query->where('id', $valor);
                    break;

            }
        }

        $resultados = $query->with(['proveedor', 'estado', 'categoria'])->get();

        $datosFiltrados = $resultados->map(function ($producto) {
            return [
                'producto' => $producto ? [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'codigo' => $producto->codigo,
                    'stock' => $producto->stock,
                    'stock_minimo' => $producto->stock_minimo,
                    'precio' => $producto->precio,
                    'descripcion' => $producto->descripcion,
                    'proveedor_id' => $producto->proveedor_id,
                ] : null,

                'proveedor' => $producto->proveedor ? [
                    'nombre' => $producto->proveedor->name,
                    'contacto' => $producto->proveedor->email,
                    'proveedor_id' => $producto->proveedor->id,
                ] : null,
                'categoria' => $producto->categoria ? [
                    'nombre' => $producto->categoria->nombre,
                    'descripcion' => $producto->categoria->descripcion,
                ] : null,


                'estado' => $producto->estado ? [
                    'id' => $producto->estado->id,
                    'nombre' => $producto->estado->nombre,
                ] : null,
            ];
        });

        return response()->json($datosFiltrados);
    }
}
