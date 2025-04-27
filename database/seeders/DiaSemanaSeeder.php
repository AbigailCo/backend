<?php

namespace Database\Seeders;

use App\Models\DiaSemana;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiaSemanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DiaSemana::firstOrCreate(
            ['id' => 0],
            [
                'nombre' => 'Domingo',
                'label' => 'Domingo',
                'value' => 'dom',
                'descripcion' => 'Dia domingo'
            ]
        );
        DiaSemana::firstOrCreate(
            ['id' => 1],
            [
                'nombre' => 'Lunes',
                'label' => 'Lunes',
                'value' => 'lun',
                'descripcion' => 'Dia lunes'
            ]
        );
        DiaSemana::firstOrCreate(
            ['id' => 2],
            [
                'nombre' => 'Martes',
                'label' => 'Martes',
                'value' => 'mar',
                'descripcion' => 'Dia martes'
            ]
        );

        DiaSemana::firstOrCreate(
            ['id' => 3],
            [
                'nombre' => 'Miercoles',
                'label' => 'Miercoles',
                'value' => 'mier',
                'descripcion' => 'Dia miercoles'
            ]
        );

        DiaSemana::firstOrCreate(
            ['id' => 4],
            [
                'nombre' => 'Jueves',
                'label' => 'Jueves',
                'value' => 'juev',
                'descripcion' => 'Dia jueves'
            ]
        );

        DiaSemana::firstOrCreate(
            ['id' => 5],
            [
                'nombre' => 'Viernes',
                'label' => 'Viernes',
                'value' => 'vier',
                'descripcion' => 'Dia viernes'
            ]
        );

        DiaSemana::firstOrCreate(
            ['id' => 6],
            [
                'nombre' => 'Sabado',
                'label' => 'Sabado',
                'value' => 'sab',
                'descripcion' => 'Dia sabado'
            ]
        );

       
    }
}
