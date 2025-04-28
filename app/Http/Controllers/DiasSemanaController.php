<?php

namespace App\Http\Controllers;

use App\Models\DiaSemana;
use Illuminate\Http\Request;

class DiasSemanaController extends Controller
{
    public function getDias()
    {
        $diasSemana = DiaSemana::all()
            ->map(function ($diaSemana) {
                return [
                    'id' => $diaSemana->id,
                    'nombre' => $diaSemana->nombre,
                    'descripcion' => $diaSemana->descripcion,
                
                ];
            });

        return response()->json($diasSemana);
    }
}
