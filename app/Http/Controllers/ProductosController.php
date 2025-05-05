<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Producto\ProductoEditRequest;
use App\Http\Requests\Producto\ProductoFiltroRequest;
use App\Http\Requests\Producto\ProductoStoreRequest;
use App\Http\Resources\Producto\ProductoResource;
use App\Models\EstadoGeneral;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
  
    public function getProductos()
    {
        $productos = Producto::with('categoria', 'proveedor', 'estado')->get();
        return ProductoResource::collection($productos);
    }

    public function getProductosHabi()
    {
        $productos = Producto::with('categoria', 'proveedor', 'estado')
            ->where('estado_general_id', 1)
            ->where('fecha_vencimiento', '>=', now())
            ->get();
            return response()->json(ProductoResource::collection($productos));
    }

    public function getProducto($id)
    {
        $producto = Producto::with('categoria', 'proveedor', 'estado')->findOrFail($id);
        return new ProductoResource($producto);
    }

    public function storeProducto(ProductoStoreRequest $request)
    {
        $validatedData = $request->validated();
        $estadoActivo = EstadoGeneral::where('value', 'act')->first();
        $producto = Producto::create([
            ...$validatedData,
            'proveedor_id' => $request->input('proveedor_id'),
            'estado_general_id' => $estadoActivo?->id ?? 1, 
        ]);

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'producto' => new ProductoResource($producto),
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

    public function editProducto(ProductoEditRequest $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $validatedData = $request->validated();

        $producto->update($validatedData);

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'producto' => new ProductoResource($producto),
        ]);
    }

    public function filtroProdu(ProductoFiltroRequest $request)
    {
        $productos = Producto::with(['proveedor', 'estado', 'categoria'])
            ->filtrar($request->validated())
            ->get();

        return response()->json(ProductoResource::collection($productos));
    }
}
