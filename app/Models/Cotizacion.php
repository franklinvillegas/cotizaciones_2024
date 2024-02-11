<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    protected $table = 'cotizacion';
    protected $fillable = [
        'nro_cotizacion',
        'ano_eje',
        'estado',
        'id_pedido',
    ];

    public function pedidoSiga(){
        return $this->belongsTo(PedidoSiga::class, 'id_pedido', 'id');
    }

    public function pedidoSiga2(){
        return $this->belongsTo(PedidoSiga::class, 'id_pedido', 'id');
    }
    public function publicacionCotizacion(){
        return $this->hasOne(PublicacionCotizacion::class, 'id_cotizacion', 'id');
    }
}
