<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaSemana extends Model
{
    
    protected $table = 'dias_semana';

    protected $fillable = [
        'nombre',
        'label',
        'value',
        'descripcion',
    ];
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_dia');
    }
}
