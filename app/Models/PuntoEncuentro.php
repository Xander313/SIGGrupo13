<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntoEncuentro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'capacidad',
        'latitud',
        'longitud',
        'responsable'
    ];

    protected $casts = [
        'capacidad' => 'integer',
        'latitud' => 'float',
        'longitud' => 'float'
    ];
}