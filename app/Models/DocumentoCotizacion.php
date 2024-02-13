<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoCotizacion extends Model
{
    use HasFactory;
    protected $table = 'documento_cotizacion';
    protected $fillable = [
        'descripcion',
        'url_documento',
        'id_publicacion',      
    ];
    
}
