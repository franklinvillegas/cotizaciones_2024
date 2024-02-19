<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionPropuesta extends Model
{
    use HasFactory;
    protected $table = 'cotizacion_propuesta';
    protected $fillable = [
        'estado',
        'fecha_propuestas',
        'cotizacion_archivo',
        'cotizacion_ficharuc',
        'cotizacion_rnp',
        'cotizacion_cci',
        'cotizacion_anexo',
        'documento1',
        'documento2',
        'garantia',
        'igv',
        'forma_pago',
        'tipo_moneda',
        'plazo_entrega',
        'validez',
        'total',
        'ganador',
        'id_publicacion',
        'id_proveedor',
        'created_at',
        'updated_at',
    ];
    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id');
    }
    public function detallePropuesta(){
        return $this->hasMany(detallePropuesta::class, 'id_propuesta', 'id');
    } 
}
