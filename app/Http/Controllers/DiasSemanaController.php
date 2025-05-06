<?php

namespace App\Http\Controllers;

use App\Http\Resources\EstadosGenerales\EstadosGeneralesResource;
use App\Models\DiaSemana;
use Illuminate\Http\Request;

class DiasSemanaController extends Controller
{
    public function getDias()
    {
        $diasSemana = DiaSemana::all();

        return EstadosGeneralesResource::collection($diasSemana);
    }
}
