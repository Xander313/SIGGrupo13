<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZonaSegura extends Model
{
    protected $fillable = [
        'nombre',
        'radio',
        'latitud',
        'longitud',
        'tipo_seguridad',
    ];
}
