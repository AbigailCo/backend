<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
        'precio',
        'stock',
        'stock_minimo',
        'fecha_vencimiento',
        'categoria_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    public function estado()
    {
        return $this->belongsTo(EstadoGeneral::class, 'estado_general_id');
    }
    public function proveedor()
      {
          return $this->belongsTo(User::class, 'proveedor_id');
      }
}
