<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstadoGeneral;
use Illuminate\Http\Request;

class EstadosGeneralesController extends Controller
{
    public function getEstados()
    {
        $estados = EstadoGeneral::all()
            ->map(function ($estado) {
                return [
                    'id' => $estado->id,
                    'nombre' => $estado->nombre,
                    'descripcion' => $estado->descripcion,
                
                ];
            });

        return response()->json($estados);
    }
}
