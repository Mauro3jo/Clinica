<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialClinico extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'primera_consulta',
        'bajo_atencion_medica',
        'enfermedad_grave',
        'enfermedades',
        'medicacion',
        'cual_medicacion',
        'aspirinas',
        'embarazo',
        'problemas_dentales_previos',
        'fuma',
        'observaciones',
    ];

    protected $casts = [
        'enfermedades' => 'array',
        'bajo_atencion_medica' => 'boolean',
        'enfermedad_grave' => 'boolean',
        'medicacion' => 'boolean',
        'aspirinas' => 'boolean',
        'embarazo' => 'boolean',
        'problemas_dentales_previos' => 'boolean',
        'fuma' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
