<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $table = 'LugarTuristico_2FN';
    protected $primaryKey = 'IdLugarTuristico';
    public $timestamps = false;

    protected $fillable = [
        'NombreLugar',
        'IdProvincia',
        'IdTipoAtraccion',
        'Latitud',
        'Longitud',
        'Descripcion',
        'AnioCreacion',
        'Accesibilidad'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'IdProvincia', 'IdProvincia');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'IdTipoAtraccion', 'IdTipoAtraccion');
    }
}
