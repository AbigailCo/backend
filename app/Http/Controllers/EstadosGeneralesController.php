<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EstadosGenerales\EstadosGeneralesResource;
use App\Models\EstadoGeneral;
use Illuminate\Http\Request;

class EstadosGeneralesController extends Controller
{
    public function getEstados()
    {
        $estados = EstadoGeneral::all();
        return EstadosGeneralesResource::collection($estados);
    }
}
