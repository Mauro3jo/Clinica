<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'apellido',
        'nombre',
        'dni',
        'sexo',
        'fecha_nacimiento',
        'obra_social',
        'afiliado_nro',
        'parentesco',
        'titular',
        'domicilio',
        'telefono',
        'servicio',
    ];

    public function historialClinico()
    {
        return $this->hasOne(HistorialClinico::class);
    }

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class);
    }

    public function planesTratamiento()
    {
        return $this->hasMany(PlanTratamiento::class);
    }
}
