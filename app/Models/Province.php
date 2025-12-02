<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'Provincia';
    protected $primaryKey = 'IdProvincia';
    public $timestamps = false;

    protected $fillable = [
        'NombreProvincia',
        'Capital',
        'Poblacion',
        'ClimaPredominante'
    ];

    public function zones()
    {
        return $this->hasMany(Zone::class, 'IdProvincia', 'IdProvincia');
    }
}
