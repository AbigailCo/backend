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
    }
}
