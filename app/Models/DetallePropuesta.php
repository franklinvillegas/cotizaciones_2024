<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePropuesta extends Model
{
    use HasFactory;
    protected $table = 'detalle_propuesta';
    protected $fillable = [
        'id',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'precio_total',
        'id_propuesta',
        'created_at',
        'updated_at',

    ];

    public function cotizacionPropuesta(){
        return $this->belongsTo(cotizacionPropuesta::class, 'id_propuesta', 'id');
    }  
}
