<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riesgo extends Model
{
    //
    protected $fillable = [
        'nombre',
        'radio',
        'latitud',
        'longitud',
        'tipo_seguridad',
    ];
}
