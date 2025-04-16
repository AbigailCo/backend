<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoGeneral extends Model
{
    use HasFactory;

    protected $table = 'estados_generales';

    protected $fillable = [
        'nombre',
        'label',
        'value',
        'descripcion',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'estado_general_id');
    }
}
