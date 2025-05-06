<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EstadosGenerales\EstadosGeneralesResource;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function getCategorias()
    {
        $categorias = Categoria::all();

        return EstadosGeneralesResource::collection($categorias);
    }
}
