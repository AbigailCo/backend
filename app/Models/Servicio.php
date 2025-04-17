<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
      // use HasFactory;

      protected $table = 'servicios';

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
     
      public function estadoGeneral()
      {
          return $this->belongsTo(EstadoGeneral::class, 'estado_general_id');
      }
}
