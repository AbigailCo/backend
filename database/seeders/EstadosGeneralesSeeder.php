<?php

namespace Database\Seeders;

use App\Models\EstadoGeneral;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosGeneralesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EstadoGeneral::firstOrCreate(
            ['id' => 1],
            ['nombre' => 'Activo', 'label' => 'Activo', 'value' => 'act', 'descripcion' => 'Usuario habilitado']
        );
    
        EstadoGeneral::firstOrCreate(
            ['id' => 2],
            ['nombre' => 'Inactivo', 'label' => 'Inactivo', 'value' => 'ina', 'descripcion' => 'Usuario deshabilitado']
        );
    
        EstadoGeneral::firstOrCreate(
            ['id' => 3],
            ['nombre' => 'Eliminado', 'label' => 'Eliminado', 'value' => 'eli', 'descripcion' => 'Usuario eliminado lógicamente']
        );
        EstadoGeneral::firstOrCreate(
            ['id' => 4],
            ['nombre' => 'Pendiente', 'label' => 'Pendiente', 'value' => 'pend', 'descripcion' => 'Solicitud pendiente de respuesta']
        );
        EstadoGeneral::firstOrCreate(
            ['id' => 5],
            ['nombre' => 'Aprobada', 'label' => 'Aprobada', 'value' => 'apro', 'descripcion' => 'Solicitud aprobada']
        );
        EstadoGeneral::firstOrCreate(
            ['id' => 6],
            ['nombre' => 'Rechazada', 'label' => 'Rechazada', 'value' => 'recha', 'descripcion' => 'Solicitud rechazada']
        );
        EstadoGeneral::firstOrCreate(
            ['id' => 7],
            ['nombre' => 'Cancelada', 'label' => 'Cancelada', 'value' => 'cancel', 'descripcion' => 'Solicitud cancelada']
        );
    }
}
