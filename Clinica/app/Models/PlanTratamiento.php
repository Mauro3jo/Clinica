<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanTratamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'fecha',
        'dientes_afectados',
        'referencias',
        'tratamientos_previos',
        'tratamientos_propuestos',
        'firma',
    ];

    protected $casts = [
        'dientes_afectados' => 'array',
        'referencias' => 'array',
        'tratamientos_previos' => 'array',
        'tratamientos_propuestos' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
