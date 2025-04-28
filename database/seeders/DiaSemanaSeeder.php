<?php

namespace Database\Seeders;

use App\Models\DiaSemana;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DiaSemanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dias_semana')->upsert(
            [
              ['id'=> 0,'nombre'=>'Domingo',   'label'=>'Domingo',   'value'=>'dom',  'descripcion'=>'Dia domingo'],
              ['id'=> 1,'nombre'=>'Lunes',     'label'=>'Lunes',     'value'=>'lun',  'descripcion'=>'Dia lunes'],
              ['id'=> 2,'nombre'=>'Martes',    'label'=>'Martes',    'value'=>'mar',  'descripcion'=>'Dia martes'],
              ['id'=> 3,'nombre'=>'Miércoles', 'label'=>'Miércoles', 'value'=>'mier','descripcion'=>'Dia miércoles'],
              ['id'=> 4,'nombre'=>'Jueves',    'label'=>'Jueves',    'value'=>'juev','descripcion'=>'Dia jueves'],
              ['id'=> 5,'nombre'=>'Viernes',   'label'=>'Viernes',   'value'=>'vier','descripcion'=>'Dia viernes'],
              ['id'=> 6,'nombre'=>'Sábado',    'label'=>'Sábado',    'value'=>'sab',  'descripcion'=>'Dia sábado'],
            ],
            ['id'],  // columna(es) para detectar duplicados
            ['nombre','label','value','descripcion']  // columnas a actualizar
        );

       
    }
}
