<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'fecha',
        'codigo',
        'pieza_dental',
        'ubicacion_lesion',
        'arancel',
        'pago',
        'debe',
        'saldo',
        'conducta_rx',
        'trabajo_realizado',
        'observaciones',
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
