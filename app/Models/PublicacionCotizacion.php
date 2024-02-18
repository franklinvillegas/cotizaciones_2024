<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicacionCotizacion extends Model
{
    use HasFactory;
    protected $table = 'publicacion_cotizacion';
    protected $fillable = [
        'fecha_publicacion',
        'fecha_fin',
        'id_cotizacion',
    ];

    public function cotizacion(){
        return $this->belongsTo(Cotizacion::class, 'id_cotizacion', 'id');
    }
    public function documentoCotizacion(){
        return $this->hasMany(DocumentoCotizacion::class, 'id_publicacion', 'id');
    }
    public function cotizacionPropuesta(){
        return $this->hasMany(CotizacionPropuesta::class, 'id_publicacion', 'id');
    }
}
