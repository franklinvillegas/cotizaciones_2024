<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'proveedor';
    protected $fillable = [
        'tipo',
        'razon_social',
        'ruc',
        'correo',
        'telefono1',
        'telefono2',
        'created_at',
        'updated_at',
    ];
    
}
