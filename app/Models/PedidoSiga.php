<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoSiga extends Model
{
    use HasFactory;
    protected $table = 'pedido_siga';
    protected $fillable = [
      'tipo',
      'nro_cmn',
      'descripcion',
      'consolidado',
      'codigo_ejecutora',
      'fecha_pedido',
      'ano_eje',
      'estado',       
    ];
}
