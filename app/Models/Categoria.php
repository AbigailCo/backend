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
}
