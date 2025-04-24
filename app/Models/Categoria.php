<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'label',
        'value',
        'descripcion',
    ];

    public function producto()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    } 
    public function servicio()
    {
        return $this->hasMany(Servicio::class, 'servicio_id');
    } 
    public function solicitid()
    {
        return $this->hasMany(Solicitud::class, 'solicitud_id');
    } 
}
