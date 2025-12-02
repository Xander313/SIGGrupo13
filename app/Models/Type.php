<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'TipoAtraccion';
    protected $primaryKey = 'IdTipoAtraccion';
    public $timestamps = false;

    protected $fillable = [
        'NombreTipoAtraccion',
        'NivelPopularidad',
        'RequiereGuia'
    ];

    public function zones()
    {
        return $this->hasMany(Zone::class, 'IdTipoAtraccion', 'IdTipoAtraccion');
    }
}
