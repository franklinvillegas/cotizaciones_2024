<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedidoSiga extends Model
{
    use HasFactory;
    protected $table = 'detalle_pedido_siga';
    protected $fillable = [
        'cantidad',
        'unidad_medida',
        'descripcion',
        'precio_unitario',
        'precio_total',
        'id_pedido',
        'especificaciones',       
    ];
    public function detallePropuesta(){
        return $this->hasMany(DetallePropuesta::class, 'descripcion', 'id');
    }
}
